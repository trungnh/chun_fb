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
$picture = $youtube->getHQThumbFile($video_code);


$page_access_token = $page_data['1711375602454024']['access_token'];
$linkData['access_token'] = $page_access_token;
$linkData['picture'] = $fb->fileToUpload($picture);
$linkData['thumb'] = $fb->fileToUpload($picture);
$linkData['link'] = 'https://japantravelling.com/rd.php';
$linkData['linkCaption'] = '';
$linkData['linkName'] = ' ';
$linkData['type']	= 'video';
$linkData['radio18']	= 'video';
$linkData['name'] = 'My Foo Video';
$linkData['message'] = 'message';
$linkData['caption'] = 'caption';
$linkData['source']	= $fb->videoToUpload($source);
$linkData['description'] = '12.326.215 views';

if($fb)
{
	// Post to Page feed
	try{
		$response_b = $fb->post("/1711375602454024/feed", $linkData, $page_access_token);
	}catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'FacebookResponseException: '. $e->getCode() .''.$e->getMessage();
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'FacebookSDKException: '. $e->getMessage();
	}
	
	echo '<h2 class="success">Posted to Page Feed!</h2>';
	
}else
{
	echo '<h2 class="error">Cannot define Facebook instance</h2>';
}
/*
$data = array(
	'thumb'			=>	$fb->fileToUpload($picture),
	'link'			=> 	'https://japantravelling.com/rd.php',
	'linkCaption'	=>	'',
	'linkName'		=>	' ',
	'title' 		=> 	'My Foo Video',
	'description' 	=> 	'This video is full of foo and bar action.',
	'caption'		=>	'abcabc',
	'source' 		=> 	$fb->videoToUpload($source),
);

try {
	$response = $fb->post('/1711375602454024/videos', $data, $page_data['1711375602454024']['access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

$graphNode = $response->getGraphNode();
var_dump($graphNode);

echo 'Video ID: ' . $graphNode['id'];