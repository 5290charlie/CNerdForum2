<?php
// Prevent direct access
defined( '_CN_EXEC' ) or die( 'Restricted Access' );

if( strpos( $_SERVER['REQUEST_URI'], 'post' ) !== false ) 
	print_r( $post );
elseif( strpos( $_SERVER['REQUEST_URI'], 'topics' ) !== false )
	print_r( $topics );
elseif( strpos( $_SERVER['REQUEST_URI'], '/' ) === false )
	print_r( $topic );

?>