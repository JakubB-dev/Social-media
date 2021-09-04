<?php
    if(isset($_POST['recipientID'])){
        require_once("conn.php");
        session_start();
    
        $myID = $_SESSION['userData']['id'];
        $friendID = $_POST['recipientID'];
        
        $query = "INSERT INTO friends SET userSender = $friendID, userRecipient = $myID, date = current_timestamp()";
        mysqli_query($conn, $query);
        $queryDeleteInvite = "DELETE FROM invites WHERE sender = $friendID AND recipient = $myID";
        mysqli_query($conn, $queryDeleteInvite);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else{
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
?>