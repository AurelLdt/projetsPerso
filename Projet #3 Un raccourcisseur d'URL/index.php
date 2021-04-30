<!-- IS SENDING A FORM -->

<?php
if (isset($_POST['url'])) {

    // VARIABLE
    $url = $_POST['url'];

    // VERIFICATION
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        // PAS UN LIEN
        header('location: ./?error=true&message=Adresse url non valide');
        exit();
    }

    // SHORTCUT
    $shortcut = crypt($url, time());

    // HAS BEEN ALREADY SEND ?
    $bdd = new PDO('mysql:host=localhost;dbname=bitly;charset=utf8', 'root', '');
    $req =$bdd->prepare('SELECT COUNT (*) AS x FROM links WHERE url = ?');
    $req->execute(array($url));
    while($result = $req->fetch()) {
        if($result['x'] != 0){
            header('location: ./?error=true&message=Adresse déjà raccourcie');
            exit();
        }
    }
    
    // SENDING
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raccourcisseur d'url express</title>
    <link rel="stylesheet" type="text/css" href=".//design/default.css">
    <link rel="icon" type="image/png" href="./pictures/favico.png">
</head>

<body>
    <!-- PRESENTATION -->
    <section id="hello">
        <!-- CONTAINER -->
        <div class="container">
            <header>
                <img src="./pictures/logo.png" alt="logo" id="logo">
            </header>
            <h1>Une url longue? raccourcissez-la !</h1>
            <h2>Largement meilleur et plus court que les autres.</h2>

            <!-- FORM -->
            <form action="./" method="POST">
                <input type="url" name="url" placeholder="Coller un lien à raccourcir">
                <input type="submit" value="Raccourcir">
            </form>

            <?php
            if (isset($_GET['error']) && isset($_GET['message'])) { ?>
                <div class="center">
                    <div id="result">
                        <b><?php echo htmlspecialchars($_GET['message']); ?></b>
                    </div>
                </div>
            <?php } ?>
        </div>

    </section>

    <!-- BRANDS -->
    <section id="brands">
        <!-- CONTAINER -->
        <div class="container">
            <h3>Ces marques nous font confiance</h3>
            <img src="./pictures/1.png" alt="1" class="picture">
            <img src="./pictures/2.png" alt="2" class="picture">
            <img src="./pictures/3.png" alt="3" class="picture">
            <img src="./pictures/4.png" alt="4" class="picture">
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <img src="./pictures/logo2.png" alt="logo2" id="logo2">
        <p>2021©Bitly</p>
        <a href="">Contact</a> - <a href="">A propos</a>
    </footer>
</body>

</html>