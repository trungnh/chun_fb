<?php 
ini_set('display_errors', 1);
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/youtube_download.php";
echo "<pre>";
$video_code = "hoXvwWG6wBs"; 

$youtube = new Youtube;
$source = $youtube->getFileName($video_code);
if(!file_exists($source))
{
	$source = $youtube->download($video_code); 
}
$picture = $youtube->getHQThumb($video_code);


$page_access_token = $page_data['1711375602454024']['access_token'];
$linkData['access_token'] = $page_access_token;
$linkData['picture'] = $picture;
$linkData['link'] = 'https://japantravelling.com/rd.php';
$linkData['linkCaption'] = '';
$linkData['linkName'] = ' ';
$linkData['name']	= 'file';
$video_title = 'My Foo Video';
$linkData['message'] = 'message';
$linkData['caption'] = 'caption';
$linkData['file']	= '@'.realpath($source);
$video_desc = '12.326.215 views';
$linkData['actions'] = json_encode(array('name' => "a",'link' => "b"));

 $post_url = "https://graph-video.facebook.com/1711375602454024/videos?"
 . "title=" . $video_title. "&description=" . $video_desc
 . "&". $page_access_token;
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$post_url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $linkData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output
$result = curl_exec($ch);
curl_close ($ch);

var_dump($result);