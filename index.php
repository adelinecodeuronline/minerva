<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("location: connexion.php");
    exit; 

} else {

    $id = $_SESSION['user_id'];
        
    $req = $db->prepare('SELECT * FROM users
    INNER JOIN tickets ON tickets.user_id = users.user_id WHERE users.user_id =?');
    $req->execute([$id]);
    $user = $req->fetchAll(PDO::FETCH_ASSOC);    

} 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./assets/css/dashboard-tickets-client-mobile.css">
    <link rel="stylesheet" href="./assets/css/dashboard-tickets-client.css">
    
    <script src="./assets/js/tickets-client.js" defer></script>
    <script src="./assets/js/sidebar.js" defer></script>
    <script src="./assets/js/footer.js" defer></script>  

    <title>Minerva | </title>
</head>

<body>
    <div id="box">
        <div class="sidebar"><!--SIDEBAR-->
        <!--menu burger-->
            <img id="burger" src="./assets/img/burger-vertical.svg" alt="Menu burger">
            <img id="burgerHoriz" src="./assets/img/burger-horizontal.svg" alt="Menu burger horizontal">
            <!--image profil-->
            <?php
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

                <form action="resultats-client.php" method="GET" name="">
                    <input id="search" type="search" name="search" placeholder="Rechercher..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                </form>               

                <div class="filtres">                    
                    <img src="./assets/img/bell-client.svg" alt="cloche notification">
                    <img id="notif-bleue" src="./assets/img/notif-client.svg" alt="notification">                   
                </div>
            </header>
            
            <main>       
               <div class="grid"><!--TABLEAU-->
                   <!--Titres généraux--->
                    <div class="grid__titre1">N°</div>
                    <div class="grid__titre2">Statut</div>
                    <div class="grid__titre2-1"></div>
                    <div class="grid__titre3">Titre</div>  
                    <div class="grid__titre4">Auteur</div>
                    <div class="grid__titre5">Date</div>                    
                    <div class="grid__titre7"></div>
                    <div class="grid__titre8"></div>
                    <!--Ligne--->
                    
                <?php foreach ($user as $u):  ?>            
                    <div class="grid__nb"><a href="detail-ticket.php?id=<?php echo htmlspecialchars($u['ticket_id']) ?>"><?php echo $u['ticket_id'] ?></a></div>       
                    <div class="grid__statut"><img class="grid__statut-img" src="./assets/img/statutouvert.svg" alt="Statut"></div>
                    <div class="grid__fleche" data-id="tab<?php echo $u['ticket_id'] ?>"><img class="grid__fleche-img" src="./assets/img/fleche.svg" alt="Dérouler"></div>
                    <div class="grid__titre tab<?php echo $u['ticket_id'] ?>"><?php echo $u['ticket_titre'] ?></div>
                    <div class="grid__auteur tab<?php echo $u['ticket_id'] ?>"><?php echo $u['user_name'] ?></div>
                    <div class="grid__date tab<?php echo $u['ticket_id'] ?>"><?php echo $u['ticket_date'] ?></div>
                    <div class="grid__emp tab<?php echo $u['ticket_id'] ?>"></div>
                    <div class="grid__modifier tab<?php echo $u['ticket_id'] ?>"><a href="modification-ticket.php?id=<?php echo htmlspecialchars($u['ticket_id']) ?>"><img class="grid__mdf-img" src="./assets/img/icone-modifier.svg" alt="Modifier"></a></div>
                    <div class="grid__supprimer tab<?php echo $u['ticket_id'] ?>"><a href="suppression-ticket.php?id=<?php echo htmlspecialchars($u['ticket_id']) ?>"><img class="grid__suppr-img" src="./assets/img/icone-supprimer.svg" alt="Supprimer"></a></div>
                <?php endforeach; ?>
                    <!--Fin Ligne--->                    
                </div>

            <!--MODAL CREATION TICKET-->
                <div class="modal-crea-modif">
                    <img class="fermeture" src="./assets/img/fermer-modal.svg" alt="fermer">

                    <form action="validation-ticket.php" method="post" enctype="multipart/form-data">
                        <div id="main-infos">                  
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
                                <input id="file" type="file" name="fichier">
                                <label for="file" id="file-button">Attacher un fichier</label>
                                <div id="file-upload-filename"></div>
                           </div>

                           <div id="buttons">
                               <button id="enregistrer-btn" name="send">enregistrer</button>
                               <button id="supprimer-btn" formaction= "suppression-ticket.php?id=<?php echo htmlspecialchars($u['ticket_id']) ?>">supprimer</button>
                           </div>                          
                    </form>
                </div>
            </main>   
        </div>
    </div> 
</body>

<footer>
    <div>
        <p id="showContact">Boisseau Informatique     |      contact@boisseau-informatique.fr     |    06 84 42 43 33 <span>Made with ♥ & Ada</span></p>
        <img id="hand" src="./assets/img/hand-client.svg" alt="hand"><!--footer mobile-->
    </div>
</footer>
</html>
