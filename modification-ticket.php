<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("location: connexion.php");
    exit; 
}

$ID=$_GET['id'];

$req = $db->prepare("SELECT * FROM tickets where ticket_id='$ID'");
$req->execute();
$user = $req->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./assets/css/dash-modif-tickets-admin-mobile.css">
    <link rel="stylesheet" href="./assets/css/dash-modif-tickets-admin.css">

    <link rel="stylesheet" href="./assets/css/dashboard-tickets-client-mobile.css">
    <link rel="stylesheet" href="./assets/css/dashboard-tickets-client.css">

    <script src="./assets/js/modification-tickets.js" defer></script>
    <script src="./assets/js/sidebar.js" defer></script>

    <title>MINERVA 🦉 | Modification Ticket</title>
</head>

<body>
    <div id="box">
        <div class="sidebar"><!--SIDEBAR-->
        <!--menu burger-->
            <img id="burger" src="./assets/img/burger-vertical.svg" alt="Menu burger">
            <img id="burgerHoriz" src="./assets/img/burger-horizontal.svg" alt="Menu burger horizontal">
            <!--image profil-->
            <?php    
            $id = $_SESSION['user_id'];        
            $req = $db->prepare("SELECT * FROM users
             WHERE users.user_id = '$id'");
            $req->execute();
            $userp = $req->fetchAll(PDO::FETCH_ASSOC);            
            ?>

            <?php foreach ($userp as $up):  ?>
            <img id="profil" src="./assets/uploads/<?php echo $up['user_imageprofil']; ?>" alt="Image profil">
            <?php endforeach; ?>
        
            <ul class="sidebar__menu">
            <a href="#">
                <div class="sidebar__menu__div" id="tickets">
                    <li>
                        <img class="sidebar__menu__div__icons" src="./assets/img/icone-ticket.svg" alt="Tickets">
                        <a class="sidebar__menu__div__links" href="#">Tickets</a>
                    </li>
                </div>
            </a>

            <a href="./dashboard-compte-client.php">
                <div class="sidebar__menu__div">
                    <li id="compte">
                        <img class="sidebar__menu__div__icons" src="./assets/img/compte-client.svg" alt="Compte">
                        <a class="sidebar__menu__div__links" href="#">Compte</a>
                    </li>
                </div>
            </a>

            <a href="./dashboard-faq-client.php">
                <div class="sidebar__menu__div">
                    <li id="faq">
                        <img class="sidebar__menu__div__icons" src="./assets/img/help-client.svg" alt="FAQ">
                        <a class="sidebar__menu__div__links" href="#">FAQ</a>
                    </li>  
                </div> 
            </a>
        </ul> 
        
        <a class="sidebar__btn-side" href="#">+</a>
        </div>
        <!--FIN SIDEBAR-->

        <div id="content">
            <header>
                <a href="./logout.php" class="logout"><img src="./assets/img/log-out.svg" alt="logout"></a>
                <form action="resultats.php" method="GET">
                    <input id="search" type="search" placeholder="Rechercher...">
                </form>               
            </header>
            
            <main>               
            <!--MODAL MODIFICATION TICKET-->               
                <div class="modal-modif">

                <?php foreach ($user as $u):  ?>
                   
                    <form action="validation-modif-ticket.php<?php echo '?id='.$u['ticket_id']; ?>" method="post" enctype="multipart/form-data">
                        <div id="main-infos">                     
                          
                            <label>Titre</label> 
                            <input type="text" name="titre" value="<?php echo $u['ticket_titre'] ?>">
                            <label>Ticket</label> 
                            <textarea name="ticket"><?php echo $u['ticket_message'] ?></textarea>                            
                            <!--tags-->
                            <label>Origine problème</label>
                               <select name="origine_prob" id="prob">
                                    <option value="<?php echo $u['ticket_origineprob']; ?>"><?php echo $u['ticket_origineprob']; ?></option>
                                    <option value="visuel">Visuel</option>
                                    <option value="technique">Technique</option>
                                    <option value="hébergement">Hébergement</option>
                                    <option value="mail">Mail</option>
                                    <option value="autre">Autre</option>
                                </select>                                                       
                        </div>

                           <div class="options">                              

                                <input id="file" type="file" name="fichier" value="<?php echo $u['ticket_fichier']; ?>">
                                <label for="file" id="file-button">Attacher un fichier</label>
                                <div id="file-upload-filename"><?php echo $u['ticket_fichier']; ?></div>
                           </div>

                           <div id="buttons">
                               <button id="enregistrer-btn" name="enrg-ticket">actualiser</button>
                               <button id="supprimer-btn" formaction="suppression-ticket.php?id=<?php echo htmlspecialchars($u['ticket_id']) ?>">supprimer</button>                               
                           </div>                          
                    </form>  
                 <?php endforeach; ?>    
                           
                </div>
            </main>   
        </div>
    </div> 
</body>
</html>