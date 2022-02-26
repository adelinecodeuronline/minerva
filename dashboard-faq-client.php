<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("location: connexion.php");
    exit; 
}

$id = $_SESSION['user_id'];

$req = $db->prepare("SELECT * FROM users where user_id= ?");
$req->execute([$id]);
$userp = $req->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./assets/css/dashboard-faq-client-mobile.css">
    <link rel="stylesheet" href="./assets/css/dashboard-faq-client.css">

    <script src="./assets/js/faq-client.js" defer></script>   
    <script src="./assets/js/sidebar.js" defer></script> 
    <script src="./assets/js/footer.js" defer></script>   

    <title>MINERVA 🦉 | Compte</title>
</head>

<body>
    <div id="box">
        <div class="sidebar"><!--SIDEBAR-->
        <!--menu burger-->
            <img id="burger" src="./assets/img/burger-vertical.svg" alt="Menu burger">
            <img id="burgerHoriz" src="./assets/img/burger-horizontal.svg" alt="Menu burger horizontal">
            <!--image profil-->        

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
                <div class="sidebar__menu__div" id="compte">
                    <li>
                        <img class="sidebar__menu__div__icons" src="./assets/img/compte-client.svg" alt="Compte">
                        <a class="sidebar__menu__div__links" href="#">Compte</a>
                    </li>
                </div>
            </a>

            <a href="#">
                <div class="sidebar__menu__div" id="faq">
                    <li>
                        <img class="sidebar__menu__div__icons" src="./assets/img/help-client.svg" alt="Faq">
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
                <div class="filtres">
                    <img src="./assets/img/bell-client.svg" alt="cloche notification">
                    <img id="notif-bleue" src="./assets/img/notif-client.svg" alt="notification">                   
                </div>             
            </header>
            
            <main>     
                <!--Partie FAQ-->
                <div class="faq-menu">
                    <button class="faq-menu__accordeon">Comment créer un ticket +</button>
                    <div class="faq-menu__panel">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>

                    <button class="faq-menu__accordeon">A quoi sert un ticket  +</button>
                    <div class="faq-menu__panel">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>

                    <button class="faq-menu__accordeon">Quel est le temps de réponse +</button>
                    <div class="faq-menu__panel">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
                            
                <!--MODAL CREATION/MODIFICATION TICKET-->
                <div class="modal-crea-modif">
                    <img class="fermeture" src="./assets/img/fermer-modal.svg" alt="fermer">
                    
                    <form action="validation-ticket.php" method="post" enctype="multipart/form-data">
                        <div id="main-infos">                  
                            <label>Titre</label> 
                            <input type="text" name="titre">
                            <label>Ticket</label> 
                            <textarea name="ticket"></textarea>                       
                        </div>

                           <div class="options">                           
                                <input id="file2" type="file" name="fichier2">
                                <label for="file2" id="file-button2">Attacher un fichier</label>
                                <div id="file-upload-filename2"></div>
                           </div>

                           <div id="buttons2">
                               <button id="enregistrer-btn">enregistrer</button>
                               <button id="supprimer-btn">supprimer</button>
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