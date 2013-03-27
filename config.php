<?php

/*************************************************
			CONFIGURATION FILE
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		Define all constants and prepare site
		for use
*************************************************/

// Set error reporting
error_reporting(E_ALL);

/********************
	Constants
********************/

// Defined to ensure internal files have config.php file included
define( '_CN_EXEC', 1 );

// Site Status
define( 'CN_ST_OFFLINE', 0 );
define( 'CN_ST_DEBUG', 1 );
define( 'CN_ST_LIVE', 2 );
define( 'CN_STATUS', CN_ST_DEBUG );

// Global Messages
define( 'CN_GLOBAL_ERROR', 'An unexpected error has occured. Please try again or contact the webmaster.' );

// Register Custom Error & Exception Handlers
require realpath( dirname( __FILE__ ) . '/classes/class.error.php' );
set_error_handler( 'CN_Error::handleError' );
set_exception_handler( 'CN_Error::handleException' );

// Local Paths
define( 'CN_ROOTPAGE', $_SERVER['DOCUMENT_ROOT'] );
define( 'CN_DIR_GLOBALS', CN_ROOTPAGE . 'globals/' );
define( 'CN_DIR_IMAGES', CN_ROOTPAGE . 'images/' );
define( 'CN_DIR_SCRIPTS', CN_ROOTPAGE . 'scripts/' );
define( 'CN_DIR_CSS', CN_ROOTPAGE . 'css/' );
define( 'CN_DIR_AJAX', CN_ROOTPAGE . 'ajax/' );
define( 'CN_DIR_CLASSES', CN_ROOTPAGE . 'classes/' );
define( 'CN_DIR_ABSTRACTS', CN_DIR_CLASSES . 'abstracts/' );
define( 'CN_DIR_INTERFACES', CN_DIR_CLASSES . 'interfaces/' );
define( 'CN_DIR_HANDLERS', CN_DIR_CLASSES . 'handlers/' );

// Web Paths
define( 'CN_WEBROOTPAGE', 'http://dev.cnerdforum.com/' );
define( 'CN_WEBLOGIN', CN_WEBROOTPAGE . 'login' );
define( 'CN_WEBLOGOUT', CN_WEBROOTPAGE . 'logout' );
define( 'CN_WEBSIGNUP', CN_WEBROOTPAGE . 'signup' );
define( 'CN_WEBMAINTENANCE', CN_WEBROOTPAGE . 'maintenance' );
define( 'CN_WEBDIR_GLOBALS', CN_WEBROOTPAGE . 'globals/' );
define( 'CN_WEBDIR_IMAGES', CN_WEBROOTPAGE . 'images/' );
define( 'CN_WEBDIR_ICONS', CN_WEBDIR_IMAGES . 'icons/' );
define( 'CN_WEBDIR_SCRIPTS', CN_WEBROOTPAGE . 'scripts/' );
define( 'CN_WEBDIR_CSS', CN_WEBROOTPAGE . 'css/' );
define( 'CN_WEBDIR_AJAX', CN_WEBROOTPAGE . 'ajax/' );

// Database Connection Settings
define( 'CN_DB_HOST', 'localhost' );
define( 'CN_DB_USER', 'www' );
define( 'CN_DB_PASS', 'a9NJBHYnWdcSZLTM' );
define( 'CN_DB_DBNAME', 'cnerd' );

// Define DB Tables
define( 'CN_USERS_TABLE', CN_DB_DBNAME . '.users' );
define( 'CN_TOPICS_TABLE', CN_DB_DBNAME . '.topics' );
define( 'CN_POSTS_TABLE', CN_DB_DBNAME . '.posts' );
define( 'CN_COMMENTS_TABLE', CN_DB_DBNAME . '.comments' );
define( 'CN_VOTES_TABLE', CN_DB_DBNAME . '.votes' );
define( 'CN_TROPHIES_TABLE', CN_DB_DBNAME . '.trophies' );
define( 'CN_ERROR_LOG_TABLE', CN_DB_DBNAME . '.error_log' );
define( 'CN_MESSAGES_TABLE', CN_DB_DBNAME . '.messages' );
define( 'CN_SESSIONS_TABLE', CN_DB_DBNAME . '.sessions' );
//define( 'CN_PREV_LOCATION_TABLE', CN_DB_DBNAME . '.previous_location' );

// Set Default Posts & Comments Per Page
define( 'CN_POSTS_PER_PAGE', 20 );
define( 'CN_COMMENTS_PER_PAGE', 20 );

// Define Allowed Tags
define( 'CN_ALLOWED_TAGS', '<p><b><strong><ul><li><br><h1><h2><h3><span><div>' );

// Define Date Format String
define( 'CN_DATE_FORMAT', 'm-d-Y, h:i A' );

// Session Settings
define( 'CN_SESSION_NAME', 'cnerdforum_id' );
define( 'CN_SESSION_KEYLENGTH_SESSID', 9 );
define( 'CN_SESSION_KEYLENGTH_LOGINID', 12 );
define( 'CN_SESSION_EXPIRE', 1800 );

// Authentication Settings
define( 'CN_AUTH_ERROR_SQL', -1 );
define( 'CN_AUTH_SUCCESS', 0 );
define( 'CN_AUTH_ERROR_INVALID', 1 );
//define( 'CN_AUTH_ERROR_LOCKED', 2 );
define( 'CN_AUTH_ERROR_NOUSER', 3 );
define( 'CN_AUTH_ERROR_UNKNOWN', 4 );

// Define login status codes
define( 'CN_LOGIN_ERROR', -1 );
define( 'CN_LOGIN_SUCCESS', 0 );

// Permission Levels (MUST be in ascending order!)
define( 'CN_PERM_USER', 1 );
define( 'CN_PERM_MOD', 2 );
define( 'CN_PERM_ADMIN', 3 );

// System Messages
define( 'CN_MSG_ERROR', -2 );
define( 'CN_MSG_WARNING', -1 );
define( 'CN_MSG_ANNOUNCEMENT', 0 );
define( 'CN_MSG_SUCCESS', 1 );

/*******************************
	Initialization & Setup
*******************************/

// Define the class and interface autoloader function
function __autoload( $class_name ) {
	// Process class name
	if ( $class_name !== 'CN' ) {
		$class_name = str_replace( 'CN_', '', strtoupper( $class_name ) );
	}
	
	if( file_exists( CN_DIR_CLASSES . 'class.' . strtolower( $class_name ) . '.php' ) ) {
		require_once CN_DIR_CLASSES . 'class.' . strtolower( $class_name ) . '.php';
/*	} elseif( file_exists( DIR_ABSTRACTS . 'abstract.' . strtolower( $class_name ) . '.php' ) ) {
		require_once DIR_ABSTRACTS . 'abstract.' . strtolower( $class_name ) . '.php';
	} elseif( file_exists( DIR_INTERFACES . 'interface.' . str_replace( 'interface', '', strtolower( $class_name ) ) . '.php' ) ) {
		require_once DIR_INTERFACES . 'interface.' . str_replace( 'interface', '', strtolower( $class_name ) ) . '.php';
	} elseif( file_exists( DIR_HANDLERS . 'handler.' . str_replace( 'handler', '', strtolower( $class_name ) ) . '.php' ) ) {
		require_once DIR_HANDLERS . 'handler.' . str_replace( 'handler', '', strtolower( $class_name ) ) . '.php';
*/	} else {
		// Should throw exception, but since we're using the singleton design pattern, the exception can't be caught
		echo $class_name;
		die( 'Could not find the required file!' );
		//throw new Exception( 'Could not find the required file!' );
	}
}

// Set the default timezone to GMT-7
date_default_timezone_set( 'America/Denver' );

$cn = $dbo = $user = null;
/*

// Begin Session
session_name( CN_SESSION_NAME );
session_start();

// Regenerate session ID (hinders session hijacking)
session_regenerate_id();

// Generate CNerdForum session ID
if ( !isset( $_SESSION['sessionID'] ) )
	$_SESSION['sessionID'] = CN::generateKey( CN_SESSION_KEYLENGTH_SESSID );
*/

/*
$cn =& CN::getInstance();
$dbo =& CN::getDBO();
$user =& User::getInstance();
*/
?>