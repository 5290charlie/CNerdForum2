<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

// Define User Class
class CN_User {
	
	// All members of the user class
	public $id;
	public $username;
	public $firstname;
	public $lastname;
	public $email;
	public $permission;
	
	// Initializes a new user object with the specified user's data
	public function __construct( $criteria ) {
		$required_data = array(
			'username',
			'firstname',
			'lastname',
			'email'
		);
		
		// Return null if criteria array is missing required data
		if ( !self::required( $required_data, $criteria ) ) 
			return null;
			
		$this->username = $criteria['username'];
		$this->firstname = $criteria['firstname'];
		$this->lastname = $criteria['lastname'];
		$this->email = $criteria['email'];
		
		// Set user permission (default = CN_PERM_USER
		$valid_perm = ( !is_numeric( $criteria['permission'] ) && ( $criteria['permission'] > CN_PERM_USER && $criteria['permission'] < CN_PERM_ADMIN ) );
		if ( !isset( $criteria['permission'] ) || !$valid_perm )
			$this->permission = CN_PERM_USER
		else
			$this->permission = $criteria['permission'];
			
		return self;
	}
	
	// Gets (creates if non-existent) a reference to a logged-in user object that holds that user's information
	public static function &getInstance() {
		// TODO
	}
	
	// Private function that validates two passwords
	private static function validate_password( $stored_password, $password )
	{
		$salt = substr( $stored_password, 0, 64 );
		$hash = substr( $stored_password, 64, 64 );
		
		$password_hash = hash('md5', $salt . $password);
		
		return $password_hash == $hash;
	}
	
	private static function required( $required, $data )
	{
		foreach ( $required as $field ) {
			if ( !isset( $data[$field] ) )
				return false;
		}
		return true;
	}
	
	// Authenticates a user
	/* 
	   Status Codes:
	 
		CN_AUTH_ERR_SQL - SQL Error
		CN_AUTH_SUCCESS - Success
		CN_AUTH_INVALID - Invalid credentials (username/password)
		CN_AUTH_LOCKED - Account Locked
		 
	*/
	public static function authenticate( $username, $password ) {
		// Static context
		$sqlobj =& CN::getDBO();
				
		/*** Authenticate the user against the database ***/
		$query = '
			SELECT password
			FROM '
			. CN_USERS_TABLE .
			' WHERE username = :username'
		;
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
			$query = ' SELECT * FROM '
				. CN_USERS_TABLE . 
				' WHERE username=:username
			';
			$sqlobj->createQuery( $query );
			$sqlobj->bind( ':username', $username );
			if ( $response = $sqlobj->runQuery() )
				print_r($sqlobj->getResultObject( $response ))
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
	   
		CN_LOGIN_ERR_SQL - SQL Error
		CN_LOGIN_SUCCESS - Success
		CN_LOGIN_PARTSUCCESS - Success, with warning (previous location retrieval problem)
	*/
	public function login( $redirect = null ) {
		// TODO
	}
	
	// Logs the current user out
	public function logout( $session_expired = false ) {
		// TODO
	}
	
	// Returns the last accessed timestamp of the current user
	public function lastAccessed() {
		// TODO
	}
	
	// Updates the "last accessed" timestamp in the user's session
	public function touch() {
		// TODO
	}
	
	// Checks to see whether the current user is logged in (online)
	public function isOnline() {
		// TODO
	}
	
	// Check if user is flagged
	public function isFlagged() {
		// TODO
	}
	
	// Set flag for user
	public function toggleFlag( $direction, $reason = null ) {
		// TODO
	}
	
	// Adds a new user
	public static function add( array $parameters ) {
		// TODO
	}
	
	// Deletes a user
	public static function delete( $id ) {
		// TODO
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
		// TODO
	}
}

?>