<?php
 
  function registerNewUser($form_name, $form_password, $form_email, $form_text)
  {
      
    try
    {
      $servername = 'localhost';
      $username = 'soria';
      $password = '123';
      $databasename = 'introduction';

      $con = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
      $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "INSERT INTO content(name, password, email, text) VALUE('$form_name', '$form_password', '$form_email', '$form_text')";
      $stmt = $con -> prepare($sql);
      $stmt -> execute();

      echo "New user " . $form_name . " added.";
    }

    catch(PDOException $e)
    {
      echo "Connection failed: " . $e -> getMessage();
    }
  
  }


  if(isset($_POST['send']))
  {
    $form_name = $_POST['form_name'];
    $form_password = $_POST['form_password'];
    $form_email = $_POST['form_email'];
    $form_text = $_POST['form_text'];

    echo $form_name . $form_password . $form_email . $form_text; 
    
    registerNewUser($form_name, $form_password, $form_email, $form_text);
  }

  $con = null;
?>