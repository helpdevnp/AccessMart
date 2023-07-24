<?php

require 'vendor/autoload.php';

use FirebaseJWTJWT;

 

$teamId = 'TEAM ID';

$keyId = 'KEY ID';

$sub = 'com.avocado.client';

$aud = 'https://appleid.apple.com'; // it's a fixed URL value

$iat = strtotime('now');

$exp = strtotime('+60days');

$keyContent = file_get_contents('key.txt');

 

echo JWT::encode([

    'iss' => $teamId,

    'iat' => $iat,

    'exp' => $exp,

    'aud' => $aud,

    'sub' => $sub,

], $keyContent, 'ES256', $keyId);

// Write the snippet in a method, return the value from that method

// You

?>