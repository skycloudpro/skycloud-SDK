<h1>OFFICIAL PHP SDK FOR (sCloud) scloud.live</h1>

A simple Lightweight and Powerful SDK-LIBRARY For The sCloud API -  by sCloud https://scloud.live



You will need to create an application name in the scloud Developers dashboard
at (https://developers.scloud.live) to use the sCloud SDK and API's

sCloud SDK uses Oauth 2.0 for authorization and to generate access tokens then can be used for API calls.

this sCloud SDK uses no external PHP libraries. 


Refer to https://developers.scloud.live/Developer/Documentation/ for more information.

Pull requests are welcome.

<h2>The usage is very simple </h2>

<p>First declare the class</p>
 <pre><code>$sCloud = new sCloud( 'app_key_here', 15,2,0 );</code></pre>


<br />
<p>Methods</p>

<pre><code>$sCloud->generateAuthUrl(1);//1=hyperlink, 0=URL String.</code></pre>

<pre><code>$sCloud->API('token');</code></pre>

<pre><code>$sCloud->API('METHOD');</code></pre>


<br/><br />
With optional (POST parameters array)

<pre><code>$params=array('example_value1','example_value2');//example values

$sCloud->API('METHOD',$params); //- OPTIONAL PARAMETERS ARRAY
</code></pre>

<br />
<p>Helper Method</p>

<pre><code>$sCloud->AuthToken();//get authentication token info, expiry, creation date</code></pre>

With the above methods it should be quite simple to implement sCloud API's into any system of your choice allowing for an unparalleled secure infrastructure.

An official Java & Javascript SDK will also be coming shortly.

Full Documentation can be found here https://developers.scloud.live/Developer/Documentation



