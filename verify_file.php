<?php
require_once('./Rsa.php');
session_start();

$filePublicKey = $_FILES['public_key'];

if (!$filePublicKey["name"]) {
    header("location: index.php");
    exit;
}
if (!isset($_SESSION["file_upload_content"])) {
    header("location: index.php");
    exit;
}

$publicKey = file_get_contents($filePublicKey['tmp_name']);
$plainTeks = $_SESSION["file_upload_content"];

//get signature
$startSignaturePos = strpos($plainTeks, "<ds>");
$endSignaturePos = strpos($plainTeks, "</ds>");
$signature = substr($plainTeks, $startSignaturePos, ($endSignaturePos-$startSignaturePos));

//decrypt signature
$sha = Rsa::decrypt($signature, $publicKey);

//get message
$endMessagePos = strpos($plainTeks, "\n\n\n<ds>");
$message = substr($plainTeks, 0, $endMessagePos);
$shaB = sha1($message);

//verify
// var_dump($sha, $shaB);exit;
if (substr($sha, 1, strlen($sha)-1) == substr($shaB, 1, strlen($shaB)-1)) {
    $_SESSION["alert_msg"] = "Pesan file masih original dari pengirim asli";
}
else {
    $_SESSION["alert_msg"] = "Pesan file tidak valid atau sudah pernah diubah";
}

header("location: index.php");