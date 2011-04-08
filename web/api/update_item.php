<?php
	$sensor = $_POST['id'];
	$item   = $_POST['item'];
	$name	= $_POST['name'];
	
	$items = array( 'sensor' => $sensor, 'unknown' => false, 'name' => $name, 'weight' => 100.2, 'icon' => $item, 'age' => '5 days old' );
	echo json_encode( $items );
?>