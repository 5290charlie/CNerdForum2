<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if( !empty( $_POST ) && !empty( $_POST['topic_id'] ) && !empty( $_POST['user_id'] ) && !empty( $_POST['title'] ) && !empty( $_POST['details'] ) ) {
	print_r( $_POST );
} elseif( !isset( $_GET['tid' ) ) {
	die( 'MUST provide tid' );
}

$topic = new CN_Topic( $_GET['tid'] );

print_r( $topic );
?>