<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("location: connexion.php");
    exit; 

} else {  

    $id = $_SESSION['user_id'];
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
        
    $req = $db->prepare("SELECT * FROM users
    INNER JOIN tickets ON tickets.user_id = users.user_id
    WHERE users.user_id = ? AND (ticket_titre) LIKE '%$searchQuery%'");
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
    
    <link rel="stylesheet" href="./assets/css/resultats-client-mobile.css">
    <link rel="stylesheet" href="./assets/css/resultats-client.css">

    <link rel="stylesheet" href="./assets/css/dashboard-tickets-client-mobile.css">
    <link rel="stylesheet" href="./assets/css/dashboard-tickets-client.css">

    <script src="./assets/js/sidebar.js" defer></script>    

    <title>MINERVA 🦉 | Résultats</title>
</head>

<body>
    <div id="box">
        <div class="sidebar"><!--SIDEBAR-->
        <!--menu burger-->
            <img id="burger" src="./assets/img/burger-vertical.svg" alt="Menu burger">
            <img id="burgerHoriz" src="./assets/img/burger-horizontal.svg" alt="Menu burger horizontal">
            <!--image profil-->
            <img id="profil" src="./assets/img/profil.svg" alt="Image profil">
        
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
                        <img class="sidebar__menu__div__icons" src="./assets/img/help-client.svg" alt="Faq">
                        <a class="sidebar__menu__div__links" href="#">FAQ</a>
                    </li>  
                </div> 
            </a>
        </ul>        
        </div>
        <!--FIN SIDEBAR-->

        <div id="content">
            <header>
                <form action="resultats.php" method="GET">
                    <input id="search" type="search" placeholder="Rechercher..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                </form>               
            </header>
            
            <main>       
                <div class="grid"><!--TABLEAU--><!---RESULTATS RECHERCHE---->
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
                        <div class="grid__fleche"><img class="grid__fleche-img" src="./assets/img/fleche.svg" alt="Dérouler"></div>
                        <div class="grid__titre"><?php echo $u['ticket_titre'] ?></div>
                        <div class="grid__auteur"><?php echo $u['user_name'] ?></div>
                        <div class="grid__date"><?php echo $u['ticket_date'] ?></div>
                        <div class="grid__emp"></div>
                        <div class="grid__modifier"><a href="modification-ticket.php?id=<?php echo htmlspecialchars($u['ticket_id']) ?>"><img class="grid__mdf-img" src="./assets/img/icone-modifier.svg" alt="Modifier"></a></div>
                        <div class="grid__supprimer"><a href="suppression-ticket.php?id=<?php echo htmlspecialchars($u['ticket_id']) ?>"><img class="grid__suppr-img" src="./assets/img/icone-supprimer.svg" alt="Supprimer"></a></div>
                    <?php endforeach; ?>
                        <!--Fin Ligne--->                    
                </div>       
            </main>   
        </div>
    </div> 
</body>
</html>