<?php

date_default_timezone_set('Europe/London');

require_once('plonk/class.imgs.php');

$folder = "";
$folder_src = "";


// Checkthe folder exists
$f = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['f']);
if(!file_exists($f.'-src')){
	echo "# no folder specified";
	exit();
}else{
	$folder = $f;
	$folder_src = $folder."-src";
}



// Fetch metadata
$json = file_get_contents($folder_src.'/meta.json');
$meta = json_decode($json);


?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<title><?php echo $meta->title; ?> Gallery</title>

	<link rel="stylesheet" href="/plonk/assets/css/justifiedGallery.min.css">
	<link rel="stylesheet" href="/plonk/assets/css/styles.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600|Tinos:400,700" rel="stylesheet">
</head>

<body>
	<header style="background-image:url('/<?php echo $folder_src.'/'.$meta->header; ?>_k.jpg');">
		<?php
			echo "<h1>".$meta->title."</h1>";
			echo "<h3>".$meta->description."</h3>";
		?>
	</header>
	<main id="gallery" class="gallery">
		<?php

			$count = 0;


			$imgs = new imgs();

			$dir = new DirectoryIterator($folder_src.'/');
			foreach ($dir as $fileinfo) {
				if ($fileinfo->isFile()) {
					$imgs->add_file($fileinfo);
				}
			}
			foreach($imgs->get_thumbs_array() as $k => $img){
				echo '<a href="/'.$folder_src.'/'.$img['h'].'" class="thumb" data-folder="'.$folder.'" data-filename="'.$k.'">';
					echo '<img alt="'.$k.'" src="/'.$folder_src.'/'.$img['t'].'"/>';
				echo '</a>';
			}

			

		?>
	</main>
	
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="/plonk/assets/js/scripts.js"></script>
	<script src="/plonk/assets/js/jquery.justifiedGallery.min.js"></script>
	
</body>
</html>