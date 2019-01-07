<?php

date_default_timezone_set('Europe/London');

require_once('class.imgs.php');

define("IMGS_PER_FETCH",25);

// Skeleton for JSON return
$rtn_array = array(
    "has_imgs" => false,
    "imgs" => array(),
    "next" => 0,
    "is_end" => false
);

// Request variables
$folder = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['folder']);
$start = preg_replace("/[^0-9]/","",$_GET['start']);

$folder_src = $folder."-src";

// Check if folder and start are valid
// Exit early if not
if(!file_exists('../'.$folder_src)){
    echo json_encode($rtn_array);
	exit();
}
if(!is_numeric($start)){
    echo json_encode($rtn_array);
	exit();
}

// Create new img object
$imgs = new imgs();

// Iterate over directory of images
$dir = new DirectoryIterator('../'.$folder_src.'/');
foreach ($dir as $fileinfo) {
    if ($fileinfo->isFile()) {
        $imgs->add_file($fileinfo);
    }
}

// Loop over array and pull data for images that we need this time
$i = 0;
$has_imgs = false;
foreach($imgs->get_thumbs_array() as $k => $img){

    if( ($i >= $start) && ($i < ($start+IMGS_PER_FETCH)) ){
        $rtn_array['imgs'][] = array(
            "filename" => $k,
            "folder" => $folder,
            "link" => '/'.$folder_src.'/'.$img['h'],
            "src" => '/'.$folder_src.'/'.$img['t'],
            "alt" => $k
        );
        $has_imgs = true;
    }
    $i++;
}
$rtn_array['has_imgs'] = $has_imgs;

// Check if we are at the end or not
if(($i+1) < ($start+IMGS_PER_FETCH)){
    $rtn_array['is_end'] = true;
    $rtn_array['next'] = $i;
}else{
    $rtn_array['next'] = $start+IMGS_PER_FETCH;

}

// Finish
echo json_encode($rtn_array);

?>