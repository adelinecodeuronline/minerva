<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("location: connexion.php");
  exit; 
}

require_once './config.php';

$getId = $_GET['id'];

if(isset($_GET['id'])) {
   
    $requete = $db->prepare("DELETE FROM tickets WHERE ticket_id=$getId"); 
    $requete->execute();
  
    header('Location: index.php');  
  }
  
?>