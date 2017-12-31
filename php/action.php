<?php
  header("Access-Control-Allow-Origin: *");

  $host = 'localhost'; //127.0.0.1
  $user = 'id3765123_ikra';
  $pass = 'duyaedian';
  $db = 'id3765123_regisgfd';

  $link = mysqli_connect($host, $user, $pass, $db);

  //terima input data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data) && !empty($data) && ($data->nama != "") && ($data->noPes != "") && ($data->noHP != "")) {
    $nama = $data->nama;
    $noPes = $data->noPes;
    $noHP = $data->noHP;

    if ($nama == "admin" && $noPes == "reset") {
      $query = "UPDATE tabelpeserta SET SUDAH = 0";
      $result = mysqli_query($link, $query) or die('reset gagal');
      $query = "UPDATE tabelpeserta SET nohp = ''";
      $result = mysqli_query($link, $query) or die('reset gagal');
      echo ("RESET");
    } else {
      $noPes = substr($noPes, 2);
      $query = "SELECT * FROM tabelpeserta WHERE nama = '$nama' AND noPes = '$noPes'";
      $result = mysqli_query($link, $query) or die('select query gagal');
      // echo($result);
      $row = mysqli_fetch_assoc($result);
      if ($row["id"] == '') {
        echo ("INVALID");
      } else if ($row["SUDAH"] == 0) {
        $query = "UPDATE tabelpeserta SET SUDAH = 1 WHERE noPes = '$noPes'";
        $result = mysqli_query($link, $query) or die('update query gagal');
        $query = "UPDATE tabelpeserta SET nohp = '$noHP' WHERE noPes = '$noPes'";
        $result = mysqli_query($link, $query) or die('update query gagal');
        echo ($row["nama"]);
      } else if ($row["SUDAH"] == 1){
        echo ("ALREADY");
      }
    };
  };
?>
