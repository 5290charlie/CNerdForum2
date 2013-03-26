<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) && !empty( $_POST['username'] ) && !empty( $_POST['password'] ) ) {
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

*/
				
				// Login successful
			}
	}
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