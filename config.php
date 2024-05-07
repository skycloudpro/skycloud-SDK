<?php
////////////////////////////SKYCLOUD API CONNECT CONFIG/////////////////////

// Fill these out with the values from Skycloud developers dashboard.
$SkycloudClientID = 'YOUR-APP-ID';//PUT YOUR app id HERE client id is the same AS APP ID
$SkycloudClientSecret = 'YOU-APP-SECREY-KEY';//PUT YOUR APP SECRET HERE
 
// This is the URL we'll send the user to first
// to get their authorization &bauth code
$authorizeURL = 'https://scloud.live/oauth2/authorize/';
 
// This is the endpoint we'll request an access token from
$tokenURL = 'https://scloud.live/oauth2/access_token/';
 
// This is the Skycloud base URL for API requests
$apiURLBase = 'https://api.scloud.live/?';
 
 

 
 
// The URL for this script, used as the redirect URL
$baseURL = 'https://' . $_SERVER['SERVER_NAME']
    . $_SERVER['PHP_SELF'];
 
// Start a session so we have a place to
// store things between redirects


///////////////////////END CONFIG///////////////////////////
?>
