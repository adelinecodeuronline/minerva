<?php
session_start();
require_once './config.php';

if (!isset($_SESSION['user_id'])) {
    header("location: connexion.php");
    exit; 

} else {
    $get_id=$_GET['id'];    
    $req = $db->prepare("SELECT * FROM tickets WHERE ticket_id ='$get_id'");
    $req->execute();
    $user = $req->fetchAll(PDO::FETCH_ASSOC);

} 

//Commentaires entrés dans le tchat
if (isset($_POST['post'])) { 
    if (empty($_POST['post'])) {  
        echo "<script>alert('Le champs est vide');</script>";
    } else {
        //$get_id=$_GET['id'];
        $comment = $_POST['post'];
        $db->exec("INSERT INTO tickets_comments(comment_message, comment_date) VALUES('$comment', NOW())");
        $id = $db->lastInsertId(); //Récupère le dernier id inséré
        header('Location: detail-ticket.php?id=' . $db->lastInsertId());
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./admin/assets/css/detail-ticket-mobile.css">
    <link rel="stylesheet" href="./admin/assets/css/detail-ticket.css">

    <script src="./admin/assets/js/detail-ticket.js" defer></script>
    <script src="./admin/assets/js/sidebar.js" defer></script>    

    <title>MINERVA 🦉 | Tickets</title>
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
        
        <!-----liens-------->
        <ul class="sidebar__menu">
            <a href="./index.php">
                <div class="sidebar__menu__div" id="tickets">
                    <li>
                        <img class="sidebar__menu__div__icons" src="./assets/img/icone-ticket.svg" alt="Tickets">
                        <a class="sidebar__menu__div__links" href="#">Tickets</a>
                    </li>
                </div>
            </a>

            <a href="./dashboard-compte-client.php">
                <div class="sidebar__menu__div">
                    <li id="clients">
                        <img class="sidebar__menu__div__icons" src="./assets/img/icone-clients.svg" alt="Clients">
                        <a class="sidebar__menu__div__links" href="#">Clients</a>
                    </li>
                </div>
            </a>

            <a href="./dashboard-projets-admin.php">
                <div class="sidebar__menu__div">
                    <li id="projets">
                        <img class="sidebar__menu__div__icons" src="./assets/img/icone-projets.svg" alt="Projets">
                        <a class="sidebar__menu__div__links" href="#">Projets</a>
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
               

            <!--MODAL CREATION TICKET-->
           
                <div class="modal-crea-modif">
                    <img class="fermeture" src="./assets/img/fermer-modal.svg" alt="fermer">

                    <form action="validation-ticket.php" method="post" enctype="multipart/form-data">
                        <div id="main-infos">                            
                            <label>Client</label> 
                            <input type="text" name="client">
                            <label>Titre</label> 
                            <input type="text" name="titre">
                            <label>Ticket</label> 
                            <textarea name="ticket"></textarea>                            
                            <!--tags-->
                            <label>Origine problème</label>
                               <select name="origine_prob" id="prob">
                                    <option value="choix">Faites un choix</option>
                                    <option value="visuel">Visuel</option>
                                    <option value="technique">Technique</option>
                                    <option value="hébergement">Hébergement</option>
                                    <option value="mail">Mail</option>
                                    <option value="autre">Autre</option>
                                </select>                                                       
                        </div>

                           <div class="options">
                               <label>Importance</label>
                               <select name="importance" id="impt">
                                    <option value="choix importance">Choisir l'importance</option>
                                    <option value="important">Important</option>
                                    <option value="moyen">Moyen</option>
                                    <option value="faible">Faible</option>
                                </select>

                                <input id="file" type="file" name="fichier">
                                <label for="file" id="file-button">Attacher un fichier</label>
                                <div id="file-upload-filename"></div>
                           </div>

                           <div id="buttons">
                               <button id="enregistrer-btn" name="enrg-ticket">enregistrer</button>
                               <button id="supprimer-btn" formaction="suppression-ticket.php?id=<?php echo htmlspecialchars($u['id']) ?>">supprimer</button>                               
                           </div>                          
                    </form>            
                </div>

                <!--DETAIL TICKET-->
                <div class="modal-detail">               
                <?php foreach ($user as $u):  ?> 
                    <div class="modal-detail__head">                        

                        <div class="modal-detail__head__detail-importance">
                            <p>Ticket n° <span><?php echo $u['ticket_id'] ?></span></p>
                            <p>Le <span><?php echo $u['ticket_date'] ?></span></p>                            
                        </div>
                    </div>

                    <div class="modal-detail__content">
                    
                        <!--partie questions/observations du tchat-->
                        <div class="modal-detail__content__question"><!--PREMIER MESSAGE relevant du ticket-->
                            <div class="modal-detail__content__question__txt">
                                <p><?php echo $u['ticket_message'] ?></p>
                            </div>

                            <div class="modal-detail__content__question__date">
                                <p>Le-<span><?php echo $u['ticket_date'] ?></span></p>
                                <img class="modal-detail__content__question__date__cf"  src="./assets/uploads/<?php echo $u['ticket_fichier'] ?>"><!--Affichage image envoyée (pièce jointe ticket)-->
                            </div>
                        </div><!--FIN PREMIER MESSAGE-->
                        <?php endforeach; ?>
                        <!--partie réponses du tchat-->
                        <div class="modal-detail__content__answer"><!--Boucle réponse admin-->

                            <?php
                            $req = $db->query("SELECT * FROM tickets_comments INNER JOIN tickets ON tickets.ticket_id = tickets_comments.ticket_id  WHERE tickets.ticket_id ='$get_id'");
                            while($comments = $req->fetch()) {
                            ?>      

                            <div class="modal-detail__content__answer__txt">
                                <p><?php echo $comments['comment_message'] ?></p>
                            </div>

                            <div class="modal-detail__content__answer__date">
                                <p>Le-<span><?php echo $comments['comment_date'] ?></span></p>                                
                            </div>                              
                            <?php
                            }
                            ?>
                        </div>                        
                    </div>
                </div>
            </main>   
        </div>
    </div> 
</body>
</html>