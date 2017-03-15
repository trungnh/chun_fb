<?php
//session_start();
//require "./config.php";
$app_id 	= '1362548250428358';
$app_secret = '8a5b901d8baaff9e757206170ae4ca4c';

if(!$accessToken){
	$redirect_uri = 'http://128.199.233.211/fb/phone.php';
	$url = 'https://www.facebook.com/dialog/oauth?client_id='.$app_id.'&redirect_uri='.$redirect_uri.'&scope=user_mobile_phone,user_address';
	$code = '';
	if(!isset($_GET['code'])){
		header('Location: '.$url);
	}else{
		$code = $_GET['code'];
	}
	$url2 = 'https://graph.facebook.com/oauth/access_token?client_id='.$app_id.'&redirect_uri='.$redirect_uri.'&client_secret='.$app_secret.'&code='.$code;
	$getToken = file_get_contents($url2);
	$accessToken = substr($getToken,strpos($getToken,'access_token')+13,(strpos($getToken,'&expires') - (strpos($getToken,'access_token')+13)));
	//$_SESSION['access_token'] = $accessToken;
}

require_once __DIR__ . '/fbphpsdk/src/Facebook/autoload.php';

$fb = new Facebook\Facebook(array(
	'app_id' => $app_id,
	'app_secret' => $app_secret,
	'default_graph_version' => 'v2.5',
	'allowSignedRequest' => false, // optional but should be set to false for non-canvas apps
));

//$response = $fb->get('/me?fields=address,mobile_phone', $accessToken);
//$me = $response->getGraphUser();
$abc = 'https://graph.facebook.com/me?fields=about&access_token='.$accessToken;
var_dump(file_get_contents($abc));