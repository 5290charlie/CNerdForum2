<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

$cn =& CN::getInstance();
$cn->init();

/*
// Define all trophies and ranks
$trophies = array(
	// n00b rank
	array(
		'mana' => 0,
		'rank' => 'n00b',
		'icon' => 'n00b.png'
	),
	// punk rank
	array(
		'mana' => 50,
		'rank' => 'punk',
		'icon' => 'punk.png'
	),
	// greenhorn rank
	array(
		'mana' => 100,
		'rank' => 'greenhorn',
		'icon' => 'greenhorn.png'
	),
	// apprentice rank
	array(
		'mana' => 200,
		'rank' => 'apprentice',
		'icon' => 'apprentice.png'
	),
	// pro rank
	array(
		'mana' => 300,
		'rank' => 'pro',
		'icon' => 'pro.png'
	),
	// engineer rank
	array(
		'mana' => 400,
		'rank' => 'engineer',
		'icon' => 'engineer.png'
	),
	// master rank
	array(
		'mana' => 500,
		'rank' => 'master',
		'icon' => 'master.png'
	),
	// elder rank
	array(
		'mana' => 600,
		'rank' => 'elder',
		'icon' => 'elder.png'
	),
	// wiseman rank
	array(
		'mana' => 700,
		'rank' => 'wiseman',
		'icon' => 'wiseman.png'
	),
	// prince rank
	array(
		'mana' => 800,
		'rank' => 'prince',
		'icon' => 'prince.png'
	),
	// king rank
	array(
		'mana' => 900,
		'rank' => 'king',
		'icon' => 'king.png'
	),
	// lord rank
	array(
		'mana' => 1000,
		'rank' => 'lord',
		'icon' => 'lord.png'
	),
	// geek rank
	array(
		'mana' => 1500,
		'rank' => 'geek',
		'icon' => 'geek.png'
	),
	// computer nerd rank
	array(
		'mana' => 2000,
		'rank' => 'computer nerd',
		'icon' => 'computer nerd.png'
	),
	// genius rank
	array(
		'mana' => 2500,
		'rank' => 'genius',
		'icon' => 'genius.png'
	),
	// evil genius rank
	array(
		'mana' => 5000,
		'rank' => 'evil genius',
		'icon' => 'evil genius.png'
	)
);

foreach( $trophies as $trophy ) {
	if ( CN_Trophy::add( $trophy ) )
		echo 'Trophy added!';
	else
		echo 'Failed to add trophy!!!';	
	echo 'Mana: ' . $trophy['mana'] . '<br />';
	echo 'Rank: ' . $trophy['rank'] . '<br />';
	echo 'Icon: <img src="' . $trophy['icon'] . '" /><br />';
}
*/
$mana = 1234;

$trophies = CN_Trophy::getTrophies( $mana );
echo 'Getting trophies for mana: ' . $mana . '<br />';

foreach( $trophies as $trophy ) {
	echo 'Mana: ' . $trophy->mana . '<br />';
	echo 'Rank: ' . $trophy->rank . '<br />';
	echo 'Icon: <img src="' . $trophy->icon . '" /><br /><br />';
}
?>