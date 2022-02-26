<?php

session_start();
require_once 'config.php';

$userinput = $password = "";
$userinput_error = $password_error = "";

if(isset($_POST['send'])){

    $userinput = trim($_POST["userinput"]);
    $password = trim($_POST["password"]);

    if(empty($userinput_error) && empty($password_error)){

        $sql = "SELECT user_id, user_name, user_password FROM users WHERE user_name = :userinput";
        if($stmt = $db->prepare($sql)){
            $stmt->bindParam(":userinput", $param_userinput, PDO::PARAM_STR);
            $param_userinput = trim($_POST["userinput"]);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        
                        $userinput = $row["user_name"];
                        $user_ID = $row["user_id"];
                        $hashed_password = $row["user_password"];

                        if(password_verify($password, $hashed_password)){
                            session_start();

                            $_SESSION["user_id"] = $user_ID;

                            header("location: index.php");
                        } else{
                            $password_error = "Mot de passe invalide";
                        }
                    } else{
                        $userinput_error = "Compte non trouvé";
                    }
                } else{
                  $alert = "Informations incorrectes";
                  echo "<script>alert('$alert');</script>";            }
            }
            }
    
        unset($db);
    }

}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./assets/css/connection-client-mobile.css">
    <link rel="stylesheet" href="./assets/css/connection-client.css">

    <script src="./assets/js/connection.js" defer></script>

    <title>MINERVA 🦉 | Connection</title>
</head>

<body>
    <div class="container">
        <img id="logo" src="./assets/img/logo-minerva.svg" alt="logo Minerva">
        <h1>| connexion</h1>   
         
                <div class="container__background-bleu">
                
                    <div class="container__background-bleu__haut">
                        <img id="tel" src="./assets/img/tel-connection.svg" alt="">
                    </div>

                    <div class="container__background-bleu__bas">                   

                        <form name="connection" action="connexion.php" method="post">
                            <label>Nom</label>
                            <input type="text" name="userinput" value="<?php echo $userinput; ?>" id="identifiant" minlength="5" required>
                            <span><?php echo $userinput_error; ?></span>
                            <label>Mot de passe</label>
                            <input type="password" name="password" value="<?php echo $password; ?>" id="pswd" minlength="5" required>
                            <span><?php echo $password_error; ?></span>
                            <button name="send">ok</button>
                        </form>                    

                        <div id="help">
                            <img class="help-client" src="./assets/img/help-client.svg" alt="help">
                            <p>Connectez-vous</p>
                            <img class="help-client" src="./assets/img/input-client.svg" alt="connection">
                            <p>Publiez un ticket</p>
                            <img class="help-client" src="./assets/img/create-client.svg" alt="créer un ticket">
                            <p>Recevez une réponse</p>
                            <img class="help-client" src="./assets/img/dialog-client.svg" alt="réponse">
                        </div>
                    </div>
                </div>            
                     
        
        <a id="link-compte" href="./enregistrement.php">Créer un compte |</a>        
    </div>     
</body>

</html>