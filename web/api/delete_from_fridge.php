<?php
	$sensor = $_REQUEST['id'];
	
	$HOST = 'mysql.dvanoni.com';
	$USER = 'whatsinmyfridge';
	$PASS = 'coolfront';

	// Connecting, selecting database
	$link = mysql_connect( $HOST, $USER, $PASS ) or die('Could not connect: ' . mysql_error());
	mysql_select_db('whatsinmyfridge') or die('Could not select database');

	// Performing SQL query
	$query = "DELETE FROM items WHERE sensor=$sensor";
	mysql_query($query) or die("adkfjadkfjka");
	
	// Closing connection
	mysql_close($link);	
	
	$items = array( 'success' => true );
	echo json_encode( $items );
?>