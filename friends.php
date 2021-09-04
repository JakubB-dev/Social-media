<?php
    include_once("ifNotLogged.php");

    //require_once("destroySession.php");
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Strona główna
        </title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <header>
            <form action="logout.php">
                <button type="submit">
                    <h4>
                        Wyloguj się
                    </h4>
                </button>
            </form><hr>
            <h3>
                Witaj 
                <b>
                    <?php 
                        echo $_SESSION['userData']['name']."!";
                    ?>
                </b>
            </h3>
            <a href='editAccount.php'>
                Edytuj konto
            </a><hr>
            <a href=''>
                Lista znajomych
            </a><hr>
        </header>
        <content>
            <h2>
                Lista znajomych:
            </h2>
            <?php
                require_once("friendsListFunction.php");
                friendsList($_SESSION['userData']['id']);
            ?>
        </content>
    </body>
</html>