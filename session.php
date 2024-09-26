<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:index.php");
    }
    require_once("config.php");
    // $user = $_SESSION["username"];

    $sql = $conn -> prepare("SELECT * FROM gestionnaires WHERE identifiant = ?");
    $sql -> bind_param("s", $_SESSION['username']);
    $sql -> execute();
    $result = $sql -> get_result();
    $row = $result -> fetch_array(MYSQLI_ASSOC);

    $user_id = $row["id"];
    
    $prof = $conn -> prepare("SELECT id_gest, picture_loc, ajoutee FROM profile_tab WHERE id_gest = ? ORDER BY ajoutee DESC");
    $prof -> bind_param("s", $user_id);
    $prof -> execute();
    $res = $prof -> get_result();
    $res = $res -> fetch_all(MYSQLI_ASSOC);

    if ($res != null && isset($res[0]["picture_loc"])) {
        $_SESSION["profpicture"] = $res[0]["picture_loc"];
    }

    // User values
    $_SESSION["name"] = $row['nom'];
    $_SESSION["username"] = $row['identifiant'];
    $_SESSION["created"] = $row["creation_date"];    

    // Articles downloads
    // $sql = "SELECT * FROM articles LIMIT 0, 4";
    // $arti = $conn -> query($sql);
    // if ($arti -> num_rows > 0) {
    //     while ($listArt = $arti -> fetch_all(MYSQLI_ASSOC)) {
    //         # code...
    //     }
    // }
    



?>