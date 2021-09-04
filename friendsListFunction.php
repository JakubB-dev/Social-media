<?php
    function friendsList($id){
        require_once("conn.php");
        
        // Create connection with DB if is not set
        if(!isset($conn)){
            $host = "localhost";
            $user = "root";
            $pass = "";
            $db = "back";

            $conn = mysqli_connect($host, $user, $pass, $db);
        }

        // Get the friends list
        $queryList = "SELECT accounts.id, name, nameAvatar FROM accounts, friends, avatars WHERE (userSender = $id || userRecipient = $id) AND (friends.userSender = accounts.id OR friends.userRecipient = accounts.id) AND accounts.id != $id AND accounts.avatar = avatars.id";
        $selectList = mysqli_query($conn, $queryList);
        $user = [];
        $list = [];
        $i = 0;

        while($row = mysqli_fetch_row($selectList)){
            $user['id'] = $row[0];
            $user['name'] = $row[1];
            $user['avatar'] = $row[2];
            $list[$i] = $user;
            $i++;
        }

        // Display list
        foreach($list as $user){
            echo "
            <a href='/back/profile.php?id=".$user['id']."'>
                <section class='friend'>
                    <img src='/back/foto/".$user['avatar']."' alt='avatar' class='avatar'><br>
                    ID: ".$user['id']."<br>
                    Nazwa: ".$user['name']."
                </section>
            </a>
            ";
        }
    }
?>