<?php
    if(isset($_POST['recipientID'])){
        require_once("conn.php");
        session_start();
    
        $sender = $_SESSION['userData']['id'];
        $recipient = $_POST['recipientID'];
        
        $query = "INSERT INTO invites SET sender = $sender, recipient = $recipient";
        mysqli_query($conn, $query);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else{
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }