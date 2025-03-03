<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
class insertfacebookfeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insertfacebookfeeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get facebook feeds from api and store that data in table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $userAccessToken = getenv('FACEBOOK_ACCESS_TOKEN');
        //  $accessToken = getNewAccessToken($userAccessToken);
        $facebookData = [
            'access_token' => getenv('FACEBOOK_ACCESS_TOKEN_LONG'),
            'page_id' => getenv('FACEBOOK_PAGEID'),
        ];

        // $fields = 'posts{full_picture,created_time,permalink_url,message}';
        $fields = 'posts{created_time,permalink_url,message,full_picture}';
        // $fields = 'posts{id,message,created_time,permalink_url,attachments{media},source}';
        // $fields = 'posts{id,message,created_time,permalink_url,full_picture,source}';
        $apiVersion = 'v21.0';
        $url = "https://graph.facebook.com/$apiVersion/{$facebookData['page_id']}?fields=$fields&access_token={$facebookData['access_token']}";
        // $url = "https://graph.facebook.com/v21.0/oauth/access_token?grant_type=fb_exchange_token&client_id=951467680380252&client_secret=8966fc82744102be23aff915b622b0db&fb_exchange_token=$userAccessToken";
        $videoFields = 'id,source,permalink_url,description,created_time';
        $videoUrl = "https://graph.facebook.com/$apiVersion/{$facebookData['page_id']}/videos?fields=$videoFields&access_token={$facebookData['access_token']}";
        
      

        try {
            // Fetch posts and videos
            $postResponse = file_get_contents($url);
            $videoResponse = file_get_contents($videoUrl);

            $postData = json_decode($postResponse, true);
            $videoData = json_decode($videoResponse, true);

            // Prepare merged array
            $mergedPosts = [];

                // Step 1: Store posts in an array with created_time as the key
                if (isset($postData['posts']['data'])) {
                    foreach ($postData['posts']['data'] as $post) {
                        $createdTime = substr($post['created_time'], 0, 16); // Keep only date and hour (ignore seconds)

                        $mergedPosts[$createdTime] = [
                            'post_id' => $post['id'],
                            'full_picture' => $post['full_picture'] ?? null,
                            'permalink_url' => $post['permalink_url'],
                            'message' => $post['message'] ?? null,
                            'created_time' => $post['created_time'],
                            'videos' => [], // Placeholder for videos
                        ];
                    }
                }
                // Step 2: Match videos to posts using created_time
                if (isset($videoData['data'])) {
                    foreach ($videoData['data'] as $video) {
                        $videoCreatedTime = substr($video['created_time'], 0, 16); // Keep only date and hour

                        if (isset($mergedPosts[$videoCreatedTime])) {
                            $mergedPosts[$videoCreatedTime]['videos'][] = [
                                'video_id' => $video['id'],
                                'source' => $video['source'],
                            ];
                        }
                    }
                }
            if(isset($mergedPosts)){
                DB::table('facebook_posts')->delete();
                // dd($mergedPosts);
                if ($mergedPosts) {
                    foreach ($mergedPosts as $post) {
                            $postCreated = isset($post['created_time']) ? Carbon::parse($post['created_time'])->format('Y-m-d H:i:s') : null;
                             // Convert videos array to JSON
                           $videosJson = !empty($post['videos']) ? json_encode($post['videos']) : null;
                            DB::table('facebook_posts')->insert([
                                'full_picture' => $post['full_picture'],
                                'permalink_url' => $post['permalink_url'],
                                'message' => $post['message'],
                                'videos' => $videosJson,
                                'post_created' => $postCreated,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                    }
    
                    $this->info('Facebook posts inserted successfully.');
                    
                } else {
                    $this->error('No posts found in the Facebook API response.');
                }
            }else{
                $this->error("Api response error");
            }
            
        } catch (\Exception $e) {
            $this->error('Error fetching data: ' . $e->getMessage());
        }
    }
}
