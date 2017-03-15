<?php 
ini_set('display_errors', 1);
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/youtube_download.php";

if(isset($_POST['page_id']))
{
	/*if (preg_match("/vimeo.com/", $video)){
		if (preg_match('/vimeo\.com\/(clip\:)?(\d+).*$/', $video, $match)){
			$video_code = $match[2];
		 }
		// Get Vimeo thumbnail
		$source = 'https://secure.vimeo.com/moogaloop.swf?clip_id='.$video_code.'&autoplay=1';
	}*/
	
	//search for youtube.com and vimeo.com in the 'link' value
	$source = "";
	$picture = $_POST['picture'];
	$video = $_POST['source'] ? $_POST['source'] : "https://business.facebook.com/1617161421942934/videos/1792016887790719/";
	if (preg_match("/youtube.com/", $video) || preg_match("/youtu.be/", $video))
	{
		if (preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video, $match))
		{
			$video_code = $match[1];
		}
		$youtube = new Youtube;
		$source = $youtube->getFileName($video_code);
		if(!file_exists($source))
		{
			$source = $youtube->download($video_code); 
		}
		$picture = $youtube->getHQThumb($video_code);
		
		/*$source = "http://www.youtube.com/embed/" . $video_code;
		if(!$picture || $picture == ""){
			$picture = "http://img.youtube.com/vi/{$video_code}/hqdefault.jpg";
		}*/
		
	}else if (preg_match("/vimeo.com/", $video))
	{
		if (preg_match('/vimeo\.com\/(clip\:)?(\d+).*$/', $video, $match)){
			$video_code = $match[2];
		}
		// Get Vimeo thumbnail
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_code.php"));
		$picture = $hash[0]['thumbnail_medium'];  
		$source = 'https://secure.vimeo.com/moogaloop.swf?clip_id='.$video_code.'&autoplay=1';
	}
	
	foreach($_POST['page_id'] as $page)
	{
		//var_dump($picture);die;
		$page_access_token = $page_data[$page]['access_token'];
		$linkData['access_token'] = $page_access_token;
		$linkData['picture'] = $picture;
		$linkData['thumb'] = $picture;
		$linkData['link'] = $_POST['link'];
		$linkData['linkCaption'] = '';
		$linkData['linkName'] = '';
		$linkData['type']	= 'video';
		$linkData['radio18']	= 'video';
		$linkData['name'] = $_POST['name'];
		$linkData['message'] = $_POST['message'];
		$linkData['caption'] = $_POST['caption'];
		$linkData['source']	= $source;
		$linkData['description'] = $_POST['description'];
		
		if($fb)
		{
			// Post to Page feed
			try{
				$response_b = $fb->post("/$page_id/feed", $linkData, $page_access_token);
			}catch(Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
				$message = 'FacebookResponseException: '. $e->getMessage();
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				$message = 'FacebookSDKException: '. $e->getMessage();
			}
			
			$message = '<h2 class="success">Posted to Page Feed!</h2>';
			
		}else
		{
			$message = '<h2 class="error">Cannot define Facebook instance</h2>';
		}
		
		$_SESSION['message'] = $message;
	}
	
}
header("location: http://carsfun.org/fb/page_post.php");