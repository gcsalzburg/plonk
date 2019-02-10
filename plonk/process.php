<?php


// Process URL params
$filename =  "../".substr(preg_replace("/[^a-zA-Z0-9_\-\/.]/","",$_GET['f']),0,100);



$response = array(
    "error" => false
);

$response['next'] = $filename;

// Request file
if(!file_exists($filename)){

    //
    $response['error'] = true;

}else{

    // Create thumbnails
    $sizes = array(
        array(
            "suffix" => "t",
            "dim" => 100,
            "q" => 80
        ),
        array(
            "suffix" => "n",
            "dim" => 320,
            "q" => 90
        ),
        array(
            "suffix" => "c",
            "dim" => 800,
            "q" => 90
        ),
        array(
            "suffix" => "h",
            "dim" => 1600,
            "q" => 90
        ),
        array(
            "suffix" => "k",
            "dim" => 2048,
            "q" => 90
        )
        );
    create_image($filename,$sizes);

    // Rename original file to have _o
    $new_name = substr($filename,0,-4)."_o.jpg";
    rename($filename, $new_name);



    // Check if there are more images left to do after this one
    $to_process = glob("../albums/lofoten/*[^_][^tnchko].jpg");
    if(sizeof($to_process) > 0){
        $response['to_process'] = true;
        $response['process_left'] = sizeof($to_process);
        $response['process_filename'] = substr($to_process[0],3);
        $response['process_filename_no_path'] = basename($to_process[0]);
    }else{
        $response['to_process'] = false;	
    }
}

echo json_encode($response);


function create_image($source,$sizes){
    
    // From the DEN project
    // Tony Smith uploaded a big image once (7000x3000pixels) that was 1.1MB as a JPEG compressed,
    // but when inflated out using imagecreatefromjpeg used more memory than there was available!
    // So lets make this nice and large to handle Tony's massive bits
    ini_set('memory_limit', '256M');

    // Save parts of source image path
    $path_parts = pathinfo($source);

    // Load image and get image size.
    $img = imagecreatefromjpeg($source);
    $width = imagesx($img);
    $height = imagesy($img);

    foreach($sizes as $s){

        // Create new filename
        $new_name = $path_parts['dirname']."/".$path_parts['filename']."_".$s['suffix'].".".$path_parts['extension'];

        // Scale to fit the required width
        if ($width > $height) {
            $newwidth = $s['dim'];
            $divisor = $width / $s['dim'];
            $newheight = floor($height/$divisor);
        }else{
            $newheight = $s['dim'];
            $divisor = $height / $s['dim'];
            $newwidth = floor($width/$divisor);
        }

        // Create a new temporary image.
        $tmpimg = imagecreatetruecolor($newwidth,$newheight);
        
        // Copy and resize old image into new image.
        imagecopyresampled($tmpimg,$img,0,0,0,0,$newwidth,$newheight,$width,$height);

        // Save thumbnail into a file.
        imagejpeg($tmpimg,$new_name,$s['q']);

        // release the memory
        imagedestroy($tmpimg);

    }
    imagedestroy($img);
}

?>