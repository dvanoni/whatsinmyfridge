<?php
  // Comma delimited
  $ingredients = $_GET['ingredients'];
  $apiUrl = 'http://www.recipepuppy.com/api/';
  $queryUrl = $apiUrl 
              . '?i=' . urlencode($ingredients)
			  . '&onlyImages=1';
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
<div>
	<div class="toolbar">
		<h1>Recipe Results</h1>
		<a href="#home" class="back">Back</a>
	</div>
	<div class='s-scrollwrapper'>
		<div>
			<ul class="rounded">
			<?php
				foreach($recipes as $recipe) {
					echo '<li>' . $recipe->title . '</li>';
				}
			?>
			</ul>
		</div>
	</div>
</div>
