<?php

include_once("../config.php");

function get_total ($table, $conn) {
    $countSQL = $conn -> query("SELECT COUNT(*) AS NBR_Total FROM $table");

    if ($countSQL -> num_rows > 0) {
        $countSQL = $countSQL -> fetch_assoc();
        $countConges = $countSQL["NBR_Total"];
        return $countConges>9 ? $countConges : "0".$countConges;
    }
    else {
        return 0;
    }
    
}

if (isset($_POST["id_trash"])) {
    if (isset($_POST["type_doc"]) && $_POST["type_doc"] === "NOTE DE REMPLACEMENT") {

        $id_ToDelete = check_input($_POST["id_trash"]);
        $RmvQr1 = "DELETE FROM substitutes WHERE id_rempl = ?";
        $rmvSQL1 = $conn -> prepare($RmvQr1);
        $rmvSQL1 -> bind_param("i", $id_ToDelete);

        if ($rmvSQL1 -> execute()) {
            $RmvQr2 = "DELETE FROM replacement WHERE id = ?";
            $RmvSQL2 = $conn -> prepare($RmvQr2);
            $RmvSQL2 -> bind_param("i", $id_ToDelete);

            if ($RmvSQL2 -> execute()) {
                echo "L'enregistrement a été supprimé avec succès !!!";
            }
            else {
                echo "Impossible de supprimer cet enregistrement";
            }

        }
        else {
            echo "Enregistrement non supprimé.";
        }
    }
    elseif (isset($_POST["type_doc"]) && $_POST["type_doc"] === "TITRE DE CONGÉ ADMINISTRATIF") {
        $id_ToDelete = check_input($_POST["id_trash"]);
        $RmvQr1 = "DELETE FROM titredeconge WHERE id_acte = ?";
        $rmvSQL1 = $conn -> prepare($RmvQr1);
        $rmvSQL1 -> bind_param("i", $id_ToDelete);

        if ($rmvSQL1 -> execute()) {
            $RmvQr2 = "DELETE FROM ampliations WHERE id_titre = ?";
            $RmvSQL2 = $conn -> prepare($RmvQr2);
            $RmvSQL2 -> bind_param("i", $id_ToDelete);

            if ($RmvSQL2 -> execute()) {
                echo "Le titre de congé administratif a été supprimé avec succès !!!";
            }
            else {
                echo "Impossible de supprimer ce titre de congé administratif.";
            }

        }
        else {
            echo "Titre de congé administratif non supprimé.";
        }
    }
} 
elseif (isset($_POST["donnees"])) {
    $tables = ["titredeconge", "replacement"];
    $dicTotal = array();
    foreach ($tables as $table) {
        array_push($dicTotal, get_total($table, $conn));
    }
    $response = array(
        "donnees" => $dicTotal
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    
    
}
else {
    echo "No POST data here !";
}

$conn -> close();