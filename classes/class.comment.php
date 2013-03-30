<?php

/*************************************************
			CN_Comment Class
**************************************************
	Author: Charlie McClung
	Updated: 3/25/2013
		Class designed to store a comment made 
		on a post
*************************************************/

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

/***************************************
		 Comment Table Structure
****************************************
	comment_id, int(255), PrimaryKey, AI
	post_id, int(255), FK->Posts
	user_id, int(255), FK->Users
	body, text
	date, int(255)
***************************************/

// Define Comment Class
class CN_Comment {
	public $id;
	public $post;
	public $body;
	public $date;
	public $author;

	// Constructor to build new Comment Object
	public function __construct( $id ) {
		$dbo =& CN::getDBO();
		
		if ( is_numeric( $id ) ) {
			$query = '
				SELECT	*
				FROM	' . CN_COMMENTS_TABLE . ' 
				WHERE	comment_id = "' . $dbo->sqlsafe( $id ) . '"
			';
			
			$response = $dbo->query( $query );
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Comment::__construct()' );
				throw new Exception( 'Could not load comment information' );
			}
			if ( $dbo->num_rows( $response ) != 1 ) {
				throw new Exception( 'The specified comment does not exist!' );
			}
			
			// Build object based on data from the database
			$row = $dbo->getResultObject( $response )->fetch_object();
			$this->id 		= $row->post_id;
			$this->post		= new CN_Post( $row->post_id );
			$this->body		= $row->body;
			$this->date		= $row->date;
			$this->author	= new CN_User( $row->user_id );
		} else {
			throw new Exception( 'Invalid comment ID!' );
		}
	}
	
	// Returns a specific comment
	public static function get( $id ) {
		return new CN_Comment( $id );
	}
	
	// Returns all posts
	public static function getAll() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT	comment_id 
			FROM	' . CN_COMMENTS_TABLE . ' 
			WHERE 	1
		';
		
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Comment::getAll()' );
			throw new Exception( 'Could not load all comments!' );
		}
		
		// Create empty array to store post objects
		$comments = array();
		
		for( $a = 0; $a < $dbo->num_rows( $response ); $a++ ) {
			$row = $dbo->getResultObject( $response )->fetch_object();
			
			$comments[$a] = new CN_Comment( $row->comment_id );
		}
		
		return $comments;
	}
	
	// Returns posts for a specific topic
	public static function getFromPost( $pid ) {
		$dbo =& CN::getDBO();
		
		if ( is_numeric( $pid ) ) {
			$query = '
				SELECT	comment_id 
				FROM	' . CN_COMMENTS_TABLE . ' 
				WHERE 	post_id = "' . $dbo->sqlsafe( $pid ) . '"
			';
			
			$response = $dbo->query( $query );
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Comment::getAll()' );
				throw new Exception( 'Could not load all comments!' );
			}
			
			// Create empty array to store comment objects
			$comments = array();
			
			for( $a = 0; $a < $dbo->num_rows( $response ); $a++ ) {
				$row = $dbo->getResultObject( $response )->fetch_object();
				
				$comments[$a] = new CN_Comment( $row->comment_id );
			}
			
			return $comments;
		} else {
			throw new Exception( 'Invalid post to comment to!' );
		}
		
		return false;
	}
	
	// Add new comment to post in database
	public static function add( $criteria ) {
		$dbo =& CN::getDBO();
		
		$required = array(
			'post_id',
			'user_id',
			'body'
		);
		
		// Check for the required criteria
		if ( CN::required( $required, $criteria ) ) {
			$query = '
				INSERT 
				INTO	' . CN_COMMENTS_TABLE . ' 
				( post_id, user_id, body, date ) 
				VALUES
				( :pid, :uid, :body, :date )
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':pid', $criteria['post_id'] );
			$dbo->bind( ':uid', $criteria['user_id'] );
			$dbo->bind( ':body', $criteria['body'] );
			$dbo->bind( ':date', time() );
			
			$response = $dbo->runQuery();
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Comment::add()' );
				throw new Exception( 'Could not add new comment!' );
			}
			
			// Update post object with touch() method
			$post = new CN_Post( $criteria['post_id'] );
			return $post->touch();
		} else {
			throw new Exception( 'Required comment information not provided!' );
		}
		
		return false;
	}
	
	// Search all comments
	public static function search( $search ) {
		// TODO
	}
	
	// Get mana for current comment
	public function getMana() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT 	SUM( value ) AS total 
			FROM	' . CN_VOTES_TABLE . ' 
			WHERE	comment_id = "' . $dbo->sqlsafe( $this->id ) . '" 
		';
		
		echo $query;
				
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Comment::getMana()' );
			throw new Exception( 'Could not get mana for current comment' );
		}
		
		$total = $dbo->field( 0, 'total', $response );
		
		echo 'Total Mana: ' . $total;
		
		if ( $total != null )
			return $total;
		else
			return '0';
	}
	
	// Delete current comment
	public function delete() {
		$dbo =& CN::getDBO();
		
		$query = '
			DELETE	
			FROM	' . CN_COMMENTS_TABLE . ' 
			WHERE	comment_id = "' . $dbo->sqlsafe( $this->id ) . '" 
		';
				
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Comment::delete()' );
			throw new Exception( 'Could not delete current comment' );
		} else {
			return true;
		}
		
		return false;
	}
}

?>