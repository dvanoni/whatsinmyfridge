<?php
require_once("Thread.php");

// Test to see if threading is available
if (!Thread::available()) {
	die("ERROR: Threads not supported\n");
}

$listen_port = 8888;


echo "Starting server...\n";

// Create socket that listens for connections on $listen_port
$listen_socket = socket_create_listen($listen_port);
if ($listen_socket === false) {
	die("ERROR: unable to create listen socket\n");
}

function listenForClients($socket) {

	while (true) {
		echo "Waiting for client...\n";
		$client = @socket_accept($socket);
		if ($client === false) {
			break;
		}
		echo "Client connected.\n";
		while(true) {
			echo "Waiting to receive...\n";
			$bytes = socket_recv($client, $buf, 1024, 0);
			if ($bytes === false || $buf == null) {
				break;
			}
			echo "$buf\n";
		}
		echo "Client disconnected.\n";
	}

	echo "Listening stopped.\n";
}

$listener = new Thread("listenForClients");
$listener->start($listen_socket);


echo "\nType 'q' to quit\n\n";

$stdin = fopen("php://stdin", "r");

$input;
do {
	$input = trim(fgets($stdin));
} while ($input != "q");

fclose($stdin);

echo "Shutting down...\n";

socket_shutdown($listen_socket);
socket_close($listen_socket);

while ($listener->isAlive()) {
	sleep(1);
}

echo "Done.\n";

?>
