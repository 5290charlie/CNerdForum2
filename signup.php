<?php

/*************************************************
			Signup Page
**************************************************
	Author: Charlie McClung
	Updated: 3/29/2013
		Displays form for users to signup for
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
if ( !empty( $_POST ) && !empty( $_POST['firstname'] ) && !empty( $_POST['lastname'] ) 
	&& !empty( $_POST['email'] ) && !empty( $_POST['username'] )
	&& !empty( $_POST['password'] ) && !empty( $_POST['passconf'] ) 
) {
	if ( $_POST['password'] == $_POST['passconf'] ) {
		if ( CN_User::add( $_POST ) ) {
			$cn->enqueueMessage(
				'User created!',
				CN_MSG_SUCCESS,
				$_SESSION['sessionID']
			);
			CN::redirect( CN_WEBLOGIN );
		} else {
			$cn->enqueueMessage(
				'Error creating new user: ' . $_POST['username'],
				CN_MSG_ERROR,
				$_SESSION['sessionID']
			);
		}
	} else {
		$cn->enqueueMessage(
			'Passwords do not match',
			CN_MSG_ERROR,
			$_SESSION['sessionID']
		);
	}
// Bad POST variable combination
} elseif ( !empty( $_POST ) ) {
	$cn->enqueueMessage(
		'The signup information is incorrect or missing.',
		CN_MSG_ERROR,
		$_SESSION['sessionID']
	);
}

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<form id="signup" method="post" action="<?php echo CN_WEBSIGNUP; ?>">
					<table>
						<tr>
							<td class="right">
								<label for="firstname">First Name:</label>
							</td>
							<td>
								<input type="text" id="firstname" name="firstname" />
							</td>
						</tr>
						<tr>
							<td class="right">
								<label for="lastname">Last Name:</label>
							</td>
							<td>
								<input type="text" id="lastname" name="lastname" />
							</td>
						</tr>
						<tr>
							<td class="right">
								<label for="email">Email:</label>
							</td>
							<td>
								<input type="email" id="email" name="email" />
							</td>
						</tr>
						<tr>
							<td class="right">
								<label for="username">Username:</label>
							</td>
							<td>
								<input type="text" id="username" name="username" />
							</td>
						</tr>
						<tr>
							<td class="right">
								<label for="password">Password:</label>
							</td>
							<td>
								<input type="password" id="password" name="password" />
							</td>
						</tr>
						<tr>
							<td class="right">
								<label for="passconf">Confirm Password:</label>
							</td>
							<td>
								<input type="password" id="passconf" name="passconf" />
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<input type="submit" class="button" value="Sign Up!" />
							</td>
						</tr>
					</table>
				</form>
				<p>Already have an account? <a class="button" href="<?php echo CN_WEBLOGIN; ?>">Click Here to Login</a></p>
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>