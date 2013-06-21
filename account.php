<?php

/*************************************************
			Account Page
**************************************************
	Author: Charlie McClung
	Updated: 4/2/2013
		Display current users account info
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

// Require header global
require_once CN_DIR_GLOBALS . 'header.php';

if (isset($_GET) && !empty($_GET['user']))
	$showusername = $_GET['user'];
else
	$showusername = $user->username;
	
$showuser = new CN_User( $showusername );

?>

<h2><?php echo $showuser->username; ?>'s Account</h2>
<div id="useraccount">
	<div id="left-panel">
		<div id="userinfo">
			<div class="mana">
				[<img src="<?php echo CN_WEBDIR_ICONS; ?>mana.png" /> 
				<?php echo $showuser->getMana(); ?> 
				<span class="rank"><?php echo $showuser->getRank(); ?></span>]
			</div>
			<div class="username"><?php echo $showuser->username; ?></div>
			<img class="avatar" src="<?php echo CN_WEBDIR_IMAGES; ?>avatar.gif" />
			<div class="fullname"><?php echo $showuser->fullname; ?></div>
			<div class="email"><a href="mailto:<?php echo $showuser->email; ?>"><?php echo $showuser->email; ?></a></div>					
		</div>
		<div id="usertopics">
			<h4><?php echo $showuser->username; ?>'s Topics</h4>
			<ul>
			<?php 
			$topics = $showuser->getTopics();
			
			if (count($topics) > 0) {
				foreach ($topics as $topic) {
					echo "<li><a href='/topic?tid={$topic->id}'>{$topic->title}</a></li>";
				}
			} else {
				echo "No Topics";
			}
			?>
			</ul>
		</div>
		<div id="userposts">
			<h4><?php echo $showuser->username; ?>'s Posts</h4>
			<ul>
			<?php 
			$posts = $showuser->getPosts();
			
			if (count($posts) > 0) {
				foreach ($posts as $post) {
					echo "<li>";
					echo "<a href='/post?pid={$post->id}'>{$post->title}</a>";
					echo "<ul><li>Topic: <a href='/topic?tid={$post->topic->id}'>{$post->topic->title}</a></li></ul>";
					echo "</li>";
				}
			} else {
				echo "No Posts";
			}
			?>
		</div>
		<div id="usercomments">
			<h4><?php echo $showuser->username; ?>'s Comments</h4>
			<ul>
			<?php 
			$comments = $showuser->getComments();
			
			if (count($comments) > 0) {
				foreach ($comments as $comment) {
					echo "<li>";
					echo "{$comment->body}";
					echo "<ul>";
					echo "<li>Post: <a href='/post?pid={$comment->post->id}'>{$comment->post->title}</a></li>";
					echo "<li>Topic: <a href='/topic?tid={$comment->post->topic->id}'>{$comment->post->topic->title}</a></li>";
					echo "</ul>";
					echo "</li>";
				}
			} else {
				echo "No Comments";
			}
			?>
			</ul>
		</div>
	</div>
	<div id="trophycase">
		<h4>Trophy Case</h4>
		<?php
		$trophies = CN_Trophy::getTrophies( $showuser->getMana() );
		foreach ( $trophies as $trophy ) {
			echo '<img src="' . CN_WEBDIR_TROPHIES . $trophy->icon . '" />';	
		}
		?>
	</div>
	<div class="clear"></div>
</div>

<input type="hidden" id="page" name="page" value="account" />
<input type="hidden" id="page-title" name="page-title" value="<?php echo $showuser->username; ?>'s Account" />

<?php
// Require footer global
require_once CN_DIR_GLOBALS . 'footer.php';
?>