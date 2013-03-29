<?php

/*************************************************
			Login Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		Displays form for a user to login to
		CNerdForum
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

// If the user is already logged in, redirect to home
if ( isset( $user ) && $user->isOnline() ) {
	$cn->enqueueMessage(
		'You are already logged in!',
		CN_MSG_ANNOUNCEMENT,
		$_SESSION['sessionID']
	);
	CN::redirect( CN_WEBROOTPAGE );
}

// Handle login POST request
if ( !empty( $_POST ) && !empty( $_POST['username'] ) && !empty( $_POST['password'] ) ) {
	
	// Authenticate User
	$response = CN_User::authenticate( $_POST['username'], $_POST['password'] );
		
	switch( $response ) {
		// A error occurred with the database
		case CN_AUTH_ERROR_SQL:
			$cn->enqueueMessage(
				'An error occurred authenticating you with the database.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
			break;
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
				// Login successful
				case CN_LOGIN_SUCCESS:
					CN::redirect( $login_response[1] );
					break;
				// Login failed
				case CN_LOGIN_ERROR:
				default:
					$cn->enqueueMessage(
						'An error occurred while logging you in.',
						CN_MSG_ERROR,
						$_SESSION['sessionID']
					);
					break;
			}
			break;
		
		// Incorrect password
		case CN_AUTH_ERROR_INVALID:
			$cn->enqueueMessage(
				'Wrong password. Please try again.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
			break;
		// Incorrect username
		case CN_AUTH_ERROR_NOUSER:
			$cn->enqueueMessage(
				'Username does not exist.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
			break;
		// Unknown error
		case CN_AUTH_ERROR_UNKNOWN:
		default:
			$cn->enqueueMessage(
				'An unknown error occurred while trying to log in. Please try again.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
			break;
	}
// Bad POST variable combination
} elseif ( !empty( $_POST ) ) {
	$cn->enqueueMessage(
		'The username/password combination is incorrect.',
		CN_MSG_ERROR,
		$_SESSION['sessionID']
	);
}

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<form id="login" method="post" action="<?php echo CN_WEBLOGIN . ( ( isset( $_GET['r'] ) && !empty( $_GET['r'] ) ) ? '?r=' . $_GET['r'] : '' ); ?>">
					<table>
						<tr>
							<td class="right">
								<label for="username">Username:</label>
							</td>
							<td>
								<input type="text" id="username" name="username" value="<?php ( isset( $_SESSION['username'] ) ? $_SESSION['username'] : '' ); ?>" autocomplete="off" />
							</td>
						</tr>
						<tr>
							<td class="right">
								<label for="password">Password:</label>
							</td>
							<td>
								<input type="password" id="password" name="password" autocomplete="off" />
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<input type="submit" class="button" value="Login" />
							</td>
						</tr>
					</table>
				</form>	
				<hr>
				<a class="button" href="<?php echo CN_WEBSIGNUP; ?>">Sign Up!</a>			
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>