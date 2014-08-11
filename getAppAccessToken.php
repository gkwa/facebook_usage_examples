<?php

// http://www.masteringapi.com/tutorials/how-to-get-a-facebook-application-access-token/41/

$APPLICATION_ID = "01234567890123455"; // Test app
$APPLICATION_SECRET = "01234567890123455012345678901234";

$token_url =    "https://graph.facebook.com/oauth/access_token?" .
                "client_id=" . $APPLICATION_ID .
                "&client_secret=" . $APPLICATION_SECRET .
                "&grant_type=client_credentials";
$app_token = file_get_contents($token_url);

echo $app_token;
