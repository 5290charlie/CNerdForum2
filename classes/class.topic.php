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
	public $views;
	
	// Constructor to build new Topic Object
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
			$this->views	= $row->views;
		} else {
			throw new Exception( 'Invalid topic ID!' );
		}
	}
	
	// Returns a specific topic
	public static function get( $id ) {
		return new CN_Topic( $id );
	}
	
	// Returns all topics
	public static function getAll() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT		topic_id 
			FROM		' . CN_TOPICS_TABLE . ' 
			WHERE 		1
			ORDER BY	updated DESC
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
	
	// Search all topics
	public static function search( $search ) {
		// TODO
	}
	
	// Add new topic to database
	public static function add( $criteria ) {
		$dbo =& CN::getDBO();
		
		$required = array(
			'user_id',
			'title',
			'details'
		);
		
		if ( CN::required( $required, $criteria ) ) {
			$query = '
				INSERT 
				INTO	' . CN_TOPICS_TABLE . ' 
				( user_id, title, details, date, updated ) 
				VALUES
				( :uid, :title, :details, :date, :updated )
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':uid', $criteria['user_id'] );
			$dbo->bind( ':title', $criteria['title'] );
			$dbo->bind( ':details', $criteria['details'] );
			$dbo->bind( ':date', time() );
			$dbo->bind( ':updated', time() );
			
			$response = $dbo->runQuery();
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Topic::add()' );
				throw new Exception( 'Could not add new topic!' );
			}
			
			return true;
		} else {
			throw new Exception( 'Required topic information not provided!' );
		}
		
		return false;
	}
	
	// Get posts for current topic
	public function getPosts() {
		return CN_Post::getFromTopic( $this->id );
	}
	
	// Update the "updated" field in database for current topic
	public function touch() {
		$dbo =& CN::getDBO();
		
		$query = '
			UPDATE	' . CN_TOPICS_TABLE . ' 
			SET		updated = :updated 
			WHERE	topic_id = :tid
		';
		
		$dbo->createQuery( $query );
		$dbo->bind( ':updated', time() );
		$dbo->bind( ':tid', $this->id );
		$response = $dbo->runQuery();
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Topic::touch()' );
			throw new Exception( 'Could not update (touch()) topic!' );
		}
		
		return true;
	}
	
	// Update view count for current topic
	public function view() {
		$dbo =& CN::getDBO();
		
		$query = '
			UPDATE	' . CN_TOPICS_TABLE . ' 
			SET 	views = views+1 
			WHERE	topic_id = "' . $dbo->sqlsafe( $this->id ) . '"
		';
		
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Topic::view()' );
			throw new Exception( 'Could not update topic views' );
		}
	}
	
	// Get mana for current topic
	public function getMana() {
		// TODO
	}
	
	// Get author of current topic
	public function getAuthor() {
		return $this->author;
	}
	
	// Delete current topic
	public function delete() {
	}
}

?>