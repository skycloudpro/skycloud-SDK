<?php

session_start();
///error_reporting(E_ALL);


//skycloud class (Minimal SDK.)
class sCloud {
	//SKYCLOUD (sCloud) SDK CLASS.
 private $api_key;
 private $age;
 private $request;//used to hold the request from our application call.
 private $app_secret;//app secret that you got from developer.scloud.live when you created an applicaiton on scloud develpers website.
 
 //define some of scloud's error codes later.
 
 
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

//USED TO MAKE API REQUEST TO SKYCLOUD
//ACTUAL API CALL FUNCTION.
function API($url, $post=FALSE, $options=FALSE, $headers=array()) {
	//echo 'API-CALL::'.$url;//DEBUG
//connect config varables so we can use them in this function.
	$SkycloudClientID=$this->getconfig()->SkycloudClientID;
	$baseURL=$this->getconfig()->baseURL;
	$authorizeURL=$this->getconfig()->authorizeURL;
	$SkycloudClientSecret=$this->getconfig()->SkycloudClientSecret;
	$api_url=$this->getconfig()->Api_url;
    $token_url=$this->getconfig()->token_url;
	 //END OF CONFIG VARABLES. 
	     
	//post values. 
     if($post){
	  	//user custom post might need to combine with below post aswell
	  	//get POST VALUE
	  	//BUILD FROM USER ARRAY 
	  	//HERE WE ARE CHECKING FOR SCLOUD API METHODS BUT ONLY ONES WITH A POST PARAM WILL ACTUALLY REACH THIS SECTION OF CODE.
	  	//cloud_upload method
	  	 if($url=='cloud_upload'){
	     if($options!=FALSE){
	 	
	 	
	 	//lets check if the mentioned encryption type is a valid scloud encryption type.
	 	if($options=="AES-256"){
			
			
		}
		else{
				echo 'Error unrecognised encryption type, please try using AES-256';
			exit();
		}
	 	
	 	
	 	if(count($post)==1){
	 		
			//single file found
			$post=array(
    'filename' => $post[0],//single file
    'encryption_type' => $option
  );
					}
					elseif(count($post)>1){
						//multiple files found to lets uploas em all.
						//LOOP THROUGH ALL POST THE $POST VAR
							$post=array(
    'filename' => $post[0],//single file
    'encryption_type' => $option
  );
					}
	 	
	 }
	  else{
	  	$error=1;//no encrytion type found
	  	echo 'Error no encryption type found, please try using AES-256';
	  	exit();
	  }
	  
		}
	  	
	  	
	  	//account_create method
	  	if($url=='account_create'){
	  		$post=array(
    'email' => $post[0],
    'username' => $post[1],
    'password' => $post[2],
    'fname' => $post[3],
    'lname' => $post[4],
    'ref_id' => $post[5],
    'iso_lang' => $post[6]
  );
  
 // print_r($post);
			}
	  }
	  else{
	  //THIS IS THE DEFAULT POST PARAMS USIALLY FOR THE OAUTH 2.0 PROTOCOL
	  
	  //default post  
	$post=array(
    'grant_type' => 'authorization_code',
    'client_id' => $SkycloudClientID,
    'client_secret' => $SkycloudClientSecret,
    'redirect_uri' => $baseURL,
    'code' => $_GET['code']
  );
	}

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
		////STORE TOKEN INSIDE OUR CLASS so right here
		  $gettoken=json_decode($response, true);
	  $_SESSION['access_token'] =$gettoken['access_token'];//store the access token in a session
	  //END OF SETTING TOKEN IN A SESSION INSIDE OUR CLASS.
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
