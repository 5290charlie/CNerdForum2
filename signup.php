<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

if ( !empty( $_POST ) ) {
	
}

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<form id="signup" method="post" action="<?php echo CN_WEBSIGNUP; ?>">
					<table>
						<tr>
							<td class="right">
								<label for="firstname">Firstname:</label>
							</td>
							<td>
								<input type="text" id="firstname" name="firstname" />
							</td>
						</tr>
						<tr>
							<td class="right">
								<label for="lastname">Lastname:</label>
							</td>
							<td>
								<input type="text" id="lastname" name="lastname" />
							</td>
						</tr>
						<tr>
							<td class="right">
								<label for="email">Username:</label>
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
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>