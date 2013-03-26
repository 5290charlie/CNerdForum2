<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

echo "index.php: After config include, before CN init<br />";

$cn =& CN::getInstance();
$cn->init();

echo "index.php: After CN init, before header include<br />";

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );

echo "index.php: After header include<br />";
?>
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
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );

echo "index.php: After footer include<br />";
?>