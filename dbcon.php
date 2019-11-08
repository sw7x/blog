<?php


$servername  = "localhost";
$username    = "root";
$password    = "";




// $servername  = "localhost";
// $username    = "susnatha_user";
// $password    = "j=Rrns)!ONgl";
// db=susnatha_unityrun

try {
    $conn = new PDO("mysql:host=$servername;dbname=travel", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
    
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}



/*
$dbcon = mysql_connect('localhost','root','') or die('Connection error :'.mysql_error());;
$db = mysql_select_db('speedee',$dbcon) or die('Database error :'.mysql_error());

*/


/*
$dbcon = mysql_connect("sql213.byethost7.com", "b7_14070714", "qwerty") or die(mysql_error());
$db = mysql_select_db("b7_14070714_speedee") or die(mysql_error());



*/



/*
$dbcon = mysql_connect("localhost", "speedeel_spduser", "86vX6zB000ss") or die(mysql_error());
$db = mysql_select_db("speedeel_speedee") or die(mysql_error());
*/


//mysql_set_charset('utf8',$dbcon);



?>