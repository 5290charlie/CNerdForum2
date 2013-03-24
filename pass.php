<?php
$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$hash = hash('md5', $salt . 'wacko180');

$pass = $salt . $hash;

echo $pass;
?>