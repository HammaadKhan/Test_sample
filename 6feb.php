<?php
define("WEB_TITLE","Stanetplace");
define("WEB_URL","https://grow.standar.com/");
define("WEB_EMAIL","support@st.com");
$web_name = WEB_TITLE;
$web_url = WEB_URL;
$web_email = WEB_EMAIL;

function dbConnect(){
  $servername = "localhost";
  $username = "u996835ardnft"; // DATABASE USERNAME
  $password = "ek"; //DATABASE PASSWORD
  $database = "u9968pndardnft"; //DATABASE NAME
  $dns = "mysql:host=$servername;dbname=$database";


  // Do not edit the line below
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO:: ATTR_EMULATE_PREPARES => false,
];


  try {
      $conn = new PDO($dns, $username, $password, $options);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
  } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
  }
}
//return dbConnect();

function inputValidation($value): string
{
  return trim(htmlspecialchars(htmlentities($value)));
}