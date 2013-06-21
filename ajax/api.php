<?php

/*************************************************
			API Page
**************************************************
	Author: Charlie McClung
	Updated: 6/20/2013
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();

$cn->init(true);

if (isset($_GET['q'])) {
	$topics = CN_Topic::search($_GET['q']);
	$posts  = CN_Post::search($_GET['q']);
} else {
	// Initialize topics object with all topics
	$topics = CN_Topic::getAll();
	$posts  = CN_Post::getAll();
}

$response = array();

foreach($topics as $t) {
	$t->link = '/topic?tid=' . $t->id;
	$response[] = $t;
}

foreach($posts as $p) {
	$p->link = '/post?pid=' . $p->id;
	$response[] = $p;
}

foreach($response as $row) {
	$row->authorStr = $row->author->username . ' [' . $row->author->fullname . ']';
}

if (isset($_GET['callback'])) {
	print $_GET['callback'] . '(' . json_encode($response) . ');';
} else {
	print json_encode($response);
}