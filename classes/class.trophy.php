<?php

// Prevent Direct Access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

/***************************************
		 Trophy Table Structure
****************************************
	trophy_id, int(255), PrimaryKey, AI
	mana, int(255)
	rank, varchar(255)
	icon, varchar(255)
***************************************/

// Define Trophy Class
class CN_Trophy {
	public $id;
	public $mana;
	public $rank;
	public $icon;
	
	// Constructor to build a new Trophy Object
	public function __construct( $mana, $rank, $icon ) {
		$this->mana = $mana;
		$this->rank = $rank;
		$this->icon = $icon;
	}
	
	// Returns a specific trophy
	public static function get( $id ) {
		// TODO
	}
	
	// Returns all trophies earned with given mana
	public static function getTrophies( $mana ) {
		// TODO
	}
	
	// Returns rank earned with given mana
	public static function getRank( $mana ) {
		// TODO
	}
	
	// Deletes current trophy
	public function delete() {
		// TODO
	}
}

?>