<?php

session_start();


function createDescription($stmt)
{
  foreach ($stmt as $key => $array) {
    echo "<br>Index: $key, Namn: $array[name], Lösenord: $array[password], Email: $array[email]";
    // $array[content_id], $array[text], $array[date];
  }
}

function logIn($form_email, $form_password){
  $_SESSION["email"] = $form_email;
  $_SESSION["password"] = $form_password;
}

function startup()
{
  if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
    $servername = 'localhost';
    $username = 'soria';
    $password = '123';
    $databasename = 'introduction';
    $user_email = $_SESSION["email"];
    $user_password = $_SESSION["password"];

    $con = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM content WHERE email='$user_email';";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    return $stmt;
  }
}

function registerNewUser($form_name, $form_password, $form_email, $form_text)
{

  try {
    $servername = 'localhost';
    $username = 'soria';
    $password = '123';
    $databasename = 'introduction';

    $con = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO content(name, password, email, text) VALUE('$form_name', '$form_password', '$form_email', '$form_text')";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    echo "New user " . $form_name . " added.";
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
}
function getData()
{
  try {
    $servername = 'localhost';
    $username = 'soria';
    $password = '123';
    $databasename = 'introduction';

    $con = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM content";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    // foreach($stmt as $key => $array){
    //   echo "<br>Index: $key, Namn: $array[name], Lösenord: $array[password], Email: $array[email] || ";
    //   // $array[content_id], $array[text], $array[date];
    // }
    return $stmt;
  } catch (PDOException $E) {
    echo "Could not receive: " . $E->getMessage();
  }
}


if (isset($_POST['send'])) {
  $form_name = $_POST['form_name'];
  $form_password = $_POST['form_password'];
  $form_email = $_POST['form_email'];
  $form_text = $_POST['form_text'];

  echo $form_name . $form_password . $form_email . $form_text;

  registerNewUser($form_name, $form_password, $form_email, $form_text);
}
if (isset($_POST['login'])) {
  $form_email = $_POST['form_email'];
  $form_password = $_POST['form_password'];  

  logIn($form_email, $form_password);

  header("Location: ./index.php");
}

$con = null;
