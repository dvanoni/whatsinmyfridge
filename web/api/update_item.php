<?php
	$sensor = $_POST['id'];
	$item   = $_POST['item'];
	$name	= $_POST['name'];

	$HOST = 'mysql.dvanoni.com';
	$USER = 'whatsinmyfridge';
	$PASS = 'coolfront';

	// Connecting, selecting database
	$link = mysql_connect( $HOST, $USER, $PASS ) or die('Could not connect: ' . mysql_error());
	mysql_select_db('whatsinmyfridge') or die('Could not select database');

	// Performing SQL query
	$query = "UPDATE items SET icon='$item', name='$name' WHERE sensor=$sensor";
	mysql_query($query) or die("adkfjadkfjka");
	
	// Closing connection
	mysql_close($link);	
	
	$items = array( 'sensor' => $sensor, 'unknown' => false, 'name' => $name, 'weight' => 100.2, 'icon' => $item, 'age' => '5 days old' );
	echo json_encode( $items );
?>