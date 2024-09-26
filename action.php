<?php
    require_once("./config.php");

    if (isset($_POST['action']) && $_POST['action'] === 'register') {

        // Variables creation
        $name = check_input($_POST['Fullname']);
        $username = check_input($_POST['Username']);
        $pass = sha1(check_input($_POST['Password']));
        $cpass = sha1(check_input($_POST['Cpassword']));
        $created = date("Y-m-d");

        // Control password
        if ($pass != $cpass) {
            echo "Passwords did not match";
        }
        else {
            // COntrol the username and email do not exist
            $checksql = $conn -> prepare("SELECT identifiant FROM gestionnaires WHERE identifiant = ?");
            $checksql -> bind_param("s", $username);
            $checksql -> execute();
            $output = $checksql -> get_result();
            $row = $output -> fetch_array(MYSQLI_ASSOC);

            if (!is_null($row) && $row["identifiant"] === $username) {
                echo 'Username is not available, please change it';
            }
            else { # save the information
                $save = $conn -> prepare("INSERT INTO gestionnaires (nom, identifiant, motdepasse, creation_date) VALUES (?,?,?,?)");
                $save -> bind_param("ssss", $name, $username, $pass, $created);
                if ($save -> execute()) {
                    // Find the user id
                    $finduser = $conn -> prepare("SELECT id FROM gestionnaires WHERE identifiant = ?");
                    $finduser -> bind_param("s", $username);
                    $finduser -> execute();
                    $funduser = $finduser -> get_result();
                    $theuserid = $funduser -> fetch_array(MYSQLI_ASSOC);

                    $newprof = $conn -> prepare("INSERT INTO profile_tab (id_gest) VALUES (?)");
                    $newprof -> bind_param("i",$theuserid["id"]);
                    if ($newprof -> execute()){
                        echo "You has been successfully registred";
                    }
                    else {
                        echo "Registration failed to add pic";
                    }
                    // echo "You has been successfully registred";
                } else {
                    echo "Registration failed";
                } 
                
            }

        }
        
    };

    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        session_start();
        // variables for login
        $login = check_input($_POST['logusername']);
        $logpass = sha1(check_input($_POST['logpassword']));

        $match = $conn -> prepare("SELECT * FROM gestionnaires WHERE identifiant = ? AND motdepasse = ?");
        $match -> bind_param("ss", $login, $logpass);
        $match -> execute();
        $match = $match ->get_result();
        $line = $match -> fetch_array();

        if ($line != null) {
            $_SESSION["username"] = $line['identifiant'];
            echo "ok";

            if (!empty($_POST['keep'])) {
                setcookie("username", $_POST["logusername"], time()+3600*24*30);
                setcookie("password", $_POST["logpassword"], time()+3600*24*30);
            }
            else {
                if (isset($_COOKIE["username"])) {
                    setcookie("username","");
                }
                if (isset($_COOKIE["password"])) {
                    setcookie("password","");
                }
            };
        }
        else {
            echo "The email/username or password is not correct";
        };
        
    };
    
    if (isset($_POST['action']) && $_POST['action'] === 'letter') {
        ## variables creation
        $reference = check_input($_POST['reference']);
        $lieu = check_input($_POST['lieu']);
        $type = check_input($_POST['type']);
        $name_agent = check_input($_POST['name_agent']);
        $fonction_agent = check_input($_POST['fonction_agent']);
        $sexe = check_input($_POST['sexe']);
        $poste = check_input($_POST['poste']);
        $periode = check_input($_POST['periode']);
        $annee = check_input($_POST['annee']);
        $debutdate = check_input($_POST['debutdate']);
        $retourdate = check_input($_POST['retourdate']);
        $heureretour = check_input($_POST['heureretour']);
        $nomsignataire = check_input($_POST['nomsignataire']);
        $titresignataire = check_input($_POST['titresignataire']);
        $inputCount = check_input($_POST['ampliCount']);
        $datecreation = date("Y-m-d");

        if ($inputCount > 0) {
            for ($i=1; $i <= $inputCount; $i++) { 
                ${"amplist$i"} = check_input($_POST["amplist$i"]);
                ${"numamplist$i"} = check_input($_POST["numamplist$i"]);
                
            };
        };

        ## Insert into the two database tables
        $titreinsertion = $conn -> prepare("INSERT INTO titredeconge (reference, lieu, typeacte,
        name_agent, sexe, fonction_agent, poste, periode, annee, debutdate, retourdate, heureretour,
        nomsignataire, titresignataire, inputCount, datecreation) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $titreinsertion -> bind_param("ssssssssisssssis", $reference, $lieu, $type, $name_agent,$sexe,
        $fonction_agent, $poste, $periode, $annee, $debutdate, $retourdate, $heureretour,
        $nomsignataire, $titresignataire, $inputCount, $datecreation);

        if ($titreinsertion -> execute()) {
            $findacte = $conn -> prepare("SELECT id_acte, datecreation FROM titredeconge WHERE name_agent = ? AND fonction_agent = ?
            AND periode = ? AND debutdate = ?");
            $findacte -> bind_param("ssss", $name_agent, $fonction_agent, $periode, $debutdate);
            $findacte -> execute();
            $fundacte = $findacte -> get_result();
            $listfund = $fundacte -> fetch_array(MYSQLI_ASSOC);
            
            if ($listfund != null) {
                
                if ($inputCount > 0) {
                    for ($i=1; $i <= $inputCount; $i++) { 
                        $addampli_sql = $conn -> prepare("INSERT INTO ampliations (id_titre, amplist, numamplist,
                        creation_date) VALUES (?,?,?,?)");
                        
                        $addampli_sql -> bind_param("isis", $listfund['id_acte'], ${"amplist$i"}, 
                        ${"numamplist$i"}, $listfund['datecreation']);

                        if ($addampli_sql -> execute()) {
                            if ($i == $inputCount) {
                               echo "Le".$type." est créé avec succes";
                            }
                        }
                        else {
                            echo "Ampliations ".$i." non créées";
                        }
                    };
                }
                else {
                    echo "Le".$type." est créé avec succes";
                }

                
            }
            else {
                echo "Impossible de retrouver l'enregistrement";
            };
    
        }
        else {
            echo "Echec d'enregistrement de l'acte";
        };

    };

    if (isset($_POST['action']) && $_POST['action'] === 'replacement') {

        ## variables creation
        $reference = check_input($_POST['reference']);
        $lieu = check_input($_POST['lieu']);
        $type = check_input($_POST['type']);
        $reference_note = check_input($_POST['reference_note']);
        $libele_activite = check_input($_POST['libele_activite']);
        $budget = check_input($_POST['budget']);
        $lignebudgetaire = check_input($_POST['lignebudgetaire']);
        $intituleLB = check_input($_POST["intitule_ligne"]);
        $anneegestion = check_input($_POST["gestion"]);
        $othersource = check_input($_POST['othersource']);
        $datedebut = check_input($_POST["debutdate"]);
        $datefin = check_input($_POST["datefin"]);
        $remplCounter = check_input($_POST['remplCounter']);
        $nomsignataire = check_input($_POST['nomsignataire']);
        $titresignataire = check_input($_POST['titresignataire']);
        $datecreation = date("Y-m-d H:i:s");

        if ($remplCounter > 0) {
            for ($i=1; $i <= $remplCounter; $i++) { 
                ${"rempl$i"} = check_input($_POST["rempl$i"]);
                ${"funcrempl$i"} = check_input($_POST["funcrempl$i"]);
                ${"replaceagent$i"} = check_input($_POST["replaceagent$i"]);
                ${"funcreplaceagent$i"} = check_input($_POST["funcreplaceagent$i"]);
            };
        };

        ################ Enregistrement dans la base de données 
        if ($budget === "Budget National") {
            $remplSQL = $conn -> prepare("INSERT INTO replacement (reference, lieu, typeacte,
            reference_note, libele_activite, budget, ligne_budgetaire, intitule_ligne, annee_gestion, datedebut, datefin,
            nomsignataire, titresignataire, replaceCount, datecreation) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $remplSQL -> bind_param("ssssssssissssis", $reference, $lieu, $type, $reference_note, 
            $libele_activite, $budget, $lignebudgetaire, $intituleLB, $anneegestion, $datedebut, $datefin, $nomsignataire,
            $titresignataire, $remplCounter, $datecreation);
        } elseif ($budget === "Organisateur") {
            $remplSQL = $conn -> prepare("INSERT INTO replacement (reference, lieu, typeacte,
            reference_note, libele_activite, budget, datedebut, datefin,
            nomsignataire, titresignataire, replaceCount, datecreation) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

            $remplSQL -> bind_param("ssssssssssis", $reference, $lieu, $type, $reference_note, 
            $libele_activite, $budget, $datedebut, $datefin, $nomsignataire,
            $titresignataire, $remplCounter, $datecreation);
        } else {
            $remplSQL = $conn -> prepare("INSERT INTO replacement (reference, lieu, typeacte,
            reference_note, libele_activite, budget, autre_source, datedebut, datefin,
            nomsignataire, titresignataire, replaceCount, datecreation) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $remplSQL -> bind_param("sssssssssssis", $reference, $lieu, $type, $reference_note, 
            $libele_activite, $budget, $othersource, $datedebut, $datefin, $nomsignataire,
            $titresignataire, $remplCounter, $datecreation);
        }
        

        if ($remplSQL -> execute()) {
            $idgotten = $conn -> insert_id;

            for ($i=1; $i <= $remplCounter; $i++) { 
                $substSQL = $conn -> prepare("INSERT INTO substitutes (id_rempl, subst_fullname, subst_function,
                new_fullname, new_function, adding_time) VALUES (?, ?, ?, ?, ?, ?)");

                // $substSQL -> bind_param("isssss", $remplresult["id"], ${"rempl$i"}, ${"funcrempl$i"},
                $substSQL -> bind_param("isssss", $idgotten, ${"rempl$i"}, ${"funcrempl$i"},
                ${"replaceagent$i"}, ${"funcreplaceagent$i"}, $datecreation);

                $substSQL -> execute();
                if ($i == $remplCounter) {
                    echo "Recording saved successfully !!!";
                }
            }

        }
        else {
            echo "Failed to create a registration of replacement";
        }


    }
?>