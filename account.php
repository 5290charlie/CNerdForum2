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