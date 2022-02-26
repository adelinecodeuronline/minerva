<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("location: connexion.php");
    exit; 
}

//Création d'un ticket
if(isset($_POST['send'])) {
   
    $titre = $_POST['titre'];
    $ticket = $_POST['ticket'];     
    $origine = $_POST['origine_prob'];   
    $statut = 'new';
    $loginId = $_SESSION['user_id'];           

    //File variable
    $tmpName = $_FILES['fichier']['tmp_name'];
    $name = $_FILES['fichier']['name'];           
    
    $uniqueName = uniqid('', true);
        
    $extension = pathinfo($name, PATHINFO_EXTENSION);
        
    //uniqid generation : 5f586bf96dcd38.73540086
    $unique_file = $uniqueName.".".$extension;
        
    //$unique_file = 5f586bf96dcd38.73540086.jpg
    move_uploaded_file($tmpName, './assets/uploads/'.$unique_file);
   
    $req = $db->prepare("INSERT INTO tickets (ticket_statut, ticket_titre, ticket_message, ticket_date, ticket_origineprob, ticket_fichier, user_id) VALUES ('$statut', '$titre', '$ticket', NOW(), '$origine', '$unique_file', '$loginId')");
    $req->execute();
    $id = $db->lastInsertId(); 
   
    header('Location: index.php'); 
} 



