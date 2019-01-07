<?php

date_default_timezone_set('Europe/London');

require_once('class.imgs.php');

define("IMGS_PER_FETCH",25);


$f = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['f']);
if(!file_exists('../'.$f.'-src')){
	echo "# no folder specified";
	exit();
}else{
	$folder = $f;
	$folder_src = $folder."-src";
}

$start = preg_replace("/[^0-9]/","",$_GET['s']);

$rtn_array = array(
    "has_imgs" => false,
    "imgs" => array(),
    "next" => 0,
    "is_end" => false
);

if(is_numeric($start)){

    $imgs = new imgs();

    $dir = new DirectoryIterator('../'.$folder_src.'/');
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isFile()) {
            $imgs->add_file($fileinfo);
        }
    }

    $i = 0;
    foreach($imgs->get_thumbs_array() as $k => $img){

        if( ($i >= $start) && ($i < ($start+IMGS_PER_FETCH)) ){
            $rtn_array['imgs'][] = array(
                "filename" => $k,
                "folder" => $folder,
                "link" => '/'.$folder_src.'/'.$img['h'],
                "src" => '/'.$folder_src.'/'.$img['t'],
                "alt" => $k
            );
        }
        $i++;
    }
    $rtn_array['has_imgs'] = true;
    $rtn_array['next'] = $start+IMGS_PER_FETCH;
    
    if(($i+1) < ($start+IMGS_PER_FETCH)){
        $rtn_array['is_end'] = true;
    }
}

echo json_encode($rtn_array);



?>