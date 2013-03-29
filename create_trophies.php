<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Define all trophies and ranks
$trophies = array(
	// n00b rank
	array(
		'mana' => 0,
		'rank' => 'n00b',
		'icon' => CN_WEBDIR_TROPHIES . 'n00b.png'
	),
	// punk rank
	array(
		'mana' => 50,
		'rank' => 'punk',
		'icon' => CN_WEBDIR_TROPHIES . 'punk.png'
	),
	// greenhorn rank
	array(
		'mana' => 100,
		'rank' => 'greenhorn',
		'icon' => CN_WEBDIR_TROPHIES . 'greenhorn.png'
	),
	// apprentice rank
	array(
		'mana' => 200,
		'rank' => 'apprentice',
		'icon' => CN_WEBDIR_TROPHIES . 'apprentice.png'
	),
	// pro rank
	array(
		'mana' => 300,
		'rank' => 'pro',
		'icon' => CN_WEBDIR_TROPHIES . 'pro.png'
	),
	// engineer rank
	array(
		'mana' => 400,
		'rank' => 'engineer',
		'icon' => CN_WEBDIR_TROPHIES . 'engineer.png'
	),
	// master rank
	array(
		'mana' => 500,
		'rank' => 'master',
		'icon' => CN_WEBDIR_TROPHIES . 'master.png'
	),
	// elder rank
	array(
		'mana' => 600,
		'rank' => 'elder',
		'icon' => CN_WEBDIR_TROPHIES . 'elder.png'
	),
	// wiseman rank
	array(
		'mana' => 700,
		'rank' => 'wiseman',
		'icon' => CN_WEBDIR_TROPHIES . 'wiseman.png'
	),
	// prince rank
	array(
		'mana' => 800,
		'rank' => 'prince',
		'icon' => CN_WEBDIR_TROPHIES . 'prince.png'
	),
	// king rank
	array(
		'mana' => 900,
		'rank' => 'king',
		'icon' => CN_WEBDIR_TROPHIES . 'king.png'
	),
	// lord rank
	array(
		'mana' => 1000,
		'rank' => 'lord',
		'icon' => CN_WEBDIR_TROPHIES . 'lord.png'
	),
	// geek rank
	array(
		'mana' => 1500,
		'rank' => 'geek',
		'icon' => CN_WEBDIR_TROPHIES . 'geek.png'
	),
	// computer nerd rank
	array(
		'mana' => 2000,
		'rank' => 'computer nerd',
		'icon' => CN_WEBDIR_TROPHIES . 'computer nerd.png'
	),
	// genius rank
	array(
		'mana' => 2500,
		'rank' => 'genius',
		'icon' => CN_WEBDIR_TROPHIES . 'genius.png'
	),
	// evil genius rank
	array(
		'mana' => 5000,
		'rank' => 'evil genius',
		'icon' => CN_WEBDIR_TROPHIES . 'evil genius.png'
	)
);

foreach( $trophies as $trophy ) {
	if ( CN_Trophy::add( $trophy ) )
		echo 'Trophy added!';
	else
		echo 'Failed to add trophy!!!';
	
	echo "\tMana: " . $trophy['mana'] . '<br />';
	echo "\tRank: " . $trophy['rank'] . '<br />';
	echo "\tIcon: " . $trophy['icon'] . '<br />';
}
?>