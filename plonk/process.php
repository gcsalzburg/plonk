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
    $new_name = substr($filename,0,-4)."_t.jpg";
    rename($filename, $new_name);

    $to_process = glob("../lofoten-src/*[^_][^tnchko].jpg");

    if(sizeof($to_process) > 0){
        $response['to_process'] = true;
        $response['process_left'] = sizeof($to_process);
        $response['process_filename'] = substr($to_process[0],3);
        $response['process_filename_no_path'] = basename($to_process[0]);
    }else{
        $response['to_process'] = false;	
    }

}else{
    //
    $response['error'] = true;
}

echo json_encode($response);

?>