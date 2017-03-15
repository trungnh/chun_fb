<?php
//session_start();
//require "./config.php";
$page_id 	= '1617161421942934';
$app_id 	= '1362548250428358';
$app_secret = '8a5b901d8baaff9e757206170ae4ca4c';
$video = 'https://vimeo.com/46434075';

if(!$accessToken){
	$redirect_uri = 'http://carsfun.org/fb/token.php/';
	$url = 'https://www.facebook.com/dialog/oauth?client_id='.$app_id.'&redirect_uri='.$redirect_uri.'&scope=manage_pages,publish_actions,publish_pages';
	$code = '';
	if(!isset($_GET['code'])){
		header('Location: '.$url);
	}else{
		$code = $_GET['code'];
	}
	$url2 = 'https://graph.facebook.com/oauth/access_token?client_id='.$app_id.'&redirect_uri='.$redirect_uri.'&client_secret='.$app_secret.'&code='.$code;
	$getToken = file_get_contents($url2);
	$accessToken = substr($getToken,strpos($getToken,'access_token')+13,(strpos($getToken,'&expires') - (strpos($getToken,'access_token')+13)));
	$_SESSION['access_token'] = $accessToken;
}

var_dump($accessToken);die;
/*
require_once __DIR__ . '/fbphpsdk/src/Facebook/autoload.php';

//search for youtube.com and vimeo.com in the 'link' value
if (preg_match("/vimeo.com/", $video))
{
	if (preg_match('/vimeo\.com\/(clip\:)?(\d+).*$/', $video, $match))
	{
		$video_code = $match[2];
	 }
	// Get Vimeo thumbnail
	$source = 'https://secure.vimeo.com/moogaloop.swf?clip_id='.$video_code.'&autoplay=1';
}
$fb = new Facebook\Facebook(array(
	'app_id' => $app_id,
	'app_secret' => $app_secret,
	'default_graph_version' => 'v2.5',
	'allowSignedRequest' => false, // optional but should be set to false for non-canvas apps
));


// Get the Facebook\GraphNodes\GraphUser object for the current user.
// If you provided a 'default_access_token', the '{access-token}' is optional.
try {
	$response = $fb->get('/me', $accessToken);
	$me = $response->getGraphUser();

	//the data of the link to post
	$linkData['access_token'] = $token;
	$linkData['picture'] = "http://www.withlovefay.com/wp-content/uploads/2010/06/fay-gym-wear-03.jpg";
	$linkData['link'] = 'https://reviewcollege.net/rd';
	$linkData['linkCaption'] = '';
	$linkData['linkName'] = '';
	$linkData['type']	= 'video';
	$linkData['name'] = '';
	$linkData['message'] = "";
	$linkData['caption'] = "";
	$linkData['source']	= $source;
	$linkData['description'] = "";

	//actual post of the link by FB page
	if (strlen($page_id)) {
	  
	  $response_a = $fb->get('/me/accounts/', $accessToken);
	  $data = $response_a->getDecodedBody()['data'];
	  //echo '<pre>';var_dump($data);die;
	  $page_not_found = true;
	  if (count($data)) {
		//find the desired page and use its access token to post
		foreach($data as $entry) {
		  if ($entry['id'] == $page_id) {
			$page_access_token = $entry['access_token'];
			$response_b = $fb->post("/$page_id/feed", $linkData, $page_access_token);
			$page_not_found = false;
			$page_name = $entry['name'];
		  }
		}
	  }
	  if ($page_not_found){ echo "post failed; page not found.";die;}
	  else {
		$graphnode = $response_b->getGraphNode();
		echo 'Page feed';die;
	  }
	  
	//actual post of the link by FB user
	}else {
	  $response_a = $fb->post('/me/feed', $linkData, $accessToken);
	  $graphnode = $response_a->getGraphNode();
	  echo 'Me feed';die;
	}

} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'FacebookResponseException: '. $e->getMessage();die;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'FacebookSDKException: '. $e->getMessage();die;
}
echo 'Congrats';
?>