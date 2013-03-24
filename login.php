<?php
// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<form id="login" method="post" action="<?php echo CN_WEBDIR_SCRIPTS; ?>authenticate.php">
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