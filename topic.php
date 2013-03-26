<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if( !empty( $_POST ) && !empty( $_POST['topic_id'] ) && !empty( $_POST['user_id'] ) && !empty( $_POST['title'] ) && !empty( $_POST['details'] ) ) {
	if ( CN_Post::add( $_POST ) ) {
		$cn->enqueueMessage(
			'Successfully created post: ' . $_POST['title'],
			CN_MSG_SUCCESS,
			$_SESSION['sessionID']
		);
	} else {
		$cn->enqueueMessage(
			'Error creating post: ' . $_POST['title'],
			CN_MSG_ERROR,
			$_SESSION['sessionID']
		);
	}
	
	CN::redirect( CN_WEBROOTPAGE . 'topic?tid=' . $_POST['topic_id'] );
} 

if( !empty( $_GET ) && !empty( $_GET['tid'] ) ) {
	$topic = new CN_Topic( $_GET['tid'] );
	
	// Require header global
	require_once( CN_DIR_GLOBALS . 'header.php' );
	?>
				<h1>Topic: <?php echo $topic->title; ?></h1>
				<hr>
				<h2>Posts:</h2>
				<ul>
				<?php
				$posts = $topic->getPosts();
				
				foreach( $posts as $p ) { ?>
					<li>
						<strong>Title:</strong> <a href="<?php echo CN_WEBROOTPAGE . 'post?pid=' . $p->id; ?>"><?php echo $p->title; ?></a> 
						(<a href="<?php echo CN_WEBROOTPAGE . 'touch?pid=' . $p->id; ?>">touch</a>)<br />
						<strong>Details:</strong> <?php echo $p->details; ?><br />
						<strong>Date:</strong> <?php echo date( CN_DATE_FORMAT, $p->date ); ?><br />
						<strong>Updated:</strong> <?php echo date( CN_DATE_FORMAT, $p->updated ); ?><br />
						<strong>Author:</strong> <?php echo $p->author->username . ' (' . $p->author->firstname . ' ' . $p->author->lastname . ')'; ?>
					</li>
				<?php } ?>
				</ul>
				<hr>
				<form id="new_post" method="post" action="<?php echo CN_WEBROOTPAGE . 'topic'; ?>">
					<input type="hidden" id="topic_id" name="topic_id" value="<?php echo $topic->id; ?>" />
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id; ?>" />
					<label for="title">Title:</label>
					<input type="text" id="title" name="title" />
					<br />
					<label for="details">Details:</label>
					<textarea id="details" name="details"></textarea>
					<br />
					<input type="submit" value="Add Post" />
				</form>
	<?
	// Require footer global
	require_once( CN_DIR_GLOBALS . 'footer.php' );
}
?>