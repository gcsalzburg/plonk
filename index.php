<?php

require_once('php/common.php');

/* ************************************************************** */
/* Load map                                                       */
/* ************************************************************** */


// Checkthe folder exists
$f = preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['f']);
if(!file_exists(PATH_TO_ROOT_DIR.'/'.$f.'-src')){
	echo "# no folder specified";
	exit();
}else{
	$folder = $f;
}



/*
// Now fetch the page content
$page_url = "map_custom/".$_SESSION['map_url']."/custom_body.html";
if(file_exists($page_url)){
	ob_start();
	include $page_url;
	$body_content = ob_get_contents();
	ob_end_clean();
}

// Now fetch the page content
$page_url = "map_custom/".$_SESSION['map_url']."/custom_head.html";
if(file_exists($page_url)){
	ob_start();
	include $page_url;
	$head_content = ob_get_contents();
	ob_end_clean();
}
*/


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