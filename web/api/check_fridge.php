<?php	
	$HOST = 'mysql.dvanoni.com';
	$USER = 'whatsinmyfridge';
	$PASS = 'coolfront';

	// Connecting, selecting database
	$link = mysql_connect( $HOST, $USER, $PASS ) or die('Could not connect: ' . mysql_error());

	mysql_select_db('whatsinmyfridge') or die('Could not select database');

	// Performing SQL query
	$query = 'SELECT * FROM items';
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());

	// Printing results in HTML
	$items = array();
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$item = $line;
		if( is_null( $line['name'] ) || strlen( $line['name'] ) == 0 ) {
			$item['unknown'] = true;
		} else {
			$item['unknown'] = false;
		}
		
		// Figure out age
		$age = ( time() - strtotime( $item['last_update'] ) ) / ( 60 * 60 * 24 );
		if( $age < 1 ) {
			$age = $age * 24;
			if( $age < 1 ) {
				$age = floor( $age * 60 ) . ' minutes old';
			} else { 
				$age = floor( $age ) . ' hours old';
			}
		} else {
			$age = floor( $age ) . ' days old';
		}
		
		$val = $item['val'];
		if( $val == 0 ) {
			$weight = 0;
		} else {
			$weight = floor( log( $val ) );
		}
		
		$item['weight'] = $weight;
		$item['age'] = $age;
		array_push( $items, $item );
	}

	// Free resultset
	mysql_free_result($result);

	// Closing connection
	mysql_close($link);	
	
	echo json_encode( $items );
?>
