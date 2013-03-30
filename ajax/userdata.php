<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if ( isset( $user ) && $user->isOnline() ) {
	echo 'Welcome, ' . $user->username; ?> 
	[<img src="<?php echo CN_WEBDIR_ICONS; ?>upvote.png" width="10" /> 
	<?php echo $user->getMana(); ?> 
	<span class="rank"><?php echo $user->getRank(); ?></span>]
	<a href="<?php echo CN_WEBLOGOUT; ?>" class="button">Logout</a>
<?php } ?>