<?php
    require_once("conn.php");
    include_once("ifNotLogged.php");

    //require_once("destroySession.php");

    if(isset($_GET['id']) && !empty($_GET['id'])){
        $idProfile = $_GET['id'];

        $queryProfileData = "SELECT name, mail FROM accounts WHERE id = $idProfile";
        $result = mysqli_query($conn, $queryProfileData);
        $profileData = mysqli_fetch_assoc($result);
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Profil
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
            <a href='friends.php'>
                Lista znajomych
            </a><hr>
        </header>
        <content>
            <h2>
                <?php
                    $queryAvatar = "SELECT nameAvatar FROM avatars, accounts WHERE accounts.avatar = avatars.id AND accounts.id = $idProfile";
                    $avatar = mysqli_fetch_row(mysqli_query($conn, $queryAvatar));
                    echo "
                        <img src='/back/foto/$avatar[0]' alt='avatar' class='avatar'><br>
                    ";
                    echo $profileData['name']."<br>".$profileData['mail'];

                    $queryCheckInvites = "SELECT COUNT(*), sender, recipient FROM invites WHERE (sender = $idProfile AND recipient = ".$_SESSION['userData']['id'].") OR (sender = ".$_SESSION['userData']['id']." AND recipient = $idProfile)";
                    $resultInvites = mysqli_fetch_row(mysqli_query($conn, $queryCheckInvites));
                    $queryCheckFriends = "SELECT COUNT(*) FROM friends WHERE (userSender = $idProfile AND userRecipient = ".$_SESSION['userData']['id'].") OR (userSender = ".$_SESSION['userData']['id']." AND userRecipient = $idProfile)";
                    $resultFriends = mysqli_fetch_row(mysqli_query($conn, $queryCheckFriends));
                    if($idProfile != $_SESSION['userData']['id'] && $resultInvites[0] == 0 && $resultFriends[0] == 0){
                        echo "
                        <form action='invite.php' method='POST'>
                            <input type='hidden' name='recipientID' value='$idProfile'>
                            <button type='submit'>
                                Zaproś do znajomych
                            </button>
                        </form>";
                    } else if($resultInvites[2] == $_SESSION['userData']['id']){
                        echo "
                        <p class='success'>
                            Masz zaproszenie do znajomych
                        </p>
                        <form action='accept.php' method='POST'>
                            <input type='hidden' name='recipientID' value='$idProfile'>
                            <button type='submit' class='agree invite'>
                                Przyjmij
                            </button>
                        </form>
                        <form action='discard.php' method='POST'>
                            <input type='hidden' name='recipientID' value='$idProfile'>
                            <button type='submit' class='disagree invite'>
                                Odrzuć
                            </button>
                        </form>";
                    } else if($resultInvites[2] == $idProfile){
                        echo "
                        <p class='success'>
                            Zaproszenie wysłane
                        </p>";
                    } else if($resultFriends[0] == 1){
                        echo "
                        <p class='success'>
                            Znajomy
                        </p>";
                    }
                ?><hr>
            </h2>
            <h2>
                Lista znajomych:
            </h2>
            <?php
                require_once("friendsListFunction.php");
                friendsList($idProfile);
            ?>
        </content>
    </body>
</html>