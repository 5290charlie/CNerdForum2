<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

/***************************************
		 Post Table Structure
****************************************
	post_id, int(255), PrimaryKey, AI
	topic_id, int(255), FK->Topics
	user_id, int(255), FK->Users
	title, varchar(255)
	details, text
	date, int(255)
	updated, int(255), NULL
	
***************************************/

// Define Post Class
class CN_Post {
	public $id;
	public $topic;
	public $title;
	public $details;
	public $date;
	public $updated;
	public $author;
	
	// Constructor to build new Post Object
	public function __construct( $id ) {
		$dbo =& CN::getDBO();
		
		if ( is_numeric( $id ) ) {
			$query = '
				SELECT	*
				FROM	' . CN_POSTS_TABLE . ' 
				WHERE	post_id = "' . $dbo->sqlsafe( $id ) . '"
			';
			
			$response = $dbo->query( $query );
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Post::__construct()' );
				throw new Exception( 'Could not load post information' );
			}
			if ( $dbo->num_rows( $response ) != 1 ) {
				throw new Exception( 'The specified post does not exist!' );
			}
			
			$row = $dbo->getResultObject( $response )->fetch_object();
			$this->id 		= $row->post_id;
			$this->topic	= new CN_Topic( $row->topic_id );
			$this->title	= $row->title;
			$this->details	= $row->details;
			$this->date		= $row->date;
			$this->updated 	= $row->updated;
			$this->author	= new CN_User( $row->user_id );
		} else {
			throw new Exception( 'Invalid post ID!' );
		}
	}
	
	// Returns a specific post
	public static function get( $id ) {
		return new CN_Post( $id );
	}
	
	// Returns all posts
	public static function getAll() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT	post_id 
			FROM	' . CN_POSTS_TABLE . ' 
			WHERE 	1
		';
		
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Post::getAll()' );
			throw new Exception( 'Could not load all posts!' );
		}
		
		// Create empty array to store post objects
		$posts = array();
		
		for( $a = 0; $a < $dbo->num_rows( $response ); $a++ ) {
			$row = $dbo->getResultObject( $response )->fetch_object();
			
			$posts[$a] = new CN_Post( $row->post_id );
		}
		
		return $posts;
	}
	
	// Returns posts for a specific topic
	public static function getFromTopic( $tid ) {
		$dbo =& CN::getDBO();
		
		if ( is_numeric( $tid ) ) {
			$query = '
				SELECT	post_id 
				FROM	' . CN_POSTS_TABLE . ' 
				WHERE 	topic_id = "' . $dbo->sqlsafe( $tid ) . '"
			';
			
			$response = $dbo->query( $query );
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Post::getAll()' );
				throw new Exception( 'Could not load all posts!' );
			}
			
			// Create empty array to store post objects
			$posts = array();
			
			for( $a = 0; $a < $dbo->num_rows( $response ); $a++ ) {
				$row = $dbo->getResultObject( $response )->fetch_object();
				
				$posts[$a] = new CN_Post( $row->post_id );
			}
			
			return $posts;
		} else {
			throw new Exception( 'Invalid topic post to!' );
		}
		
		return false;
	}
	
	// Search all posts
	public static function search( $search ) {
		// TODO
	}
	
	// Add new post to database
	public static function add( $criteria ) {
		$dbo =& CN::getDBO();
		
		$required = array(
			'topic_id',
			'user_id',
			'title',
			'details'
		);
		
		if ( CN::required( $required, $criteria ) ) {
			$query = '
				INSERT 
				INTO	' . CN_POSTS_TABLE . ' 
				( topic_id, user_id, title, details, date, updated ) 
				VALUES
				( :tid, :uid, :title, :details, :date, :updated )
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':tid', $criteria['topic_id'] );
			$dbo->bind( ':uid', $criteria['user_id'] );
			$dbo->bind( ':title', $criteria['title'] );
			$dbo->bind( ':details', $criteria['details'] );
			$dbo->bind( ':date', time() );
			$dbo->bind( ':updated', time() );
			
			$response = $dbo->runQuery();
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Post::add()' );
				throw new Exception( 'Could not add new post!' );
			}
			
			// Update topic object with touch() method
			$topic = new CN_Topic( $criteria['topic_id'] );
			return $topic->touch();
		} else {
			throw new Exception( 'Required post information not provided!' );
		}
		
		return false;
	}
	
	// Get comments for current post
	public function getComments() {
		return CN_Comment::getFromPost( $this->id );
	}
	
	// Update the "updated" field in database for current post
	public function touch() {
		$dbo =& CN::getDBO();
		
		$query = '
			UPDATE	' . CN_POSTS_TABLE . ' 
			SET		updated = :updated 
			WHERE	post_id = :pid
		';
		
		$dbo->createQuery( $query );
		$dbo->bind( ':updated', time() );
		$dbo->bind( ':pid', $this->id );
		$response = $dbo->runQuery();
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Post::touch()' );
			throw new Exception( 'Could not update (touch()) post!' );
		}
		
		return $this->topic->touch();
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