include'sCloud_SDK.php';
$sCloud = new sCloud( $dummy, 15,2,0 );

$sCloud->generateAuthUrl(1);
$token=$sCloud->API('token');//json format
 
//Example API calls... (refer to the full API call list on sclouds developer website)
// https://developers.scloud.live/Developer/Documentation/#API

$userInfo=   $sCloud->API('account_info');//json format
$userEmail=  $sCloud->API('account_info')['registered_email'];//json format
$storageUsed=$sCloud->API('account_info')['used_storage'];//json format
$randImage=$sCloud->API('images')['22'];//json format
$sCloud->API('Videos')['count'];

//helper methods.
$sCloud->AuthToken();//get authentication token info, expiry, creation date
