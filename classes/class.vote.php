<?php

/*************************************************
			CN_Vote Class
**************************************************
	Author: Charlie McClung
	Updated: 3/23/2013
		Class designed to track users "votes" on
		posts & comments
*************************************************/

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

/***************************************
		 Vote Table Structure
****************************************
	vote_id, int(255), PrimaryKey, AI
	user_id, int(255), FK->Users
	post_id, int(255), NULL, FK->Posts
	comment_id, int(255), NULL
	value, int(255), Default:0
***************************************/

// Define Vote Class
class CN_Vote {
	public $id;
	public $user;
	public $post;
	public $comment;
	public $value;

	// Constructor to build a new Vote Object
	public function __contsruct( $id ) {
		// TODO
	}
	
	// New vote with given $criteria
	public static function newVote( $criteria ) {
		$dbo =& CN::getDBO();

		// Define required criteria
		$required = array(
			'user_id',
			'value'
		);	
		
		// Check criteria for required items
		if ( !CN::required( $required, $criteria ) )
			throw new Exception( 'Missing required criteria to create new vote!' );
			
		// Make sure value is in valid range
		if ( ( $criteria['value'] >= CN_VOTE_DOWN ) && ( $criteria['value'] <= CN_VOTE_UP ) ) {
		
			// Make sure criteria has either 'post_id' or 'comment_id'
			if ( isset( $criteria['post_id'] ) || isset( $criteria['comment_id'] ) ) {
			
				$query = '
					INSERT	
					INTO	' . CN_TROPHIES_TABLE . ' 
					( user_id, post_id, comment_id, value ) 
					VALUES
					( :uid, :pid, :cid, :val )
				';
				
				$dbo->createQuery( $query );
				$dbo->bind( ':uid', $criteria['user_id'] );
				$dbo->bind( ':pid', $criteria['post_id'] );
				$dbo->bind( ':cid', $criteria['comment_id'] );
				$dbo->bind( ':val', $criteria['value'] );
				
				$response = $dbo->runQuery();
				
				if ( $dbo->hasError( $response ) ) {
					$dbo->submitErrorLog( $response, 'CN_Vote::newVote()' );
					throw new Exception( 'Could not create new vote!' );
				} else {
					return true;
				}
			
			// Handle unsupported voting
			} else {
				throw new Exception( 'Voting not supported without post_id or comment_id!' );
			}
			
		// Given vote $type is out of valid range
		} else {
			throw new Exception( 'Voting type out of range!' );
		}
		
		return false;
	}
	
	// Returns a specific vote
	public static function get( $id ) {
		// TODO
	}
	
	// Change current vote to upvote
	public function upVote() {
		// TODO
	}
	
	// Change current vote to downvote
	public function downVote() {
		// TODO
	}
	
	// Delete current vote
	public function delete() {
		// TODO
	}
}

?>