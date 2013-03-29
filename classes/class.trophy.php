<?php

/*************************************************
			CN_Trophy Class
**************************************************
	Author: Charlie McClung
	Updated: 3/23/2013
		Class designed to store trophy objects
		(trophies are obtained by earning mana
		when other users "vote" on another users
		posts/comments)
*************************************************/

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
	public function __construct( $id ) {
		
	}
	
	// Add new trophy
	public static function add( $criteria ) {
		$dbo =& CN::getDBO();
		
		$required = array(
			'mana',
			'rank',
			'icon'
		);
		
		// Check for required criteria
		if ( CN::required( $required, $criteria ) ) {
			$query = '
				INSERT 
				INTO 	' . CN_TROPHIES_TABLE . ' 
				( mana, rank, icon ) 
				VALUES
				( :mana, :rank, :icon )
			';
			
			$dbo->createQuery( $query );
			$dbo->bind( ':mana', $criteria['mana'] );
			$dbo->bind( ':rank', $criteria['rank'] );
			$dbo->bind( ':icon', $criteria['icon'] );
			
			$response = $dbo->runQuery();
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Trophy::add()' );
				throw new Exception( 'Could not add new trophy!' );
			} else {
				// No SQL error, trophy was added!
				return true;
			}
		}
		
		// Return false by default
		return false;
	}
	
	// Returns a specific trophy
	public static function get( $id ) {
		// TODO
	}
	
	// Returns array of all trophies
	public static function getAll() {
	
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