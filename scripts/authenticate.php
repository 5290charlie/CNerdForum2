<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Initialize System
$cn =& CN::getInstance();
$cn->init();

if ( isset( $_POST ) && !empty( $_POST['username'] ) && !empty( $_POST['password'] ) ) {
	// Authenticate User
	$response = CN_User::authenticate( $_POST['username'], $_POST['password'] );
	
	switch( $response ) {
		// Authentican successful
		case CN_AUTH_SUCCESS:
			// Log user in
			$user = new CN_User( $_POST['username'] );
			// If a redirect location has been specified, pass that in
			if ( isset( $_GET['r'] ) && !empty( $_GET['r'] ) ) {
				$login_response = $user->login( substr( CN_WEBROOTPAGE, 0, -1 ) . base64_decode( $_GET['r'] ) );
			} else {
				$login_response = $user->login();
			}
			
			// Handle login response
			switch( $login_response[0] ) {
/*

Add CN_AUTH_CREATED for newly created users to auto login
add CN_SESSION_EXPIRE for session expire time (1800)

*/
				
				// Login successful
			}
	}
}
?>