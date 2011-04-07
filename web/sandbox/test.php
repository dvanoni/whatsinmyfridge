<?php
/*
  // yql example
  $yqlUrl = 'http://query.yahooapis.com/v1/public/yql';
  $query = 'select * from flickr.photos.search where text="Cat"';
  $queryUrl = $yqlUrl 
              . '?q=' . urlencode($query) 
              . '&format=json';
  $content = file_get_contents($queryUrl);
  $yqlObject = json_decode($content);
  print_r($yqlObject);
*/

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
//    foreach($obj->results as $recipe) {
//      $recipes[] = $recipe;
//    }
    echo json_encode($obj->results);
  }
//  $resultsObj = json_decode($content);
//  print_r($resultsObj);
?>
