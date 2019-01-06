<?php

require_once('php/common.php');

/* ************************************************************** */
/* Load map                                                       */
/* ************************************************************** */

$folder = "";
$folder_src = "";


// Checkthe folder exists
$f = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['f']);
if(!file_exists(PATH_TO_ROOT_DIR.'/'.$f.'-src')){
	echo "# no folder specified";
	exit();
}else{
	$folder = $f;
	$folder_src = $folder."-src";
}



include 'php/template.php';

function custom_head(){
	global $head_content;
	echo $head_content;
}
function custom_body(){
	global $body_content;
	echo $body_content;
}

?>