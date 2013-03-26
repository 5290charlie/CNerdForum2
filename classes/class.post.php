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
	
	// Returns all posts
	public static function getAll() {
		// TODO
	}
	
	// Returns posts for a specific topic
	public static function getFromTopic( $tid ) {
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