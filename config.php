<?php 
session_start();
require_once __DIR__ . '/fbphpsdk/src/Facebook/autoload.php';

//$accessToken = null;
$accessToken 	= 'EAATXOvx0w8YBAK3MYZC8G0htwfkULsZAcPZCLqeyZCU71bBJYYNLIvZAyfxYDhhz2dbGRq4mVCPZBy0lUxvbbYNXvPffELaVQcJBG2WylCBrgVPLPaiqhiGwJBlGKh9W2CZC1EI0ZAI9ZApLicTmIvhQ5EqqbPWiam90ZD';
$app_id 		= '1362548250428358';
$app_secret 	= '8a5b901d8baaff9e757206170ae4ca4c';
$video 			= 'https://vimeo.com/46434075';
$page_data = array();
$fb = null;

if($accessToken){
	$fb = new Facebook\Facebook(array(
		'app_id' => $app_id,
		'app_secret' => $app_secret,
		'default_graph_version' => 'v2.5',
		'allowSignedRequest' => false, // optional but should be set to false for non-canvas apps
	));

	$response_a = $fb->get('/me/accounts/', $accessToken);
	$data = $response_a->getDecodedBody()['data'];
	foreach($data as $entry) {
		$page_data[$entry['id']] = array('name'=>$entry['name'], 'access_token'=>$entry['access_token']);
	}
}