<?php


// Process URL params
$filename =  substr(preg_replace("/[^a-zA-Z0-9_\-\/]/","",$_GET['filename']),0,100);

// Request file
if(file_exists($filename)){

    // Process image

}else{
    exit();
}

?>