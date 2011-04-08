<?php
	$items = array();

	$item = array( 'id' => 1, 'name' => 'David', 'food' => array( 'apple', 'milk', 'beer' ) );
	array_push( $items, $item );

	$item = array( 'id' => 2, 'name' => 'Andrew', 'food' => array( 'beef', 'milk', 'brie', 'wine' ) );
	array_push( $items, $item );

	$item = array( 'id' => 3, 'name' => 'Lynn', 'food' => array( 'muffin', 'milk', 'broccoli','wine' ) );
	array_push( $items, $item );

	$item = array( 'id' => 4, 'name' => 'Leilani', 'food' => array( 'muffin', 'spam', 'broccoli','wine' ) );
	array_push( $items, $item );
	
	$item = array( 'id' => 5, 'name' => 'George Clooney', 'food' => array( 'caviar', 'muffin', 'buffalo' ) );
	array_push( $items, $item );
	
	echo json_encode( $items );
?>