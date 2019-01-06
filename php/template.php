<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<link rel="stylesheet" href="/assets/css/justifiedGallery.min.css">
	<link rel="stylesheet" href="/assets/css/styles.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600|Tinos:400,700" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="/assets/js/jquery.justifiedGallery.min.js"></script>

	<script>
	$(function(){
		$("#gallery").justifiedGallery({
			rowHeight : 350,
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


			$imgs = new imgs();

			$dir = new DirectoryIterator(PATH_TO_ROOT_DIR.'/shimshal-src/');
			foreach ($dir as $fileinfo) {
				if ($fileinfo->isFile()) {
					$imgs->add_file($fileinfo);
				}
			}
			foreach($imgs->get_thumbs_array() as $k => $img){
				echo '<a href="../shimshal-src/'.$img['h'].'">';
					echo '<img alt="'.$k.'" src="/shimshal-src/'.$img['t'].'"/>';
				echo '</a>';
			}

			

		?>
	</main>
</body>
</html>