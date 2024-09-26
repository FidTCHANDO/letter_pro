<?php
    require_once("../config.php");
    // echo "Not good";
    
    if (isset($_POST['search_bar'])) {
        $keyword = check_input($_POST["search_bar"]);
        $data = array();
        $base = check_input($_POST["database"]);
        $table = $base === "TITRE DE CONGÉ ADMINISTRATIF" ? "titredeconge" : "replacement";
        $field = $base === "TITRE DE CONGÉ ADMINISTRATIF" ? "name_agent" : "libele_activite";

        if ($keyword==="") {
            $list = $conn -> query("SELECT *, DATE(datecreation) AS datedecreation FROM $table");

            if ($list -> num_rows > 0) {
                while ($listActe = $list -> fetch_assoc()) {
                    array_push($data, $listActe);
                };
            }
            // else {
            //     echo json_encode([]);
            // }
    
        }
        else {
            $list = $conn -> prepare("SELECT *, DATE(datecreation) AS datedecreation FROM $table WHERE $field LIKE CONCAT('%',?,'%')");
            $list -> bind_param("s", $keyword);
            $list -> execute();
            $list = $list -> get_result();
            // $search = check_input($_POST["search_bar"]);
            // echo $search;
            $data = array();

            if ($list -> num_rows > 0) {
                while ($listActe = $list -> fetch_assoc()) {
                    array_push($data, $listActe);
                };
            }
            // else {
            //     echo json_encode([]);
            // }

        }
        
        $response = array(
            "events" => $data
        );

        // Output the data as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        
        
    }

    $conn -> close();
?>