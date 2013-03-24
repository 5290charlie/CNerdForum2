<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

final class CN {
	
	// Gets (creates if non-existent) a reference to an instance of this class
	public static function &getInstance() {
		static $instance;
		
		if ( !is_object( $instance ) ) {
			$class = __CLASS__;
			$instance = new $class();
			unset( $class );
		}
		
		return $instance;
	}
	
	// Initialize Site
/*	public function init() {
		
		// Redirect if site offline
		if ( CN_STATUS == CN_ST_OFFLINE )
			CN::redirect( CN_WEBROOTPAGE . 'maintenance.php' );
			
		// Begin Session
		session_name( CN_SESSION_NAME );
		session_start();
		
		// Regenerate session ID (hinders session hijacking)
		session_regenerate_id();
		
		// Generate CNerdForum session ID
		if ( !isset( $_SESSION['sessionID'] ) )
			$_SESSION['sessionID'] = self::generateKey( CN_SESSION_KEYLENGTH_SESSID );
		
		try {
			$GLOBALS['dbo'] =& self::getDBO();
		} catch ( Exception $e ) {
			die( 'Could not connect to the database!' );
		}
		
		// Notify in case of DEBUG mode
		if ( CN_STATUS == CN_ST_DEBUG ) {
			$this->enqueueMessage(
				'CNerdForum is currently in debug mode.',
				CN_MSG_ANNOUNCEMENT,
				$_SESSION['sessionID']
			);
		}
	}
*/
	// Check if site is live
	public static function isLive() {
		return CN_STATUS == CN_ST_LIVE;
	}
	
	// Redirect browser to new URL
	public static function redirect( $location ) {
		
		// Set headers if not sent to browser
		if ( !headers_sent() ) {
			header( 'Location: ' . $location );
		// Otherwise, use JavaScript
		} else {
?>
			<script type="text/javascript">
				location.href = "<?php echo $location; ?>";
			</script>
<?php
		}
		exit;
	}
	
	// Adds a message to system message queue
	/* 
	   Message Types:
	   
		Template:
		Message Constant (Legacy Message Type) - Message Description
	   
		CN_MSG_ERROR ("error") - Error Message
		CN_MSG_WARNING ("warning") - Warning/Caution Message
		CN_MSG_ANNOUNCEMENT ("announcement") - Informational Message
		CN_MSG_SUCCESS ("success") - Success Message
		
	*/
	public function enqueueMessage( $message, $type, $session ) {
		// TODO
	}
	
	public function getMessages( $session = null ) {
		// TODO
	}
	
	// Generates random character sequences of specified length
	public static function generateKey( $length = 9 ) {
		$serial = '';
		static $set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$set_length = strlen( $set );
		while( $length > 0 ) {
			$serial .= substr( $set, mt_rand( 0, $set_length - 1 ), 1 );
			--$length;
		}
		return $serial;
	}
	
	// Gets a reference to the current user object
	public static function &getUser() {
		return CN_User::getInstance();
	}
	
	// Gets a reference to the database object
	public static function &getDBO() {
		return CN_Database::getInstance();
	}
}

?>