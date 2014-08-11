<?php
// usage:
// composer install #to install facebook api
// /usr/local/bin/php --file createTestUser.php

$APPLICATION_ID = "10152756866328132"; // Test app
$APPLICATION_SECRET = "3d7248d5b83857bf5a02972dfebdbd66"; // Test app secret

// FIXME: ACCESS_TOKEN changes often and should be parameterized
// regenerate using the graph api explorer:
// https://developers.facebook.com/tools/explorer?method=GET&path=me%3Ffields%3Did%2Cname&version=v2.1
$ACCESS_TOKEN = "CAACEdEose0cBAAhZBfi2okbv8gq8pOzqAcr3TJm6kKl5ADyFL0VvaxTj9Gtifnf9l7GCOaZCvTJPhHsCHypb2ekVa835FduzZCTjgRahnXWmAWXx0VqzZC2P98ji1yiJM3tG5ZCzTeL6HSu8mBWuOaCgPvRJCd413hqtOCY4ZAfzam5CdeUg6NP5MKuZB2ZBO7S9HFI00o1aIDk6sdoPalOf";

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

function FBLibAutoload($classname)
{
  //Can't use __DIR__ as it's only in PHP 5.3+
  $filename = dirname(__FILE__).DIRECTORY_SEPARATOR."vendor/facebook/php-sdk-v4/src/${classname}.php";
  $filename = str_replace('\\', '/', $filename);

  if (is_readable($filename)) {
    require $filename;
  }
}

if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
  //SPL autoloading was introduced in PHP 5.1.2
  if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
    spl_autoload_register('FBLibAutoload', true, true);
  } else {
    spl_autoload_register('FBLibAutoload');
  }
} else {
  /**
   * Fall back to traditional autoload for old PHP versions
   * @param string $classname The name of the class to load
   */
  function __autoload($classname)
  {
    FBLibAutoload($classname);
  }
}

FacebookSession::setDefaultApplication($APPLICATION_ID,$APPLICATION_SECRET);

// Use one of the helper classes to get a FacebookSession object.
//   FacebookRedirectLoginHelper
//   FacebookCanvasLoginHelper
//   FacebookJavaScriptLoginHelper
// or create a FacebookSession with a valid access token:
$session = new FacebookSession($ACCESS_TOKEN);

// Get the GraphUser object for the current user:

try {
  $me = (new FacebookRequest(
			     $session, 'GET', '/me'
			     ))->execute()->getGraphObject(GraphUser::className());
  echo $me->getName();

  $token_url =    "https://graph.facebook.com/oauth/access_token?" .
    "client_id=" . $APPLICATION_ID .
    "&client_secret=" . $APPLICATION_SECRET .
    "&grant_type=client_credentials";
  $tmp = file_get_contents($token_url);
  //  echo $tmp;
  $ary=preg_split('/=/',$tmp);
  print_r($ary);
  $APP_ACCESS_TOKEN=$ary[1];

  $params = array(
		  'access_token' => $APP_ACCESS_TOKEN,
		  'installed' => 'true',
		  'permissions' => 'read_stream'
		  );

  /* make the API call */
  $request = new FacebookRequest(
				 $session,
				 'POST',
				 "/$APPLICATION_ID/accounts/test-users",
				 $params
				 );

  $response = $request->execute();
  $graphObject = $response->getGraphObject();
  /* handle the result */

} catch (FacebookRequestException $e)
{
  // The Graph API returned an error

  echo "Exception occured, code: " . $e->getCode();
  echo " with message: " . $e->getMessage();

}
catch (\Exception $e)
{
  // Some other error occurred
  // test
}
