<?php


// Process URL params
$filename =  "../".substr(preg_replace("/[^a-zA-Z0-9_\-\/.]/","",$_GET['f']),0,100);


$response = array(
    "error" => false
);

$response['next'] = $filename;

// Request file
if(file_exists($filename)){

    // Process image

}else{
    //
    $response['error'] = true;
}

echo json_encode($response);

?>