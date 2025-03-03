<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Carbon\Carbon;

class inserttwitterfeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inserttwitterfeeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get twitter feeds from api and store the data in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $bearerToken = getenv('TWITTER_BEARER_TOKEN');

        try {
            $username = getenv('TWITTER_USERNAME');
            $maxResults = 100;

            // Step 1: Get the user ID using the username
            $userUrl = "https://api.twitter.com/2/users/by/username/{$username}";

            $userResponse = $client->get($userUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $bearerToken,
                ]
            ]);

            $userData = json_decode($userResponse->getBody(), true);
            if (!isset($userData['data']['id'])) {
                return ['error' => 'User not found'];
            }
            $userId = $userData['data']['id'];

            // Step 2: Fetch tweets with media, including videos
            $tweetsUrl = "https://api.twitter.com/2/users/{$userId}/tweets?max_results={$maxResults}&expansions=attachments.media_keys&media.fields=url,alt_text,type,variants&tweet.fields=created_at";

            $tweetsResponse = $client->get($tweetsUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $bearerToken,
                ]
            ]);

            $tweetsData = json_decode($tweetsResponse->getBody(), true);

            // Prepare media lookup map
            $mediaMap = [];
            if (isset($tweetsData['includes']['media'])) {
                foreach ($tweetsData['includes']['media'] as $media) {
                    $mediaMap[$media['media_key']] = $media;
                }
            }

            // Process each tweet to extract text, images, videos, and created time
            $formattedTweets = [];
            foreach ($tweetsData['data'] as $tweet) {
                $tweetText = $tweet['text'];
                $createdAt = $tweet['created_at'] ?? null;
                $imageUrls = [];
                $videoUrls = [];
                $urls = [];

                // Check if the tweet has media keys
                if (isset($tweet['attachments']['media_keys'])) {
                    foreach ($tweet['attachments']['media_keys'] as $mediaKey) {
                        if (isset($mediaMap[$mediaKey])) {
                            $mediaItem = $mediaMap[$mediaKey];

                            // Handle images
                            if ($mediaItem['type'] === 'photo') {
                                $imageUrls[] = $mediaItem['url'];
                            }

                            // Handle videos (including GIFs)
                            if (in_array($mediaItem['type'], ['video', 'animated_gif'])) {
                                // Twitter provides multiple variants, select the highest bitrate
                                if (isset($mediaItem['variants'])) {
                                    usort($mediaItem['variants'], function ($a, $b) {
                                        return ($b['bitrate'] ?? 0) - ($a['bitrate'] ?? 0);
                                    });
                                    $videoUrls[] = $mediaItem['variants'][0]['url'];
                                }
                            }
                        }
                    }
                }

                // Extract URLs from the tweet text
                preg_match_all('/https?\:\/\/[a-zA-Z0-9\-.\/?&%#=_]+/', $tweetText, $matches);
                if (isset($matches[0])) {
                    $urls = $matches[0];
                }

                // Add the tweet details to the formattedTweets array
                $formattedTweets[] = [
                    'text' => $tweetText,
                    'created_at' => $createdAt,
                    'images' => json_encode($imageUrls), // Convert images to JSON
                    'videos' => json_encode($videoUrls), // Convert videos to JSON
                    'urls' => json_encode($urls), // Convert URLs to JSON
                ];
            }
            DB::table('twitterposts')->delete();

            // Step 3: Insert the data into the database
            foreach ($formattedTweets as $tweet) {
                $postCreated = isset($tweet['created_at']) ? Carbon::parse($tweet['created_at'])->format('Y-m-d H:i:s') : null;

                DB::table('twitterposts')->insert([
                    'text' => extractString($tweet['text'], 'https'),
                    'images' => $tweet['images'],
                    'videos' => $tweet['videos'],  // Store video URLs
                    'urls' => $tweet['urls'],
                    'post_created' => $postCreated,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return $formattedTweets;

        } catch (\Exception $e) {
            print_pre($e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

}
