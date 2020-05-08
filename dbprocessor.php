<?php

include('db.php');


//create table if not exist

$query = "SELECT id FROM updates";
$result = mysqli_query($conn, $query);
$sq0=$conn->query($query);
if($sq0 === true) {
//
}
else{
$conn->query("CREATE TABLE IF NOT EXISTS updates (
                id     INT(255) AUTO_INCREMENT PRIMARY KEY,
                cr     INT (255)        DEFAULT NULL,
                date VARCHAR (400)        DEFAULT NULL
            )");
}


$action=$_GET['action'];
$cr=mysqli_real_escape_string($conn,$_GET['cr']);
$d=mysqli_real_escape_string($conn,date("Y-m-d H:i:s"));
$dname=mysqli_real_escape_string($conn,$_GET['dname']);
$crs=mysqli_real_escape_string($conn,$_GET['crs']);
$ddate =date("jS F, Y");
switch($action){
  case 'update':
  $conn->query("INSERT INTO updates(cr,date) VALUES('".$cr."','".$d."')");
  break;
  case 'get_cr':
  $newcr=mysqli_fetch_assoc($conn->query("SELECT cr FROM updates ORDER BY id DESC LIMIT 1;"));
  $oldcr=mysqli_fetch_assoc($conn->query("SELECT cr FROM updates ORDER BY id DESC LIMIT 1,1;"));
  $total= $newcr['cr'] - $oldcr['cr'];
  $sq=$conn->query("SELECT * FROM updates ORDER BY id DESC LIMIT 2;");
  $str2 = mysqli_fetch_assoc($sq)['date']; 
  $str1 = mysqli_fetch_assoc($sq)['date']; 
  $tz1 = new DateTimeZone('Europe/Bucharest');
  $tz2 = $tz1;
  $d1 = new DateTime($str1, $tz1); 
  $d2 = new DateTime($str2, $tz2); 
  $delta_h = ($d2->getTimestamp() - $d1->getTimestamp()) / 3600;
  if ($rounded_result) {
   $delta_h = round ($delta_h);
  } else if ($truncated_result) {
   $delta_h = intval($delta_h);
  }

  echo ($total / $delta_h);
  break;
  case 'get_h':
  echo '<br><i style="font-size:12px;color:gray;">Last refresh : '.date("Y-m-d H:i:s").'</i>';
  break;
  case 'update_devices':
  $sq3=$conn->query("INSERT INTO devices(name,crs,date) VALUES('".$dname."','".$crs."','".$ddate."')");
  if($sq3 === true){
  $today =date("jS F, Y");
  $last=mysqli_fetch_assoc($conn->query("SELECT * FROM devices WHERE name = 'cata' ORDER BY id DESC LIMIT 1;"));
  $dbdate=date("jS F, Y", strtotime($last['date']));
  if($today == $dbdate){
  echo $last['crs'];  
  }
  else{

  }
  }
  break;

}

?>