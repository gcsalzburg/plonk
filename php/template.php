<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

<!--    <link rel="stylesheet" href="/map_assets/styles_common.css">
    <link rel="stylesheet" href="/map_custom/<?php //echo $_SESSION['map_url']; ?>/styles.css"> -->

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