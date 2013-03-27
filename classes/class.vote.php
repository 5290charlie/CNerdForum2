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
	public function __contsruct( $type, $value, $id ) {
		// TODO
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