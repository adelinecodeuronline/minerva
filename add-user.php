<?php

session_start();
require_once 'config.php';


    if(isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $name = $_POST['name'];
        $entreprise = $_POST['entreprise'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = 'user';

        if(empty($email) or empty($password)) {
            echo "<script>alert('Tous les champs sont requis')</script>";
        } else {
            $query = $db->prepare('INSERT INTO users (user_role, user_name, user_entreprise, user_email, user_password) VALUES (?, ?, ?, ?, ?)');
            $query->bindValue(1, $role);
            $query->bindValue(2, $name);
            $query->bindValue(3, $entreprise);
            $query->bindValue(4, $email);
            $query->bindValue(5, $password);

            $query->execute();

            header('Location: connexion.php');           
        }
    }
    ?>



       



