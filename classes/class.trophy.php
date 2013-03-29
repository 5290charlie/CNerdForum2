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
		$dbo =& CN::getDBO();
		
		if ( is_numeric( $id ) ) {
			$query = '
				SELECT 	* 
				FROM	' . CN_TROPHIES_TABLE . ' 
				WHERE	trophy_id = "' . $dbo->sqlsafe( $id ) . '"
			';
			
			$response = $dbo->query( $query );
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Trophy::__construct()' );
				throw new Exception( 'Could not load trophy information' );
			}
			if ( $dbo->num_rows( $response ) != 1 ) {
				throw new Exception( 'The specified trophy does not exist!' );
			}
			
			// Build object based on data from the database
			$row = $dbo->getResultObject( $response )->fetch_object();
			$this->id = $row->trophy_id;
			$this->mana = $row->mana;
			$this->rank = $row->rank;
			$this->icon = $row->icon;
		} else {
			throw new Exception( 'Invalid trophy ID!' );
		}
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
		return new CN_Trophy( $id );
	}
	
	// Returns array of all trophies
	public static function getAll() {
		$dbo =& CN::getDBO();
		
		$query = '
			SELECT 	* 
			FROM 	' . CN_TROPHIES_TABLE . ' 
			WHERE	1
		';
		
		$response = $dbo->query( $query );
		
		if ( $dbo->hasError( $response ) ) {
			$dbo->submitErrorLog( $response, 'CN_Trophy::getAll()' );
			throw new Exception( 'Could not load all trophy information' );
		}
		
		$numrows = $dbo->num_rows( $response );
		
		if ( $numrows == 0 ) {
			throw new Exception( 'No trophies exist!' );
		}
		
		// Create empty array for trophies
		$trophies = array();
		
		for ( $a = 0; $a < $numrows; $a++ ) {
			// Build object based on data from the database
			$row = $dbo->getResultObject( $response )->fetch_object();
			
			$trophies[$a] = new CN_Trophy( $row->trophy_id );
		}
		
		return $trophies;
	}
	
	// Returns all trophies earned with given mana
	public static function getTrophies( $mana ) {
		$dbo =& CN::getDBO();
		
		if ( is_numeric( $mana ) ) {
			$query = '
				SELECT 	* 
				FROM 	' . CN_TROPHIES_TABLE . ' 
				WHERE	mana <= "' . $dbo->sqlsafe( $mana ) . '" 
			';
			
			$response = $dbo->query( $query );
			
			if ( $dbo->hasError( $response ) ) {
				$dbo->submitErrorLog( $response, 'CN_Trophy::getTrophies($mana)' );
				throw new Exception( 'Could not load trophy information' );
			}
			
			$numrows = $dbo->num_rows( $response );
			
			if ( $numrows == 0 ) {
				throw new Exception( 'No trophies exist for given mana range!' );
			}
			
			// Create empty array for trophies
			$trophies = array();
			
			for ( $a = 0; $a < $numrows; $a++ ) {
				// Build object based on data from the database
				$row = $dbo->getResultObject( $response )->fetch_object();
				$trophies[$a] = new CN_Trophy( $row->trophy_id );
			}
			
			return $trophies;
		} else {
			throw new Exception( 'No-numeric mana value' );
		}
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