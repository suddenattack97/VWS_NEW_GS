<?php
  $img = $_POST['img'];
  $dir = "./";
  $name = date("YmdHis");
  $name = "print";
  
  $decoded = base64_decode($img);
  file_put_contents($dir."/".$name.".png", $decoded);
?>
