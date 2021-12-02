<?php
$type = $_POST['type'];
$privateKey = $_POST['private_key'];
$publicKey = $_POST['public_key'];

$namefile = "key_". date("Ymd");
$content = $type == "public" ? $publicKey : $privateKey;

if ($type == "public") {
    $namefile .= ".pub";
}
else {
    $namefile .= ".pri";
}

//save file
$file = fopen($namefile, "w") or die("Unable to open file!");
fwrite($file, $content);
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
