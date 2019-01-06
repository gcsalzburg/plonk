<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<link rel="stylesheet" href="/assets/css/justifiedGallery.min.css">
	<link rel="stylesheet" href="/assets/css/styles.css">
<!-- <link rel="stylesheet" href="/map_custom/<?php //echo $_SESSION['map_url']; ?>/styles.css"> -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600|Tinos:400,700" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="/assets/js/jquery.justifiedGallery.min.js"></script>


	<script>
	$(function(){
		$("#gallery").justifiedGallery({
			rowHeight : 350,
			lastRow : 'justify',
			margins : 3,
			captions: true,
			sizeRangeSuffixes: {
				100 : '_t',
				320 : '_n',
				800 : '_c', 
				1600 : '_h',
				2048 : '_k'
			}
		});
	});
	</script>


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
	<?php
		$json = file_get_contents(PATH_TO_ROOT_DIR.'/shimshal-src/meta.json');
		$meta = json_decode($json);
	?>
	<header style="background-image:url('/shimshal-src/<?php echo $meta->header; ?>_k.jpg');">
		<?php
			echo "<h1>".$meta->title."</h1>";
			echo "<h3>".$meta->description."</h3>";
		?>
	</header>
	<main id="gallery" class="gallery">
		<?php

			// _t = 100
			// _n = 320
			// _c = 800
			// _h = 1600
			// _k = 2048
			// _o = original

			$count = 0;

			$dir = new DirectoryIterator(PATH_TO_ROOT_DIR.'/shimshal-src/');
			foreach ($dir as $fileinfo) {
				if ($fileinfo->isFile()) {
					$fn = basename($fileinfo->getFilename(),'.'.$fileinfo->getExtension());
				//	echo strpos($fn,"_n",-2);
					if(strpos($fn,"_n",-2) > 0){
						$basename = substr($fn,0,-2);
						echo '<a href="../shimshal-src/'.$basename.'_h.jpg">';
							echo '<img alt="'.$basename.'" src="/shimshal-src/'.$basename.'_t.jpg"/>';
						echo '</a>';
						$count++;
						if($count > 50){
							break;
						}
					}
				}
			}
		?>
	<!--	<a href="path/to/image1.jpg">
			<img alt="caption for image 1" src="ppath/to/image1_thumbnail.jpg"/>
		</a>
		<a href="path/to/image2.jpg">
			<img alt="caption for image 2" src="path/to/image2_thumbnail.jpg"/>
		</a> -->
	
	</main>


	<section id="map_holder" class="map_holder">
		<div class="map_canvas" id="map_canvas"></div>
	</section>

	<?php
	custom_body();
	?>

</body>
</html>