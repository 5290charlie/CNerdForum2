<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

final class CN {
	
	// Checks $data array for $required keys
	private static function required( $required, $data )
	{
		foreach ( $required as $field ) {
			if ( !isset( $data[$field] ) )
				return false;
		}
		return true;
	}
	
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
		
		echo '<br />';
		echo 'before beginning session';
		echo '<br />';

		// Begin Session
		session_name( CN_SESSION_NAME );
		session_start();
		
		// Regenerate session ID (hinders session hijacking)
		session_regenerate_id();

		echo '<br />';
		echo 'after session init';
		echo '<br />';
		
		// Generate CNerdForum session ID
		if ( !isset( $_SESSION['sessionID'] ) )
			$_SESSION['sessionID'] = self::generateKey( CN_SESSION_KEYLENGTH_SESSID );
		
		// Initialize global objects
		try {
			$GLOBALS['dbo'] =& self::getDBO();
		} catch ( Exception $e ) {
			die( 'Could not connect to the database!' );
		}
		
		echo '<br />';
		echo 'SERVER[SCRIPT_FILENAME]=' . $_SERVER['SCRIPT_FILENAME'];
		echo '<br />';
		echo 'SERVER[REQUEST_URI]=' . $_SERVER['REQUEST_URI'] . '<br />';
		
		// Security layer
		if ( strpos( $_SERVER['SCRIPT_FILENAME'], 'login' ) === false ) {
			echo '<br />script_filename===false<br />';
			// Prevent simultaneous sessions if the user is logged in
			if ( isset( $_SESSION['login'] ) ) {
				echo '<br />';
				echo 'session[login] set';
				echo '<br />';

				$query = '
					SELECT 	user_id 
					FROM 	' . CN_USERS_TABLE . ' 
					WHERE 	login_id = :loginid
				';
				$GLOBALS['dbo']->createQuery( $query );
				$GLOBALS['dbo']->bind( ':loginid', $_SESSION['login'] );
				$response = $GLOBALS['dbo']->runQuery();
				
				if ( $GLOBALS['dbo']->hasError( $response ) ) {
					$GLOBALS['dbo']->submitErrorLog( $response, 'CN->init() - Security Layer' );
					$this->enqueueMessage(
						'An error occurred while loading the page.',
						CN_MSG_ERROR,
						$_SESSION['sessionID']
					);
					
					if ( strpos( $_SERVER['REQUEST_URI'], 'login' ) === false ) {
						$this->enqueueMessage(
							'redirected to login',
							CN_MSG_WARNING,
							$_SESSION['sessionID']
						);
						CN::redirect( CN_WEBLOGIN );
					}	
				} elseif ( $GLOBALS['dbo']->num_rows( $response ) == 0 ) {
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
				
				print_r( $GLOBALS['user'] );
				
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
		$dbo =& self::getDBO();
		
		// Map message string types to message codes (if possible)
		if ( !is_numeric( $type ) || ( $type < CN_MSG_ERROR || $type > CN_MSG_SUCCESS ) ) {
			switch( $type ) {
				case 'error':
					$type = CN_MSG_ERROR;
					break;
				case 'warning':
					$type = CN_MSG_WARNING;
					break;
				case 'announcement':
					$type = CN_MSG_ANNOUNCEMENT;
					break;
				case 'success':
					$type = CN_MSG_SUCCESS;
					break;
				default:
					$type = CN_MSG_WARNING;
					break;
			}
		}
		
		// Make sure message doesn't already exist
		$query = '
			SELECT	session_id 
			FROM	' . CN_MESSAGES_TABLE . ' 
			WHERE	session_id = :session 
			AND		type = :type 
			AND		message = :msg
		';
		
		$dbo->createQuery( $query );
		$dbo->bind( ':session', $session );
		$dbo->bind( ':type', $type );
		$dbo->bind( ':msg', $message );
		$duplicate = $dbo->runQuery();
		
		try {
			if ( $dbo->hasStopFlag() ) {
				$dbo->submitErrorLog( $duplicate, 'CN::enqueueMessage() - Error finding duplicates' );
				throw new Exception( 'DB query failed' );
			} else {
				if ( $dbo->num_rows( $duplicate ) != 0 )
					return true;
			}
			
			// Find out what the highest ID is (if no rows exist, return 1
			$query = '
				SELECT	IFNULL( MAX(message_id) + 1, 1 ) AS maxid 
				FROM 	' . CN_MESSAGES_TABLE
			;
			
			$lastidquery = $dbo->query( $query );
			
			if ( $dbo->hasError( $lastidquery ) ) {
				$dbo->submitErrorLog( $lastidquery, 'CN::enqueueMessage() - Error finding last message_id' );
				throw new Exception( 'DB query failed' );
			}
			
			$maxid = $dbo->field( 0, 'maxid', $lastidquery );
			
			$query = '
				INSERT 
				INTO	' . CN_MESSAGES_TABLE . '
				VALUES	( :id, :msg, :type, :session )
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':id', $maxid );
			$dbo->bind( ':msg', $message );
			$dbo->bind( ':type', $type );
			$dbo->bind( ':session', $session );
			
			$response = $dbo->runQuery();
			
			if ( $dbo->hasStopFlag() ) {
				$dbo->submitErrorLog( $response, 'CN::enqueueMessage() - Error enqueuing system message' );
				throw new Exception( 'DB query failed' );
			}
		// If DB fails, fall back to session messages
		} catch ( Exception $e ) {
			if ( !isset( $_SESSION['messages'] ) || empty( $_SESSION['messages'] ) ) {
				$_SESSION['messages'][$type][] = $message;
			} elseif ( !in_array( $message, $_SESSION['messages'][$type] ) ) {
				$_SESSION['messages'][$type][] = $message;
			}
		}
		
		return true;
	}
	
	// Retrieves the message queue for this session
	public function getMessages( $session = null ) {
		$dbo =& self::getDBO();
		$session = ( empty( $session ) ) ? $_SESSION['sessionID'] : $session;
		
		$query = '
			SELECT	message, type 
			FROM	' . CN_MESSAGES_TABLE . ' 
			WHERE	session_id = :session
		';
		
		$dbo->createQuery( $query );
		$dbo->bind( ':session', $session );
		$response = $dbo->runQuery();
		
		if ( $dbo->hasStopFlag() ) {
			$dbo->submitErrorLog( $response, 'CN::getMessages() - Error retrieving messages' );
			return array(
				'error' => array( 'An error occurred while retrieving the system messages. Please try again later.' )
			);
		} else {
			// Get session messages
			$messages = array();
			if ( isset( $_SESSION['messages'] ) && !empty( $_SESSION['messages'] ) ) {
				foreach( $_SESSION['messages'] as $message_type => $message_cue ) {
					foreach( $message_cue as $message ) {
						$messages[$message_type][] = $message;
					}
				}
				
				unset( $_SESSION['messages'] );
			}
			
			for ( $a = 0; $a < $dbo->num_rows( $response ); $a++ ) {
				switch( $dbo->field( $a, 'type', $response ) ) {
					case CN_MSG_ERROR:
					case CN_MSG_WARNING:
					case CN_MSG_ANNOUNCEMENT:
					case CN_MSG_SUCCESS:
						$type = $dbo->field( $a, 'type', $response );
						break;
					default:
						$type = CN_MSG_WARNING;
						break;
				}
				
				$messages[$type][] = $dbo->field( $a, 'message', $response );
			}
			
			$query = '
				DELETE 
				FROM	' . CN_MESSAGES_TABLE . '
				WHERE	session_id = :session
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':session', $session );
			$response = $dbo->runQuery();
			
			if ( $dbo->hasStopFlag() ) {
				$dbo->submitErrorLog( $response, 'CN::getMessages() - Error deleting retrieved messages' );
				return array(
					'error' => array(
						0 => 'An error occurred while retrieving the system messages. Please try again later.'
					)
				);
			}
		}
		
		return $messages;
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