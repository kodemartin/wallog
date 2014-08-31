<?php
require_once 'config.php';
$requested_file = preg_replace('#/'.$folder.'#', "", $_SERVER['REQUEST_URI'],1);
if (file_exists($requested_file)){
    if (is_dir($requested_file)) die;
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $requested_file);
    if (pathinfo($requested_file, PATHINFO_EXTENSION) == "css" && $mime_type == "text/plain") $mime_type = "text/css";
    finfo_close($finfo);
    header('Content-Type: '.$mime_type);
    header("Content-Length: " . filesize($requested_file));
    $file = fopen($requested_file,"r");
    fpassthru($file);
    //echo file_get_contents($requested_file);
}
else require_once 'index.php';