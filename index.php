<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
Homepage
<br />
Topics Test:
<br />
<?php
$topics = CN_Topic::getAll();
print_r( $topics );
?>
<!--
				<div id="tabs">
					<ul>
						<li id="topics-tab"><a href="#topics">Topics</a></li>
						<li id="posts-tab"><a href="#posts">All Posts</a></li>
						<li id="users-tab" style="display:none;"><a href="#users">Users</a></li>
					</ul>
					<div id="topics">
						Topics
					</div>
					<div id="posts">
						Posts
					</div>
					<div id="users">
						Users	
					</div>
				</div>
-->
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>