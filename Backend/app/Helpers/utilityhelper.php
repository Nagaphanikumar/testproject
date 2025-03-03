<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Abraham\TwitterOAuth\TwitterOAuth;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
/**
 * Debug function.
 * 
 * @param comma separated arguments
 * 
 * @return pre
 */
if (!function_exists('print_pre')) {

    function print_pre() {
        $queue = func_get_args();
        if (!empty($queue)) {
            foreach ($queue as $print) { {
                    if (defined('STDIN')) {
                        echo "\e[0;35m";
                        print_r($print);
                        echo "\e[0m\n";
                    } else {
                        echo '<pre>';
                        print_r($print);
                        echo "</pre>";
                    }
                }
            }
        }
    }
    
}

/**
 * Check if an array is empty or not.
 * 
 * @param array $array
 * 
 * @return boolean
 */

 if (!function_exists('not_empty')) {

    function not_empty($array) {
        if (is_array($array) && count($array) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Header seo tags function.
 * 
 * @param id
 * 
 * @return data
 */
if (!function_exists('seotags')) {

    function seotags($id = '') {
        if($id != ''){
            return DB::table('m_obj_hierarchy')->select('seo_title','seo_description','seo_keywords','image_name')->where('obj_id',$id)->get()->toArray();
        }else{
            return [];
        }        
    }

}

/**
 * Fetching facebook posts using facebook graph api
 * 
 * 
 * @return response
 */
// if (!function_exists('fetchFacebookFeeds')) {

//     function fetchFacebookFeeds() {
//         $facebookData = DB::table('facebookfeeds')->first();
//         if(!empty($facebookData)){
//             $accessToken = $facebookData->access_token;
//             $pageId = $facebookData->page_id;
//             $fields = 'posts{full_picture,created_time,permalink_url,message}';
//             $apiVersion = 'v21.0';
//             $url = "https://graph.facebook.com/$apiVersion/$pageId?fields=$fields&access_token=$accessToken";    
//             $ch = curl_init();
//             curl_setopt($ch, CURLOPT_URL, $url);
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//             $response = curl_exec($ch);
//             return $response;  
//         }else{
//             return [];
//         }   
//     }

// }


/**
 * short description for html data
 * 
 * 
 * @return html data
 */
if (!function_exists('shortHtmldesc')) {

    function shortHtmldesc($htmlContent = '',$limit = 100) { 
        if($htmlContent){
           $dataUpToWord = '';
           $filteredContent = strip_tags($htmlContent);
           if(strlen($filteredContent) <= $limit){
              return $htmlContent;
           }
           $limitedContent = Str::limit($filteredContent, $limit, ''); 
           $limitedChars = substr($limitedContent, -20);
           $position = strpos($htmlContent, $limitedChars);
           if ($position !== false) {
              $dataUpToWord = substr($htmlContent, 0, $position + strlen($limitedChars));           
           }
            // close opening html tags
           $dom = new DOMDocument();
           // Disable warnings related to malformed HTML (optional)
           libxml_use_internal_errors(true);
           // Ensure the string is UTF-8
           $dataUpToWord = mb_convert_encoding($dataUpToWord, 'HTML-ENTITIES', 'UTF-8');
           // Load HTML content
           $dom->loadHTML($dataUpToWord, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
           // Save the HTML back to a string
           $fixedHtml = $dom->saveHTML();
           // Decode HTML entities to their correct characters
           $fixedHtmlDecoded = html_entity_decode($fixedHtml, ENT_QUOTES, 'UTF-8');
           return $fixedHtmlDecoded;
        }else{
            return [];
        }
    }

}


/**
 * Remove all the characters from the string from the given word.
 * 
 * 
 * @return extracted string
 */
if (!function_exists('extractString')) {
    function extractString($string = '', $substring = '') {
        if($string != ''){
            if($substring != ''){
                // Find the position of the substring
                $position = strpos($string, $substring);

                // If the substring is found, extract the portion before it
                if ($position !== false) {
                    return substr($string, 0, $position);
                }
            }
            // If the substring is not found, return the original string
            return $string;
        }else{
            return [];
        }
    }
}


if (!function_exists('getNewAccessToken')) {
    function getNewAccessToken($userAccessToken) {
        $apiVersion = 'v21.0';
        $url = "https://graph.facebook.com/$apiVersion/me/accounts?access_token=$userAccessToken";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            return null;
        } else {
            $data = json_decode($response, true);
            if (isset($data['data'][0]['access_token'])) {
                return $data['data'][0]['access_token'];
            } else {
                echo 'No access token found.';
                return null;
            }
        }
        curl_close($ch);
    }
}

/**
 * Update the image path to point to the resized version if it exists.
 *
 * @param string $imagePath Original image path.
 * @return string Updated image path or original path if resized doesn't exist.
 */
if (!function_exists('changeImagepath')) {
    
    function changeImagepath($imagePath)
    {
        // Define the resized path
        $resizedPath = str_replace('images/', 'images/resized/', $imagePath);
       
        // return $resizedPath;
        // if (file_exists($resizedPath)) {
        //     return $resizedPath; // Return the resized path
        // }

        // Return the original path if resized version doesn't exist
        return $imagePath;
    }
}

/**
 * Converts a UTC time string to the browser's default time zone.
 *
 * @param string $utcTime - The UTC time string (e.g., '2025-01-20 15:30:00').
 * @param string $format - The desired output format (e.g., 'Y-m-d H:i:s A').
 * @return string|null - The converted time in the browser's time zone, or null on failure.
 */
function convertUtcToTimeZone($utcDateTime)
{
    // Get the time zone from the session (ensure the time zone is correctly set in session)
    $timeZone = Session::get('user_time_zone', 'UTC');  // Default to UTC if not set

    // Parse the UTC date time string into a Carbon instance with the UTC timezone
    try {
        $carbonDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $utcDateTime, 'UTC');
        
        // Convert to the user's time zone from session
        $convertedDateTime = $carbonDateTime->setTimezone($timeZone);

        // Return the converted time in 12-hour format with AM/PM
        return $convertedDateTime->format('Y-m-d h:i A');  // 12-hour format with AM/PM
    } catch (\Exception $e) {
        // Handle errors gracefully
        return 'Error: ' . $e->getMessage();
    }
}

/**
 * limit for the given string.
 * 
 * 
 * @return limited string
 */
if (!function_exists('charcterLimit')) {
    function charcterLimit($data = '',$limit = 100) {
       if($data != ''){
          // Remove tags from the given data
          $filteredData = strip_tags($data);
          return Str::limit($filteredData, $limit);
       }else{
          return [];
       }
        
    }
}




