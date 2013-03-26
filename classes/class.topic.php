<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

/***************************************
		 Topic Table Structure
****************************************
	topic_id, int(255), PrimaryKey, AI
	user_id, int(255), FK->Users
	title, varchar(255)
	details, text
	date, int(255)
	updated, int(255), NULL
***************************************/

// Define Post Class
class CN_Topic {
	public $id;
	public $title;
	public $details;
	public $date;
	public $updated;
	public $author;
	public $posts;
	
	// Constructor to build new Post Object
	public function __construct( $id ) {
		// TODO
	}
	
	// Returns a specific post
	public static function get( $id ) {
		// TODO
	}
	
	// Returns all topics
	public static function getAll() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT	*
			FROM	' . CN_TOPICS_TABLE . ' 
			WHERE 	1
		';
		
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Topic::getAll()' );
			throw new Exception( 'Could not load all topics!' );
		}
		
		print_r( $dbo->getResultObject( $response )->fetch_object() );
	}
	
	// Search all posts
	public static function search( $search ) {
		// TODO
	}
	
	// Get mana for current post
	public function getMana() {
		// TODO
	}
	
	// Delete current post
	public function delete() {
	}
}

?>