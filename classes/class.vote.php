<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

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