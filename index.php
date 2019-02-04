<?php

// Includes
require_once('plonk/class.mustache.php');

$template_html = "";
$template = array();


// Check the folder exists
$f = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['f']);

if($f != ""){
	// Must be showing a single gallery
	$template_html = 'plonk/templates/gallery.html';

	if(!file_exists($f.'-src')){
		$template['title'] = "Unknown folder";
	}else{
		$template['folder'] = $f;
		$template['folder_src'] = $f."-src";

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

			// Check if there are photos left to process
			$to_process = false;
/*
			
			foreach (glob($filename."/*_t.jpg") as $tmp_f) {
				$num_photos++;
			}*/
			$template['to_process'] = true;
		}
	}
}else{
	// Display grid of all albums instead
	$template_html = 'plonk/templates/albums.html';

	$template['albums'] = array();

	$dir = new DirectoryIterator(dirname(__FILE__));
	foreach ($dir as $fileinfo) {
		if ($fileinfo->isDir()) {
			$filename = $fileinfo->getFilename();
			if( (substr($filename, -4) === "-src") && ($filename != "demo-src") ){
				// Must be a -src folder
				// Check for meta.json
				if(file_exists($filename.'/meta.json')){

					// If meta.json exists, display block for this album
					$json = file_get_contents($filename.'/meta.json');
					$meta = json_decode($json,true);

					// Count photos in folder
					// We use the _t references for this purpose
					$num_photos = sizeof(glob($filename."/*_t.jpg"));

					// Get date from thumbnail of header image, for ordering purposes
					$exif_date = exif_read_data($filename.'/'.$meta['header'].'_t.jpg')['DateTimeOriginal'];
					$thumb_date = date_parse($exif_date);
					
					// Prepare template for this album
					$template['albums'][] = array(
						"title" 			=> $meta['title'],
						"background" 		=> '/'.$filename.'/'.$meta['header'].'_c.jpg',
						"folder"			=> substr($filename,0,strlen($filename)-4),
						"date_time"			=> $thumb_date['year']."/".$thumb_date['month'],
						"num_pictures_text"	=> $num_photos." photo".(($num_photos === 1) ? "" : "s"),
						"ts"				=> strtotime($exif_date)
					);

				}
			}
		}
	}
	if(sizeof($template['albums']) > 0){
		// Neat trick from: https://stackoverflow.com/questions/2699086/
		usort($template['albums'], function($a, $b) {
			return $b['ts'] <=> $a['ts'];
		});
	}else{
		echo "No albums found";
	}
}


// Render output
$m = new Mustache_Engine;
echo $m->render(file_get_contents($template_html),$template);
?>