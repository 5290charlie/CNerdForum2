<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

// Define Comment Class
class CN_Comment {
	public $id;
	public $post;
	public $body;
	public $date;
	public $author;

	// Constructor to build new Comment Object
	public function __construct( $post, $body, $author ) {
		$this->post = $post;
		$this->body = $body;
		$this->date = time();
		$this->author = $author;
	}
	
	// Returns a specific comment
	public static function get( $id ) {
		// TODO
	}
	
	// Search all comments
	public static function search( $search ) {
		// TODO
	}
	
	// Get mana for current comment
	public function getMana() {
		// TODO
	}
	
	// Delete current comment
	public function delete() {
	}
}

?>