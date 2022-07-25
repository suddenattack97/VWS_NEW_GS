<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>
<?php
    echo "### POST ###";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "### FILE ###";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
?>
