<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );

echo 'pre-user ** ';

$user = new CN_User( 'charlie' );

print_r( $user );
?>

					<ul>
						<li id="topics-tab"><a href="#topics">Topics</a></li>
						<li id="posts-tab"><a href="#posts">All Posts</a></li>
						<li id="users-tab" style="display:none;"><a href="#users">Users</a></li>
					</ul>
					<div id="topics">
						<div class="accordion">
						  <h3>First header</h3>
						  <div>First content panel</div>
						  <h3>Second header</h3>
						  <div>Second content panel</div>
						</div>
					</div>
					<div id="posts">
						<div class="accordion">
						  <h3>First header</h3>
						  <div>First content panel</div>
						  <h3>Second header</h3>
						  <div>Second content panel</div>
						</div>
					</div>
					<div id="users">
						<div class="accordion">
						  <h3>First header</h3>
						  <div>First content panel</div>
						  <h3>Second header</h3>
						  <div>Second content panel</div>
						</div>
					</div>

<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>