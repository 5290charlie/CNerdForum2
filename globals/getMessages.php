<?php

// Prevent direct access
defined( '_CN_EXEC' ) or die( 'Restricted access' );

$messages = $cn->getMessages();

if ( !empty( $messages ) ) {
	
	foreach( $messages as $message_type => $message_cue ) {
		$msg = '';
		
		foreach( $message_cue as $message ) {
			$msg = ($msg == '') ? $message : $msg . '<br /><br />' . "\n\t\t\t\t\t" . $message;
		}
		
		switch( $message_type ) {
			case CN_MSG_ERROR:
				$message_type = 'error';
				break;
			case CN_MSG_SUCCESS:
				$message_type = 'success';
				break;
			case CN_MSG_WARNING:
				$message_type = 'warning';
				break;
			case CN_MSG_ANNOUNCEMENT:
				$message_type = 'announcement';
				break;
			default:
				$message_type = 'warning';
				break;
		}
?>
				<div class="<?php echo $message_type; ?>">
					<?php echo $msg . "\n"; ?>
				</div>
<?php
	}
	
}
?>