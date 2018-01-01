<?php
  header("Access-Control-Allow-Origin: *");

  $host = 'localhost'; 
  $user = 'id3765123_ikra';
  $pass = 'duyaedian';
  $db = 'id3765123_regisgfd';

  $link = mysqli_connect($host, $user, $pass, $db);

  if (!$link) {
    die('Connect Error: ' . mysqli_connect_error());
  }

  //terima input data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data) && !empty($data) && ($data->nama != "") && ($data->noPes != "") && ($data->noHP != "")) {
    $nama = $data->nama;
    $noPes = $data->noPes;
    $noHP = $data->noHP;

    if ($nama == "admin" && $noPes == "reset") {
      $query = "UPDATE tabelregistran SET SUDAH = 0";
      $result = mysqli_query($link, $query) or mysql_error();
      $query = "UPDATE tabelregistran SET nohp = ''";
      $result = mysqli_query($link, $query) or mysql_error();
      echo ("RESET");
    } else {
      $noPes = substr($noPes, 2);
      $query = "SELECT * FROM tabelregistran WHERE nama = '$nama' AND noPes = '$noPes'";
      $result = mysqli_query($link, $query) or mysql_error();
      $row = mysqli_fetch_assoc($result);
      if ($row["id"] == '') {
        echo ("INVALID");
      } else if ($row["SUDAH"] == 0) {
        $query = "UPDATE tabelregistran SET SUDAH = 1 WHERE noPes = '$noPes'";
        $result = mysqli_query($link, $query) or mysql_error();
        $query = "UPDATE tabelregistran SET nohp = '$noHP' WHERE noPes = '$noPes'";
        $result = mysqli_query($link, $query) or mysql_error();
        echo ($row["nama"]);
      } else if ($row["SUDAH"] == 1){
        echo ("ALREADY");
      }
    };
  };
?>
