<?php

session_start();
///error_reporting(E_ALL);


//skycloud class (Minimal SDK.)
class sCloud {
	//SKYCLOUD (sCloud) SDK CLASS.
 private $api_key;
 private $age;
 private $request;//used to hold the request from our application call.
 private  $app_secret;//app secret that you got from developer.scloud.live when you created an applicaiton on scloud develpers website.
 
 
function __construct( $api_key,$app_secret, $age,$request ) {
		$this->request = $api_key;
		$this->api_key = $app_secret;
		$this->age = $age;
		$this->request = $request;
		
	}
	public function getconfig(){
	include'Config.php';
	//other functions will use these config settings via $this->getconfig();
	//if any varables are added to the config.php then they also need to be declared on the json call below so they can be used.
	///$makejsonconfog = array('SkycloudClientID'=>$SkycloudClientID, "baseURL"=>$baseURL, "Joe"=>43);
$jsonobj = '{"SkycloudClientID":"'.$SkycloudClientID.'","baseURL":"'.$baseURL.'","authorizeURL":"'.$authorizeURL.'","SkycloudClientSecret":"'.$SkycloudClientSecret.'","Api_url":"'.$apiURLBase.'","token_url":"'.$tokenURL.'"}';
$obj = json_decode($jsonobj);
    return $obj;//json_encode($makejsonconfog);//$SkycloudClientID;
  }
	
	
	
	
	
 //USED TO MAKE API REQUEST TO SKYCLOUD



/////generate a authorzation URL to the sCloud authorization server.
function generateAuthUrl($whatlink){
	 $SkycloudClientID=$this->getconfig()->SkycloudClientID;
	  $baseURL=$this->getconfig()->baseURL;
	  $authorizeURL=$this->getconfig()->authorizeURL;
	$_SESSION['state'] = bin2hex(random_bytes(16));
    $params = array(
    'response_type' => 'code',
    'client_id' => $SkycloudClientID,
    'redirect_uri' => $baseURL,
    'scope' => 'user Images',
    'state' => $_SESSION['state']
  );
 
  // Redirect the user to Skycloud's authorization page
  if($whatlink==1){
  	$genlink='<a href="'.$authorizeURL.'?'.http_build_query($params).'">Authorize</a>';//authorization link to authorate scloud api with a user account.
  	
  }
  else if($whatlink==0){
  	
  	$genlink=$authorizeURL.'?'.http_build_query($params);//authorization link to authorate scloud api with a user account.
  	
  }
  else{
  	
  	$genlink="error 0 or 1 must be set";//custom error
		}
  return $genlink;
  //header('Location: '.$authorizeURL.'?'.http_build_query($params));
  //die();
	}
///Auth token info
function AuthToken(){
	  if(isset($_SESSION['access_token'])){
	  	$token=$_SESSION['access_token'];
	  }
	  else{
	  	$token="No token is set, try to authorize a user.";
	  	
	  }
	return $token;
}
//ACTUAL API CALL FUNCTION.
function API($url, $post=FALSE, $headers=array()) {
//connect config varables so we can use them in this function.
	$SkycloudClientID=$this->getconfig()->SkycloudClientID;
	$baseURL=$this->getconfig()->baseURL;
	$authorizeURL=$this->getconfig()->authorizeURL;
	$SkycloudClientSecret=$this->getconfig()->SkycloudClientSecret;
	$api_url=$this->getconfig()->Api_url;
    $token_url=$this->getconfig()->token_url;
	      
	  //post values.    
	$post=array(
    'grant_type' => 'authorization_code',
    'client_id' => $SkycloudClientID,
    'client_secret' => $SkycloudClientSecret,
    'redirect_uri' => $baseURL,
    'code' => $_GET['code']
  );
	

//URL SWITCHER
if($url=='token'){
		 $url=$this->getconfig()->token_url;
		}
	else{
		  $url=$this->getconfig()->Api_url.$url;
		}
		
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
 
  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
 
  $headers = [
    'Accept: application/skycloud.pro+json, application/json',
    'User-Agent: https://example-app.com/'
  ];
 
  if(isset($_SESSION['access_token'])){
  	//echo 'Authorization: Bearer '.$_SESSION['access_token'];
  
    $headers[] = 'Authorization: Bearer '.$_SESSION['access_token'];
		}
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($ch);
  if($url=='token'){
	  $_SESSION['access_token'] =$token['access_token'];//store the access token in a session
  }
  return json_decode($response, true);
}
////////////////////////////////////////




	function Cloud($options) {
		//this function will get all user cloud info
		//we will use file get contents with GET methods
		
		//But our main option will use curl for post and get methods
	//$options;//optons can hold request call..cloud..accounts..security orwhatever
	
	//HOLDSKYCLOUD API ENDPOINTS HERE...	 
// $url = "https://scloud.live/Apiv1/API.php?api_key=t5hhrhrrhfhv";//default end point - must be https
//$json = file_get_contents($url);
//$skycloud = json_decode($json, true);
//print_r($json_data);
//return $skycloud[cloud][storage_used];
//echo $storage_used; 
		return $skycloud;
	}
 
 
 
	//function isAdult() {
		//return $this->age >= 18?"an Adult":"Not an Adult";
	//}
 
}
?>
