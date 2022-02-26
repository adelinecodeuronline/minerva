<?php

require_once 'config.php';

//Modification d'un ticket

$get_id=$_GET['id'];
$titre= $_POST['titre'];
$ticket= $_POST['ticket'];
$importance = $_POST['importance'];
$origine = $_POST['origine_prob'];

$tmpName = $_FILES['fichier']['tmp_name'];
$name = $_FILES['fichier']['name'];
$upload_dir='./assets/uploads/';

$uniqueName = uniqid('', true);        
$extension = pathinfo($name, PATHINFO_EXTENSION);
$unique_file = $uniqueName.".".$extension;
move_uploaded_file($tmpName, './assets/upload/'.$unique_file);

$result = $db->prepare("UPDATE tickets SET ticket_titre ='$titre', ticket_message = '$ticket', ticket_origineprob = '$origineprob', ticket_fichier = '$unique_file' WHERE ticket_id = '$get_id' ");
$result->execute();
header("location: index.php");