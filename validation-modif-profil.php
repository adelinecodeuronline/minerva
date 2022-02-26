<?php

require_once 'config.php';

$get_id=$_GET['id'];

$nom = $_POST['nom'];
$entreprise = $_POST['entreprise'];
$email = $_POST['email'];
$tmpName = $_FILES['fichier']['tmp_name'];
$name = $_FILES['fichier']['name']; 
$upload_dir='./assets/uploads/';

$uniqueName = uniqid('', true);        
$extension = pathinfo($name, PATHINFO_EXTENSION);
$unique_file = $uniqueName.".".$extension;

move_uploaded_file($tmpName, './assets/uploads/'.$unique_file);

$result = $db->prepare("UPDATE users SET user_name ='$nom', user_entreprise = '$entreprise', user_email = '$email', user_imageprofil = '$unique_file' WHERE user_id = '$get_id' ");
$result->execute();
header('Location: dashboard-compte-client.php');