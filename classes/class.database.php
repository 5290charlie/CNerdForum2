<?php

/*** Class Databse ***

	Developed by: Varun Varada
	Date Developed: December 17th, 2009
	Latest Revision: March 23rd, 2013
	Updated By: Charlie McClung
	
	This class extends the MySQLi class to incorporate several features:
	
		1. Binding of variables to SQL queries to prevent SQL injections
		2. Creation of messages
		3. Error logging
		4. Better control of error flagging and response
	
	This was created with the original intention of escaping variables in a SQL query.
	Silly ITS. PHP Tricks are for kids.
	
*/

// Prevent direct access
defined( '_CN_EXEC' ) or die( 'Restricted access' );

class CN_Database extends MySQLi {

	private $results;
	private $errors;
	private $error_msg;
	private $curSQLkey;
	private $queryLog;
	private $query;
	private $stopflag;
	private $stopflagresponse;

	// Connect to the database and initialize the DBO
	public function __construct() {
		$this->results = array();
		$this->queryLog = array();
		$this->errors = array();
		$this->error_msg = array();
		$this->query = '';
		$this->query = false;
		$this->stopflagresponse = '';
		parent::__construct( CN_DB_HOST, CN_DB_USER, CN_DB_PASS, CN_DB_DBNAME );
		if ( $this->connect_error ) {
			throw new Exception( 'An error occurred while connecting to the database!' );
		}
		// Make the connection UTF-8 compatible
		if ( !$this->set_charset( 'utf8' ) ) {
			throw new Exception( 'An error occurred while changing the charset of the database!' );
		}
	}
	
	// Release all result objects and variables, and destroy the DBO
	public function __destruct() {
		foreach( $this->results as $r ) {
			if ( is_object( $r ) )
				$r->free();
		}
		unset( $this->results );
		unset( $this->errors );
		unset( $this->error_msg );
		unset( $this->curSQLkey );
		unset( $this->queryLog );
		unset( $this->query );
		unset( $this->stopflag );
		unset( $this->stopflagresponse );
		$this->close();
	}
	
	// Gets (creates if non-existent) a reference to an instace of this class
	public static function &getInstance() {
		static $instance;
		
		if ( !is_object( $instance ) ) {
			$class = __CLASS__;
			$instance = new $class();
			unset( $class );
		}
		
		return $instance;
	}
	
	// Select a database
	public function select_db( $db ) {
		return parent::select_db( $db );
	}
	
	// Close the database connection
	public function close() {
		parent::close();
	}
	
	// Reset the database connection
	public function reset() {
		$this->results = array();
		$this->queryLog = array();
		$this->errors = array();
		$this->error_msg = array();
		$this->query = '';
		$this->query = false;
		$this->stopflagresponse = '';
		parent::__construct( CN_DB_HOST, CN_DB_USER, CN_DB_PASS, CN_DB_DBNAME );
		if ( $this->connect_error ) {
			throw new Exception( 'An error occurred while reconnecting to the database!' );
		}
	}
	
	// Initialize a query
	public function createQuery( $query ) {
		// Reset the Stop Flag and Stop Flag Response
		$this->stopflag = false;
		$this->stopflagresponse = '';
		$this->query = $query;
	}
	
	// Bind the variable placeholder with its SQL-safe value
	public function bind( $str2find, $var ) {
		if ( strpos( $this->query, $str2find ) > 0)
			$this->query = str_replace( $str2find, '"' . $this->sqlsafe( $var ) . '"', $this->query );
		else {
			$this->stopflag = true;
			$this->stopflagresponse = 'Cannot find ' . $str2find . ' in query string. ' . strpos( $this->query, $str2find );
		}
	}
	
	// Execute the current query against the database
	public function runQuery() {
		if ( $this->hasStopFlag() )
			return $this->hasStopFlag();
		
		$sqlkey = $this->query( $this->query );
		if ( $this->hasError( $sqlkey ) ) {
			$this->stopflag = true;
			$this->stopflagresponse = $this->getErrorMsg( $sqlkey );
		}
		return $sqlkey;
	}
	
	// Returns the current query
	public function getCurQuery() {
		return $this->query;
	}
	
	// Executes a specified query against the database
	public function query( $query ) {
		// SQLkey is the "key" behind multiple queries with one object
		$SQLkey = $this->_genSQLkey();
		$this->curSQLkey = $SQLkey;
		
		// Add the result of the query to our array of results
		$this->query = $query;
		$this->results[$SQLkey] = parent::query( $query );
		
		// If there is an error, add that to the errors array and add the message to the error messages array
		if ( $this->error ) {
			$this->errors[$SQLkey] = true;
			$this->error_msg[$SQLkey] = $this->error;
		}
		
		return $SQLkey;
	}
	
	// Returns the MySQLi_Result object associated with a previously executed query
	public function getResultObject( $SQLkey = null ) {
		if ( is_null( $SQLkey ) ) {
			$SQLkey = $this->curSQLkey;
		}
		
		return ( (is_object( $this->results[$SQLkey] )) ? $this->results[$SQLkey] : null );
	}
	
	// Returns the number of rows associated with a previously executed query
	public function num_rows( $SQLkey = null ) {
		if ( is_null( $SQLkey ) ) {
			$SQLkey = $this->curSQLkey;
		}
		return $this->results[$SQLkey]->num_rows;
	}
	
	// Returns the value of a specified data cell from a previously executed query
	public function field( $row, $field, $SQLkey = null ) {
		if ( is_null( $SQLkey ) )
			$SQLkey	= $this->curSQLkey;
		$this->results[$SQLkey]->data_seek( $row );
		$row = $this->results[$SQLkey]->fetch_assoc();
		return $row[$field];
	}
	
	// Returns the SQL-safe version of the specified string
	public function sqlsafe( $string ) {
		return $this->real_escape_string( $string );
	}
	
	// Frees the memory for a specified result object
	public function free( $SQLkey = null ) {
		if ( is_null( $SQLkey ) )
			$SQLkey	= $this->curSQLkey;
		
		if ( array_key_exists( $SQLkey, $this->results ) ) {
			if ( is_object( $this->results[$SQLkey] ) )
				$this->results[$SQLkey]->free();
			if ( $this->results[$SQLkey] === false ) {
				unset( $this->errors[$SQLkey] );
				unset( $this->error_msg[$SQLkey] );
			}
			unset( $this->results[$SQLkey] );
		}
	}
	
	// Adds an error message to the message queue and redirects to a specified address
	public function formErrorMessage( $sessionID, $redirect, $SQLKey = null ) {
		$cn =& CN::getInstance();
		
		if ( is_null( $SQLkey ) )
			$SQLKey = $this->curSQLkey;
		
		$cn->enqueueMessage(
			'SQL Error: ' . $this->getErrorMsg( $SQLKey ),
			CN_MSG_ERROR,
			$sessionID
		);
		CN::redirect( $redirect );
	}
	
	// Appends an SQL related entry to the error log and stops execution if a stop flag has been raised
	public function submitErrorLog( $SQLKey = null, $description = '' ) {
		if ( is_null( $SQLKey ) )
			$SQLKey = $this->curSQLkey;
		
		$query	=	'
			INSERT INTO		' . CN_ERROR_LOG_TABLE . '
			( description, error, datelogged )
			VALUES
			( :description, :error, NOW() )'
		;
		$description = ( (!empty( $description )) ? 'Custom Message:' . "\n" . $description . "\n\n" : '' ) . 'Associated Query:' . "\n\n" . $this->getCurQuery();
		$this->createQuery( $query );
		$this->bind( ':description', $description );
		$this->bind( ':error', $this->getErrorMsg( $SQLKey ) );
		$response = $this->runQuery();
		
		if ( $this->hasStopFlag() ) {
			die( 'An unexpected error occurred. We are sorry for any inconvenience.' );
		}
	}
	
	// Appends a custom entry to the error log and stops execution if a stop flag has been raised
	public function submitCustomErrorLog( $description, $error_msg = '' ) {
		$query	=	'
			INSERT INTO		' . CN_ERROR_LOG_TABLE . '
			( description, error, datelogged )
			VALUES
			( :description, :error, NOW() );
		';
		$this->createQuery( $query );
		$this->bind( ':description', $description );
		$this->bind( ':error', $error_msg );
		$response = $this->runQuery();
		
		if ( $this->hasStopFlag() ) {
			//die( $this->stopflagresponse . '<br />' . $this->query );
			die( 'An unexpected error occurred. We are sorry for any inconvenience.' );
		}
	}
	
	// Returns whether the "stop flag" has been set or not
	public function hasStopFlag() {
		return $this->stopflag;
	}
	
	// Returns the "stop flag" response
	public function getStopFlagResponse() {
		return $this->stopflagresponse;
	}
	
	// Checks to see whether an executed query resulted in an error
	public function hasError( $SQLkey = NULL ) {
		if ( is_null( $SQLkey ) )
			$SQLkey = $this->curSQLkey;
		
		if ( array_key_exists( $SQLkey, $this->errors ) ) {
			return true;
		} else {
			return false;
		}
	}
	
	// Returns the error message associated with a specified query, if any
	public function getErrorMsg( $SQLkey = NULL ) {
		if ( is_null( $SQLkey ) )
			$SQLkey = $this->curSQLkey;
		if ( array_key_exists( $SQLkey, $this->errors ) ) {
			return $this->error_msg[$SQLkey];
		} else {
			return '';
		}
	}
	
	// Sets a custom error message for a specific query
	protected function set_error( $SQLkey = NULL, $string ) {
		if ( is_null( $SQLkey ) )
			$SQLkey	= $this->curSQLkey;
		
		$this->errors[$SQLkey] = true;
		$this->error_msg[$SQLkey] = $string;
	}
	
	// Removes the error associated with a specific query
	protected function unset_error( $SQLkey = NULL ) {
		if ( is_null( $SQLkey ) )
			$SQLkey	= $this->curSQLkey;
		
		$this->errors[$SQLkey] = false;
		unset( $this->error_msg[$SQLkey] );
	}
	
	// Generates a pseudo-random key used to uniquely identify a query result
	private function _genSQLkey( $length = 10 ) {
		// The character set used for the keys
		$set = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$SQLkey = '';
		// Loop through, appending random characters to the temporary SQL key, length times
		while( $length > 0 ) {
			// Add a random character from the character set to the temporary SQL key
			$SQLkey	.=	substr( $set, mt_rand( 0, strlen( $set ) - 1 ), 1 );
			// Decrement length
			$length--;
		}
		
		return $SQLkey;
	}
	
}

?>