OFFICIAL PHP SDK FOR SKYCLOUD (sCloud) scloud.live

A simple Lightweight SDK-LIBRARY For The Skycloud API -  by skycloud
https://developers.scloud.live


You will need to create an application name in the scloud Developers dashboard
at (developers.scloud.live) to use the sCloud SDK and API's
sCloud SDK uses Oauth 2.0 for authorization and to generate access tokens then can be used for API calls.
this sCloud SDK uses no external PHP libraries.

refer to https://developers.scloud.live/Developer/Documentation/ for more information.

The usage is very simply, example

$sCloud->generateAuthUrl(1);

$sCloud->API('token');

$sCloud->API(METHOD,PARAMS); - OPTIONAL PARAMATERS

