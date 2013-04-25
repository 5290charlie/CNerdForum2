<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

if (isset($_POST) && !empty($_POST['ajax'])) {
	$cn =& CN::getInstance();
	$cn->init();
}

if ( isset( $user ) && $user->isOnline() ) {
	echo 'Welcome, ' . $user->username; ?> 
	<span class="mana">
		[<img src="<?php echo CN_WEBDIR_ICONS; ?>mana.png" /> <?php echo $user->getMana(); ?>  <span class="rank"><?php echo $user->getRank(); ?></span>] 
	</span>
	| <a href="/account">account</a> | <a href="<?php echo CN_WEBLOGOUT; ?>">logout</a>
<?php } else {
	echo 'Please <a href="' . CN_WEBLOGIN . '">login</a> or <a href="' . CN_WEBSIGNUP . '">sign up</a>';	
} ?>