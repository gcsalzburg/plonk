<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<link rel="stylesheet" href="/assets/js/justifiedGallery.min.css">
<!-- <link rel="stylesheet" href="/map_custom/<?php //echo $_SESSION['map_url']; ?>/styles.css"> -->

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="/assets/js/jquery.justifiedGallery.min.js"></script>



	<?php
	// Load custom head data from db
//	$head_template = file_get_contents(PATH_TO_ROOT_DIR.'/templates/head.html');
//	echo $mustache->render($head_template, $map->get_head_options());
	?>

	<?php
	custom_head();
	?>

</head>

<body>

	<section id="map_holder" class="map_holder">
		<div class="map_canvas" id="map_canvas"></div>
	</section>

	<?php
	custom_body();
	?>

</body>
</html>