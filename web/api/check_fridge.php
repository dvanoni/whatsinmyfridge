<?php
	$items = array();
	$item = array( 'sensor' => 0, 'unknown' => false, 'name' => 'Apple ( Fuji )', 'weight' => 100.2, 'icon' => 'apple', 'age' => '5 days old' );
	array_push( $items, $item );
	$item = array( 'sensor' => 1, 'unknown' => false, 'name' => 'Pepper ( Fuji )', 'weight' => 19800.2, 'icon' => 'pepper', 'age' => '5 days old'  );
	array_push( $items, $item );
	$item = array( 'sensor' => 2, 'unknown' => false, 'name' => 'Muffin ( Fuji )', 'weight' => 109870.2, 'icon' => 'muffin', 'age' => '5 days old'  );
	array_push( $items, $item );
	$item = array( 'sensor' => 3, 'unknown' => true, 'name' => 'Apple ( Fuji )', 'weight' => 10870.2, 'icon' => 'apple', 'age' => '5 days old'  );
	array_push( $items, $item );
		
	echo json_encode( $items );
?>