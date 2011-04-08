<?php
  $apiUrl = 'http://www.recipepuppy.com/api/';
  if (isset($_GET['ingredients'])) {
  	  // Comma delimited i hope
	  $ingredients = $_GET['ingredients'];
	  $queryUrl = $apiUrl 
				  . '?i=' . urlencode($ingredients)
				  . '&onlyImages=1';
  } else {
	 $query = $_GET['query'];
	 $queryUrl = $apiUrl . '?q=' . urlencode($query);
  }
  $content = file_get_contents($queryUrl);

  //header('Content-type: application/json');
  //header($_SERVER["Server_PROTOCOL"] . " 200 OK");

  if ($content) {
    $recipes = array();
    $obj = json_decode($content);
    //echo json_encode($obj->results);
	$recipes = $obj->results;
  }
?>
<ul class="rounded">
<?php
	foreach($recipes as $recipe) {
		echo '<li>' . $recipe->title . '</li>';
	}
?>
</ul>
