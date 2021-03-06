<?php

/*************************************************
			CN_Error Class
**************************************************
	Author: Charlie McClung
	Updated: 3/25/2013
		Class designed to be the custom error
		handler for CNerdForum (defined in 
		config.php)
*************************************************/

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted access' );

class CN_Error {
	
	// Custom function to handle errors
	public static function handleError( $err_type, $err_str, $err_file, $err_line ) {
		$cn =& CN::getInstance();
		
		// If current session is logged in, get current user
		if ( isset( $_SESSION['login'] ) )
			$user =& CN::getUser();
		
		if( in_array( $err_type, array( E_WARNING, E_NOTICE, E_CORE_WARNING, E_COMPILE_WARNING, E_USER_WARNING, E_USER_NOTICE, E_STRICT ) ) ) {
				
			// Should log errors if the site is live and if errors are not being displayed
			if( CN_STATUS != CN_ST_LIVE && isset( $_SESSION['login'] ) && $user->permission > CN_PERM_USER ) {
				$cn->enqueueMessage( 
					'Type: ' . $err_type . '<br />' . $err_str . '<br />' . 'File: ' . $err_file . '<br />' . 'Line: ' . $err_line,
					CN_MSG_WARNING,
					$_SESSION['sessionID']
				);
			} else {
				error_log( '"' . $err_str . '" on line ' . $err_line . ' in ' . $err_file );
			}
		} else {
			if( CN_STATUS == CN_ST_LIVE || !isset( $_SESSION['login'] ) ) {
				error_log( 'Fatal: "' . $err_str . '" on line ' . $err_line . ' in ' . $err_file );
				die( CN_GLOBAL_ERR );
			} else {
				die( 'Type: ' . $err_type . '<br />' . $err_str . '<br />' . 'File: ' . $err_file . '<br />' . 'Line: ' . $err_line );
			}
		}
	}
	
	// Validates various types of input
	public static function handleException( $e ) {
		
		// Should log exceptions if site is live and if errors are not being displayed
		if ( CN_STATUS != CN_ST_LIVE && isset( $_SESSION['login'] ) ) {
			echo 'Exception Type: ' . $e->getCode() . '<br />';
			echo $e->getMessage() . '<br />';
			echo 'File: ' . $e->getFile() . '<br />';
			echo 'Line: ' . $e->getLine() . '<br />';
		} else {
			error_log( 'Exception: "' . $e->getMessage() . '" on line ' . $e->getLine() . ' in ' . $e->getFile() );
			die( CN_GLOBAL_ERROR );
		}
	}
}

?>