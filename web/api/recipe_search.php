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
	 $queryUrl = $apiUrl . '?q=' . urlencode($query) . '&onlyImages=1';
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

	foreach($recipes as $recipe) {
		echo '<a class="recipeView" href="' . $recipe->href . '" target="_blank">';
		echo '<div class="titleBox" style="background-color:#FFF;clear:both;">';
		echo '<div class="picture"><img src="' . $recipe->thumbnail . '" alt="' . $recipe->title . '" width="96px" height="96px" class="portrait" align="left"/></div>';
		echo '<div class="title"><h1>' . $recipe->title . '</h1></div>';
		echo '<div class="quarterBox">';
		echo $recipe->ingredients;
		echo '</div><div style="clear:both;"></div></div>';
		echo '</a>';
		//echo '<li>' . $recipe->title . '</li>';
	}
?>

