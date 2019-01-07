<?

// 
// Access this page via e.g: https://domain.com/d/demo/DSC00895
//

//
// Gets an image to download
//
function get_image($filename,$title){
	
	// Headers and download file
	header('Pragma: public'); 	// required
	header('Expires: 0');		// no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private',false);
	// header("Content-Type: application/octet-stream"); // <-- the other way of doing it
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Description: File Transfer"); 
	header("Content-Disposition: attachment; filename=\"".$title."\"");
	header('Connection: close'); 
	readfile($filename);
	exit();
}

// Process URL params
$folder =  substr(preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['folder']),0,100);
$img = substr(preg_replace("/[^a-zA-Z0-9_\-]/","",$_GET['img']),0,200);

$request_file = '../' . $folder . '-src/' . $img . '_o.jpg';

// Request file
if(file_exists($request_file)){
    get_image($request_file,$img.'.jpg');
}else{
    exit();
}

?>