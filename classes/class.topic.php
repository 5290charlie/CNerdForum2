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
		$dbo =& CN::getDBO();
		
		if ( is_numeric( $id ) ) {
			$query = '
				SELECT	*
				FROM	' . CN_TOPICS_TABLE . ' 
				WHERE	topic_id = "' . $dbo->sqlsafe( $id ) . '"
			';
			
			$response = $dbo->query( $query );
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Topic::__construct()' );
				throw new Exception( 'Could not load topic information' );
			}
			if ( $dbo->num_rows( $response ) != 1 ) {
				throw new Exception( 'The specified topic does not exist!' );
			}
			
			$row = $dbo->getResultObject( $response )->fetch_object();
			$this->id 		= $row->topic_id;
			$this->title	= $row->title;
			$this->details	= $row->details;
			$this->date		= $row->date;
			$this->updated 	= $row->updated;
			$this->author	= new CN_User( $row->user_id );
			$this->posts	= CN_Post::getFromTopic( $this->id );
		} else {
			throw new Exception( 'Invalid topic ID!' );
		}
	}
	
	// Returns a specific post
	public static function get( $id ) {
		// TODO
	}
	
	// Returns all topics
	public static function getAll() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT	topic_id 
			FROM	' . CN_TOPICS_TABLE . ' 
			WHERE 	1
		';
		
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Topic::getAll()' );
			throw new Exception( 'Could not load all topics!' );
		}
		
		// Create empty array to store topic objects
		$topics = array();
		
		for( $a = 0; $a < $dbo->num_rows( $response ); $a++ ) {
			$row = $dbo->getResultObject( $response )->fetch_object();
			
			$topics[$a] = new CN_Topic( $row->topic_id );
		}
		
		return $topics;
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