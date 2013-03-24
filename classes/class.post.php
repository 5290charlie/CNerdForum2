<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

// Define Post Class
class CN_Post {
	public $id;
	public $title;
	public $details;
	public $date;
	public $updated;
	public $author;
	public $comments;
	
	// Constructor to build new Post Object
	public function __construct( /* constructor parameters */ ) {
		// TODO
	}
	
	// Returns a specific post
	public static function get( $id ) {
		// TODO
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