<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

echo('CN_User classfile');

/***************************************
		 User Table Structure
****************************************
	user_id, int(255), PrimaryKey, AI
	login_id, int(255), NULL
	username, varchar(255)
	password, varchar(255)
	firstname, varchar(255)
	lastname, varchar(255)
	email, varchar(255)
	permission, int(5), Default:1
	session_id, varchar(255), NULL
	last_accessed, int(255), NULL
***************************************/


// Define User Class
class CN_User {
	
	// All members of the user class
	public $id;
	public $username;
	public $firstname;
	public $lastname;
	public $fullname;
	public $email;
	public $permission;
	
	// Initializes a new user object with the specified user's data
	public function __construct( $criteria ) {
		$dbo =& CN::getDBO();
		
		// Build query depending on criteria
		if ( is_numeric( $criteria ) ) {
			$query = '
				SELECT 	* 
				FROM 	' . CN_USERS_TABLE . ' 
				WHERE 	user_id = ' . $dbo->sqlsafe( $criteria )
			;
		} else {
			$query = '
				SELECT 	* 
				FROM 	' . CN_USERS_TABLE . '
				WHERE 	username = "' . $dbo->sqlsafe( $criteria ) . '" 
				OR 		login_id = "' . $dbo->sqlsafe( $criteria ) . '"
			';
				
		}
				
		$response = $dbo->query( $query );
				
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $userquery, 'CN_User::__construct()' );
		}
		if ( $dbo->num_rows( $response ) != 1 ) {
			// User doesn't exist!
		}
				
		$row = $dbo->getResultObject( $response )->fetch_object();
		$this->id			= $row->user_id;
		$this->username		= $row->username;
		$this->firstname	= $row->firstname;
		$this->lastname		= $row->lastname;
		$this->fullname		= $this->firstname . ' ' . $this->lastname;
		$this->email		= $row->email;
		$this->permission	= $row->permission;
	}
	
	// Gets (creates if non-existent) a reference to a logged-in user object that holds that user's information
	public static function &getInstance() {
		// Make sure the user is logged in
		if ( !isset( $_SESSION['login'] ) ) {
			throw new Exception( 'The user is not logged in!' );
		}
		
		static $instance;
		
		if ( !is_object( $instance ) ) {
			$class = __CLASS__;
			$instance = new $class( $_SESSION['login'] );
			unset( $class );
			
			// Make sure user is logged in
			if ( !$instance->isOnline() ) {
				throw new Exception( 'The user is not logged in!' );
			}
		}
		
		return $instance;
	}
	
	// Private function that validates two passwords
	private static function validate_password( $stored_password, $password )
	{
		$salt = substr( $stored_password, 0, 64 );
		$hash = substr( $stored_password, 64, 64 );
		
		$password_hash = hash('md5', $salt . $password);
		
		return $password_hash == $hash;
	}
	
	// Authenticates a user
	/* 
	   Status Codes:
	 
		CN_AUTH_ERROR_SQL     - SQL Error
		CN_AUTH_ERROR_SUCCESS - Success
		CN_AUTH_ERROR_INVALID - Invalid credentials (password)
		CN_AUTH_ERROR_NOUSER  - Invalid credentials (username)
		CN_AUTH_ERROR_UNKNOWN - Unknown Error
		 
	*/
	public static function authenticate( $username, $password ) {
		// Static context
		$sqlobj =& CN::getDBO();
				
		/*** Authenticate the user against the database ***/
		$query = '
			SELECT 	password
			FROM 	' . CN_USERS_TABLE . ' 
			WHERE 	username = :username
		';
	
		$sqlobj->createQuery( $query );
		$sqlobj->bind( ':username', $username );
		$response = $sqlobj->runQuery();
		$numRows = $sqlobj->getResultObject( $response )->num_rows;
		$stored_password = $sqlobj->field(0, 'password', $response);
		
		if( $sqlobj->hasStopFlag() ) 
		{
			$sqlobj->submitErrorLog( $response, 'User::authenticate() - Error authenticating user: ' . $username );
			return CN_AUTH_ERROR_SQL;
		} 
		else if ( $numRows == 0 ) 
		{
			return CN_AUTH_ERROR_NOUSER;
		}
		
		if ( self::validate_password($stored_password, $password) )
		{
			$query = ' 
				SELECT 	* 
				FROM 	' . CN_USERS_TABLE . ' 
				WHERE 	username = :username
			';
			
			$sqlobj->createQuery( $query );
			$sqlobj->bind( ':username', $username );
			
			if ( $response = $sqlobj->runQuery() )
				return CN_AUTH_SUCCESS;
			else
				return CN_AUTH_ERROR_INVALID;
		}		
		else
		{
			return CN_AUTH_ERROR_UNKNOWN;
		}
	}
	
	// Logs the current user in
	/*
	   Returns: array( status code, redirect location )
	   
	   Status Codes:
	   
		CN_LOGIN_ERROR		- Error
		CN_LOGIN_SUCCESS	- Success
	*/
	public function login( $redirect = null ) {
		
		// Make sure user isn't already logged in
		if ( !$this->isOnline() ) {
			$dbo =& CN::getDBO();
			
			// Redirect to given location, otherwise home
			$redirect = ( empty( $redirect ) ) ? CN_WEBROOTPAGE : $redirect;
			
			// Generate login id and update session vars
			$_SESSION['login'] = CN::generateKey( CN_SESSION_KEYLENGTH_LOGINID );
			$_SESSION['username'] = $this->username;
			
			// Update login_id of user in DB
			$query = '
				UPDATE	' . CN_USERS_TABLE . ' 
				SET 	login_id = :loginid 
				WHERE 	user_id = :uid
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':loginid', $_SESSION['login'] );
			$dbo->bind( ':uid', $this->id );
			$response = $dbo->runQuery();
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_User::login() - Login ID updating failed' );
				return array( CN_LOGIN_ERROR );
			}
			
			// Insert user into sessions table
			$query = '
				INSERT 
				INTO	' . CN_SESSIONS_TABLE . ' 
				VALUES	( :sid, :uid, :timestamp )
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':sid', $_SESSION['sessionID'] );
			$dbo->bind( ':uid', $this->id );
			$dbo->bind( ':timestamp', time() );
			$response = $dbo->runQuery();
			
			// Logged in. Return with redirect location
			return array( CN_LOGIN_SUCCESS, $redirect );
		} else {
			// If user just closed browser, restart session
			if ( $_SESSION['sessionID'] != $this->_session_id() ) {
				if ( $this->logout( true ) ) {
					return $this->login( $redirect );
				} else {
					return array( CN_LOGIN_ERROR );
				}
			}
		}
		
		// Otherwise this function was called twice, redirect
		return array( CN_LOGIN_SUCCESS, $redirect );
	}
	
	// Logs the current user out
	public function logout( $session_expired = false ) {
		
		// Check to make sure the session variable is registered
		if ( $this->isOnline() ) { // User has registered session, ready for logout
			$dbo =& self::getDBO();
			
			// Delete session table entry
			$query = '
				DELETE 
				FROM	' . CN_SESSIONS_TABLE . ' 
				WHERE	user_id = "' . $dbo->sqlsafe( $this->id ) . '"
			';
			$dbo->query( $query );
			
			if ( $dbo->hasError() ) {
				$dbo->submitErrorLog( null, 'CN_User::logout() - Session deletion failure' );
				return false;
			}
			
			// If it's regular logout, normal procedure
			if ( !$session_expired ) {
				
				// Unset all session vars
				$_SESSION = array();
				
				// Delete the session cookie (set expire date to past)
				if ( isset( $_COOKIE[session_name()] ) ) {
					$params = session_get_cookie_params();
					setcookie( session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly'] );
					unset( $params );
				}
				
				// Destroy the session
				session_destroy();
			// If session expired, throw away everything except the sessionID
			} else {
				foreach( $_SESSION as $key => $value ) {
					if ( $key == 'sessionID' || $key == 'username' )
						continue;
					unset( $_SESSION[$key] );
				}
			}
			
			return true;
		}
		
		return false;
	}
	
	// Returns the last accessed timestamp of the current user
	public function lastAccessed() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT	last_accessed 
			FROM 	' . CN_SESSIONS_TABLE . ' 
			WHERE	user_id = "' . $dbo->sqlsafe( $this->id ) . '"
		';
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_User::lastAccessed()' );
			return false;
		}
		
		$timestamp = $dbo->field( 0, 'last_accessed', $response );
		$dbo->free( $response );
		return $timestamp;
	}
	
	// Updates the "last_accessed" timestamp in the user's session
	public function touch() {
		$dbo =& CN::getDBO();
		
		// Make sure the user is online
		if ( $this->isOnline() ) {
			$query = '
				UPDATE	' . CN_SESSIONS_TABLE . ' 
				SET 	last_accessed = :timestamp 
				WHERE	user_id = :uid
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':timestamp', time() );
			$dbo->bind( ':uid', $this->id );
			$response = $dbo->runQuery();
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_User::touch()' );
				return false;
			}
			
			// Return success
			return true;
		} else {
			// Return failure
			return false;
		}
	}
	
	// Checks to see whether the current user is logged in (online)
	public function isOnline() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT	session_id
			FROM	' . CN_SESSIONS_TABLE . ' 
			WHERE	user_id = "' . $dbo->sqlsafe( $this->id ) . '"
		';
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_User::isOnline()' );
			return false;
		}
		
		$isOnline = ( $dbo->num_rows( $response ) == 1 );
		$dbo->free( $response );
		return $isOnline;
	}
	
	// Adds a new user
	public static function add( array $parameters ) {
		$dbo =& CN::getDBO();
		
		$required = array(
			'username',
			'password',
			'firstname',
			'lastname',
			'email'
		);
		
		if ( !CN::required( $required, $parameters ) )
			throw new Exception( 'Required information not provided!', 1 );
			
		if ( !isset( $parameters['permission'] ) || empty( $parameters['permission'] ) )
			$parameters['permission'] = CN_PERM_USER;
			
		$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		$hash = hash('md5', $salt . $parameters['password']);

		$pass = $salt . $hash;
			
		$query = '
			INSERT 
			INTO 	' . CN_USERS_TABLE . ' 
			( username, password, firstname, lastname, email, permission ) 
			VALUES( :user, :pass, :fname, :lname, :email, :perm)
		';
		
		$dbo->createQuery( $query );
		$dbo->bind( ':user', $parameters['username'] );
		$dbo->bind( ':pass', $pass );
		$dbo->bind( ':fname', $parameters['firstname'] );
		$dbo->bind( ':lname', $parameters['lastname'] );
		$dbo->bind( ':email', $parameters['email'] );
		$dbo->bind( ':perm', $parameters['permission'] );
		
		$response = $dbo->runQuery();
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_User::add() - User creation' );
			throw new Exception( 'An error occurred while adding a new user.', -1 );
		} else {
			return true;
		}
		
		return false;
	}
	
	// Deletes a user
	public static function delete( $id ) {
		$dbo =& CN::getDBO();
		
		if ( empty( $id ) || !is_numeric( $id ) )
			throw new Exception( 'Invalid UID', 0 );
			
		$query = '
			DELETE 
			FROM 	' . CN_USERS_TABLE . ' 
			WHERE	user_id = "' . $dbo->sqlsafe( $id ) . '" 
			LIMIT 	1
		';
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_User::delete()' );
			throw new Exception( 'Error while deleting', -1 );
		}
		
		return $dbo->affected_rows == 1;
	}
	
	// Commits the current state of this object to the user data (only commits mutable properties)
	public function commit() {
		// TODO
	}
	
	// Changes and commits the current state of this object with the passed-in array of values
	public function update( array $options ) {
		// TODO
	}
	
	// Get current users mana
	public function getMana() {
		// TODO
	}
	
	// Get current users rank
	public function getRank() {
		// TODO
	}
	
	// Get current users topics
	public function getTopics() {
		// TODO
	}
	
	// Get ALL current users posts
	public function getPosts() {
		// TODO
	}
	
	// Get current users posts from given topic
	public function getPostsFromTopic( $topic ) {
		// TODO
	}
	
	// Get ALL current users comments
	public function getComments() {
		// TODO
	}
	
	// Get current users comments from given post
	public function getCommentsFromPost( $post ) {
		// TODO
	}
	
	// Gets user according to the specified user id
	public static function getUser( $id ) {
		// TODO
	}
	
	// Checks to see if a user exists using a specified user id or username
	public static function exists( $criteria ) {
		// TODO
	}
	
	// Returns the session ID stored in the database for the current user (if online)
	private function _session_id() {
		$dbo =& CN::getDBO();
		
		$query		=	'
			SELECT		session_id
			FROM		' . CN_SESSION_TABLE . '
			WHERE		user_id = "' . $dbo->sqlsafe( $this->id )  . '"'
		;
		$sessionquery = $dbo->query( $query );

		if ( $dbo->hasError( $sessionquery ) ) {
			$dbo->submitErrorLog( $sessionquery, 'CN_User::isOnline()' );
			return false;
		}
		
		if ( $dbo->num_rows() ) {
			$sessionID = $dbo->field( 0, 'session_id', $sessionquery );
			$dbo->free( $sessionquery );
			return $sessionID;
		} else {
			return false;
		}
	}
}

?>