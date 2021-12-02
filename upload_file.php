<?php
session_start();

$fileUpload = $_FILES['file_upload'];
if (!$fileUpload["name"]) {
    header("location: index.php");
}

$fileUploadContent = file_get_contents($fileUpload['tmp_name']);
// var_dump($fileUpload);exit;
$_SESSION["file_upload_name"] = $fileUpload["name"];
$_SESSION["file_upload_content"] = $fileUploadContent;
header("location: index.php");