<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

print_r( $user );

if( !empty( $_POST ) && !empty( $_POST['topic_id'] ) && !empty( $_POST['user_id'] ) && !empty( $_POST['title'] ) && !empty( $_POST['details'] ) ) {
	echo 'post submission';
} 


?>