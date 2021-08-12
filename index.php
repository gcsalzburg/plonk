<?php

// Includes
require_once('plonk/class.mustache.php');

$template_html = "";
$template = array();

$f = "";
if(isset($_GET['f'])){
	$f = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['f']);
}

// Check the folder exists
if($f != ""){
	// Must be showing a single gallery
	$template_html = 'plonk/templates/gallery.html';

	$folder_src = 'albums/'.$f;

	if(!file_exists($folder_src)){
		$template['title'] = "Unknown folder";
	}else{
		$template['folder'] = $f;
		$template['folder_src'] = $folder_src;

		// Fetch metadata
		if(!file_exists($template['folder_src'].'/meta.json')){
			$template['title'] = "Mystery album";
			$template['description'] = "Add a meta.json file to set this title";
		}else{
			$json = file_get_contents($template['folder_src'].'/meta.json');
			$meta = json_decode($json,true);

			$template['title'] = $meta['title'];
			$template['description_no_links'] = strip_tags($meta['description']);
			$template['description'] = preg_replace('/([a-z]+\:\/\/[a-z0-9\-\.]+\.[a-z]+(:[a-z0-9]*)?\/?([a-z0-9\-\._\:\?\,\'\/\\\+&%\$#\=~])*[^\.\,\)\(\s])/i', '<a href="\1">\1</a>', $template['description_no_links']);
			$template['background_img'] = '/'.$template['folder_src'].'/'.$meta['header'].'_k.jpg';

			$template['og_url'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/'.$template['folder'];
			$template['og_img'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/'.$template['folder_src'].'/'.$meta['header'].'_c.jpg';
		}

		// Check if there are photos left to process
		// Counts as jpgs without a _tnchko suffix
		$all = glob($template['folder_src']."/*.jpg");
		$processed = glob($template['folder_src']."/*_[tnchko].jpg");
		$to_process = array_values(array_diff($all, $processed));

		if(sizeof($to_process) > 0){
			$template['to_process'] = true;
			$template['process_total'] = sizeof($to_process);
			$template['process_current'] = 1;
			$template['process_filename'] = $to_process[0];
			$template['process_filename_no_path'] = basename($to_process[0]);
		}else{
			$template['to_process'] = false;	
		}
	}
}else{
	// Display grid of all albums instead
	$template_html = 'plonk/templates/albums.html';

	$template['albums'] = array();

	$dir = new DirectoryIterator('albums');
	foreach ($dir as $fileinfo) {
		if ($fileinfo->isDir()) {
			$filename = $fileinfo->getFilename();
			$path = 'albums/'.$filename;
			// Check for meta.json
			if(file_exists($path.'/meta.json')){

				// If meta.json exists, display block for this album
				$json = file_get_contents($path.'/meta.json');
				$meta = json_decode($json,true);

				// Count photos in folder
				// We use the _t references for this purpose
				$num_photos = sizeof(glob($path."/*_t.jpg"));

				$new_album = array(
					"title" 			=> $meta['title'],
					"background" 	=> '/'.$path.'/'.$meta['header'].'_c.jpg',
					"folder"			=> $filename,
					"date_time"		=> "",
					"num_pictures_text"	=> $num_photos." photo".(($num_photos === 1) ? "" : "s"),
					"ts"				=> 0
				);

				// Get date from thumbnail of header image, for ordering purposes
				if(file_exists($path.'/'.$meta['header'].'_t.jpg')){
					$exif_date = exif_read_data($path.'/'.$meta['header'].'_t.jpg')['DateTimeOriginal'];
					$thumb_date = date_parse($exif_date);

					$new_album["date_time"] = $thumb_date['year']."/".$thumb_date['month'];
					$new_album["ts"] = strtotime($exif_date);
				}
				
				// Prepare template for this album
				$template['albums'][] = $new_album;

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