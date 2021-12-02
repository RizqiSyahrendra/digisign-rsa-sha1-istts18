<?php
require_once('./Rsa.php');
session_start();

$filePrivKey = $_FILES['private_key'];

if (!$filePrivKey["name"]) {
    header("location: index.php");
    exit;
}
if (!isset($_SESSION["file_upload_content"])) {
    header("location: index.php");
    exit;
}

//hashing
$message = $_SESSION["file_upload_content"];
$sha = sha1($message);

//encrypt
$privKey = file_get_contents($filePrivKey['tmp_name']);
$signature = Rsa::encrypt($sha, $privKey);

$messageAndSignature = "$message\n\n\n<ds>$signature</ds>";

//write to file
$ext = pathinfo($_SESSION["file_upload_name"], PATHINFO_EXTENSION);
$namefile = "file_signatured_". date("YmdHis"). '.' .$ext;
$file = fopen($namefile, "w") or die("Unable to open file!");
fwrite($file, $messageAndSignature);
fclose($file);

//header download
header("Content-Disposition: attachment; filename=\"" . $namefile . "\"");
header("Content-Type: application/force-download");
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header("Content-Type: text/plain");
readfile($namefile);
unlink($namefile);