<?php

$folder = "";
$folder_src = "";

// Check the folder exists
$f = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['f']);
if(!file_exists($f.'-src')){
	echo "# no folder specified";
	exit();
}else{
	$folder = $f;
	$folder_src = $folder."-src";
}



// Fetch metadata
if(!file_exists($folder_src.'/meta.json')){
	$meta['title'] = "Mystery album";
	$meta['description'] = "Add a meta.json file to set this title";
}else{
	$json = file_get_contents($folder_src.'/meta.json',true);
	$meta = json_decode($json);

	$meta['description'] = preg_replace('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
		"<a href=\"$1\" target=\"_blank\">$3</a>$4", $meta['description']);
}


// Print page
// TODO: Move to mustache template
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<title><?php echo $meta->title; ?> Gallery</title>

	<link rel="stylesheet" href="/plonk/assets/css/justifiedGallery.min.css">
	<link rel="stylesheet" href="/plonk/assets/css/swipebox.min.css">
	<link rel="stylesheet" href="/plonk/assets/css/plonk.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600|Tinos:400,700" rel="stylesheet">
</head>

<body>

	<header style="background-image:url('/<?php echo $folder_src.'/'.$meta['header']; ?>_k.jpg');">
		<?php
			echo "<h1>".$meta['title']."</h1>";
			echo "<h3>".$meta['description']."</h3>";
		?>
	</header>

	<main id="gallery" class="gallery" data-next="0" data-folder="<?php echo $folder; ?>"></main>

	<footer><a href="https://github.com/gcsalzburg/plonk">Plonk Gallery</a> © George Cave</footer> 

	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="/plonk/assets/js/jquery.justifiedGallery.min.js"></script>
	<script src="/plonk/assets/js/jquery.swipebox.min.js"></script>
	<script src="/plonk/assets/js/plonk.js"></script>
	
</body>
</html>