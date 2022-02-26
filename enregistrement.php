<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./assets/css/enregistrement-mobile.css">
    <link rel="stylesheet" href="./assets/css/enregistrement.css">

    <script src="./assets/js/enregistrement.js" defer></script>

    <title>MINERVA 🦉 | Enregistrement</title>
</head>

<body>
    <div class="container">
        <img id="logo" src="./assets/img/logo-minerva.svg" alt="logo Minerva">
        <h1>| Enregistrement</h1>
        <div class="container__background-bleu">
            <div class="container__background-bleu__haut">
                <img id="tel" src="./assets/img/tel-connection.svg" alt="">
            </div>

            <div class="container__background-bleu__bas">
                <form id="enregistrement" action="add-user.php" method="post">
                    <label>Nom</label>
                    <input type="text" name="name" id="nom" minlength="5" required>
                    <label>Entreprise</label>
                    <input type="text" name="entreprise" id="entreprise" minlength="5" required>
                    <label>Email</label>
                    <input type="email" name="email" id="email" required>                    
                    <label>Mot de passe</label>
                    <input type="password" name="password" id="pswd" minlength="5" required>
                    <button name="send">
                        <img src="./assets/img/btn.svg" alt="button">
                        <p>Enregistrer</p>
                    </button>
                </form>
            </div>
        </div>
        <a href="./connexion.php">Se connecter |</a>
    </div>
</body>
</html>