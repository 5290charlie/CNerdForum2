<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['username'] ) && !empty( $_POST['password'] ) ) {
	echo 'posted ';
	print_r($_POST);
	/*
	// Authenticate User
	$response = CN_User::authenticate( $_POST['username'], $_POST['password'] );
	
	CN_AUTH_ERROR_SQL     - SQL Error
		CN_AUTH_ERROR_SUCCESS - Success
		CN_AUTH_ERROR_INVALID - Invalid credentials (password)
		CN_AUTH_ERROR_NOUSER  - Invalid credentials (username)
		CN_AUTH_ERROR_UNKNOWN - Unknown Error
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
				case CN_LOGIN_ERROR:
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
		case CN_AUTH_UNKNOWN:
		default:
			$cn->enqueueMessage(
				'An unknown error occurred while trying to log in. Please try again.',
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
			break;
	}
	*/
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
								<input type="text" id="username" name="username" autocomplete="off" />
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
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>