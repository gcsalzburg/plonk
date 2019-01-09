<?php

require_once('plonk/class.mustache.php');

$folder = "";
$folder_src = "";

$template = array();

// Check the folder exists
$f = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['f']);
if(!file_exists($f.'-src')){
	echo "# no folder specified";
	exit();
}else{
	$template['folder'] = $f;
	$template['folder_src'] = $f."-src";
}


// Fetch metadata
if(!file_exists($template['folder_src'].'/meta.json')){
	$template['title'] = "Mystery album";
	$template['description'] = "Add a meta.json file to set this title";
}else{
	$json = file_get_contents($template['folder_src'].'/meta.json');
	$meta = json_decode($json,true);

	$template['title'] = $meta['title'];
	$template['description'] = preg_replace('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
		"<a href=\"$1\" target=\"_blank\">$3</a>$4", $meta['description']);
	$template['background_img'] = '/'.$template['folder_src'].'/'.$meta['header'].'_k.jpg';
}

$m = new Mustache_Engine;
echo $m->render(file_get_contents('plonk/templates/album.html'),$template);
?>