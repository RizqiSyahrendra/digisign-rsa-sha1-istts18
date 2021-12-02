<?php
session_start();

if (isset($_SESSION["file_upload_name"])) {
    unset($_SESSION["file_upload_name"]);
}
if (isset($_SESSION["file_upload_content"])) {
    unset($_SESSION["file_upload_content"]);
}

header("location: index.php");