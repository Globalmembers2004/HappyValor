<?php
// LOG
$log = '=== ' . @date('Y-m-d H:i:s') . ' ===============================' . "\n"
        . 'FILES:' . print_r($_FILES, 1) . "\n"
        . 'POST:' . print_r($_POST, 1) . "\n";
$fp = fopen('upload-log.txt', 'a');
fwrite($fp, $log);
fclose($fp);



// Result object
$r = new stdClass();
// Result content type
header('content-type: application/json');


// Maximum file size
$maxsize = 100; //Mb
// File size control
if ($_FILES['xfile']['size'] > ($maxsize * 1048576)) {
    $r->error = "Max file size: $maxsize Kb";
}


// Uploading folder
$folder = 'media/xls/';
if (!is_dir($folder))
    mkdir($folder);
// If specifics folder 
$folder .= $_POST['folder'] ? $_POST['folder'] . '/' : '';
if (!is_dir($folder))
    mkdir($folder);



$filename = $folder . $_FILES['xfile']['name'];

if(file_exists($filename)) { //Change the file permissions if allowed
    unlink($filename); //remove the file
}

move_uploaded_file($_FILES["xfile"]["tmp_name"], $filename);

$r->filename = $filename;
$r->path = $path;

// Return to JSON
echo json_encode($r);
?>