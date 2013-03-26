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
	public function init() {
		
		// Redirect if site offline
		if ( CN_STATUS == CN_ST_OFFLINE )
			CN::redirect( CN_WEBMAINTENANCE );
			
		// Begin Session
		session_name( CN_SESSION_NAME );
		session_start();
		
		// Regenerate session ID (hinders session hijacking)
		session_regenerate_id();
		
		// Generate CNerdForum session ID
		if ( !isset( $_SESSION['sessionID'] ) )
			$_SESSION['sessionID'] = self::generateKey( CN_SESSION_KEYLENGTH_SESSID );
		
		// Initialize global objects
		try {
			$GLOBALS['dbo'] =& self::getDBO();
		} catch ( Exception $e ) {
			die( 'Could not connect to the database!' );
		}
		
		// Security layer
		
		if ( strpos( $_SERVER['SCRIPT_FILENAME'], 'login' ) === false ) {
			// Prevent simultaneous sessions if the user is logged in
			if ( isset( $_SESSION['login'] ) ) {
				$query = '
					SELECT 	id 
					FROM 	' . CN_USERS_TABLE . ' 
					WHERE 	login_id = :loginid'
				;
				$GLOBALS['dbo']->createQuery( $query );
				$GLOBALS['dbo']->bind( ':loginid', $_SESSION['login'] );
				$simultaneous = $GLOBALS['dbo']->runQuery();
				
				if ( $GLOBALS['dbo']->hasError( $simultaneous ) ) {
					$GLOBALS['dbo']->submitErrorLog( $simultaneous, 'CN->init() - Security Layer' );
					$this->enqueueMessage(
						'An error occurred while loading the page.',
						CN_MSG_ERROR,
						$_SESSION['sessionID']
					);
					
					if ( strpos( $_SERVER['REQUEST_URI'], 'login' ) === false )
						CN::redirect( CN_WEBLOGIN );
						
				} elseif ( $GLOBALS['dbo']->num_rows( $simultaneous ) == 0 ) {
					// Throw away everything but sessionID & username
					foreach( $_SESSION as $key => $value ) {
						if ( $key == 'sessionID' || $key == 'username' )
							continue;
						unset( $_SESSION[$key] );
					}
					
					$this->enqueueMessage(
						'You were logged out because you have logged into another location.',
						CN_MSG_WARNING,
						$_SESSION['sessionID']
					);
					
					// Redirect
					CN::redirect( CN_WEBLOGIN );
				
				// Reidrect the user to login page if not logged in and site is not offline
				} else {
					if ( CN_STATUS != CN_ST_OFFLINE )
						CN::redirect( CN_WEBLOGIN . ( ( $_SERVER['REQUEST_URI'] != '/' ) ? '?r=' . base64_encode( $_SERVER['REQUEST_URI'] ) : '' ) );
				}
			}
		}
		
		// Initialize more global objects (specifically, the user object)
		if ( isset( $_SESSION['login'] ) ) {
			try {
				$GLOBALS['user'] =& self::getUser();
				
				// If the session expired, log the user out and prompt for relogin
				if ( ( time() - $GLOBALS['user']->lastAccessed() ) > CN_SESSION_EXPIRE && $_SERVER['REQUEST_URI'] != '/logout' ) {
					$GLOBALS['user']->logout( true );
					$this->enqueueMessage(
						'Your session has expired, please login again.',
						CN_MSG_WARNING,
						$_SESSION['sessionID']
					);
					$_SESSION['username'] = $GLOBALS['user']->username;
					CN::redirect( CN_WEBLOGIN );
				} else {
					// Update the "last accessed" timestamp for user
					$GLOBALS['user']->touch();
				}
			} catch( Exception $e ) {
				die( 'An error occurred while retrieving the user information. ' . $e->getMessage() );
			}
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