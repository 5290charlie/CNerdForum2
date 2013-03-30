<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn = CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['post_id'] ) && !empty( $_POST['value'] ) ) {
	
}

?>