<?php
	$sensor = $_POST['id'];
	$item   = $_POST['item'];
	
	$items = array( 'sensor' => $sensor, 'unknown' => false, 'name' => $item, 'weight' => 100.2, 'icon' => $item, 'age' => '5 days old' );
	echo json_encode( $items );
?>