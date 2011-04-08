<?php
  // Comma delimited
  $ingredients = $_GET['ingredients'];
  $apiUrl = 'http://www.recipepuppy.com/api/';
  $queryUrl = $apiUrl 
              . '?i=' . urlencode($ingredients)
			  . '&onlyImages=1';
  $content = file_get_contents($queryUrl);
  header('Content-type: application/json');
  header($_SERVER["Server_PROTOCOL"] . " 200 OK");

  if ($content) {
    $recipes = array();
    $obj = json_decode($content);
    echo json_encode($obj->results);
  }
?>
