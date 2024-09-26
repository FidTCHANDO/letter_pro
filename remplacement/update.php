<?php
    require_once("../config.php");    
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:../index.php");
    };
    if (isset($_GET["pin"])) {
        $pin = check_input($_GET["pin"]);
        $updt_con = $conn -> query("SELECT * FROM replacement WHERE id = $pin");

        if ($updt_con -> num_rows == 1) {
            $updat_data = $updt_con -> fetch_assoc();
            $rep_sql = $conn -> query("SELECT * FROM substitutes WHERE id_rempl = $pin");
            if ($rep_sql -> num_rows > 0) {
                $get_rep = $rep_sql -> fetch_all(MYSQLI_ASSOC);
                
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification: Remplacement</title>
    <link rel="stylesheet" href="../styles/bootstrap.css">
    <link rel="stylesheet" href="../styles/mystyle.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark align-right bg-dark">
        <div class="container justify-content">
            <a class="navbar-brand" href="#">LetterPro</a>
            <button
                class="navbar-toggler d-lg-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId"
                aria-controls="collapsibleNavId"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../" aria-current="page">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../search/select.php">Enregistrer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../search/">Rechercher</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <?= $_SESSION["username"]?><img class="rounded mx-1 bg-white" src="<?php if (isset($_SESSION["profpicture"])) {
                            echo '../'.$_SESSION["profpicture"];
                          } else {
                            echo "../pictures/default.png";
                          } ?>" alt="Pic" style="height: 20px; width: 20px;" srcset="">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    Message : <?php print_r($get_rep); ?>
    <!-- Main part of the page -->
    <div class="container my-3 " id="mainpart">
    <div class="d-flex justify-centent-center">
            <div class="col-lg-8 bg-white card-body rounded border-top-primary" id="login-box">
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <div class="alert alert-success d-flex justify-content-between d-none" id="alert">
                        <span id="result"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>

                <h3 class="">Formulaire de note de remplacement</h3>
                <form action="" method="post" role="form" id="replace_form">
                    <div class="row my-2">
                        <div class="form-group col-4">
                            <label for="reference"><strong>Référence</strong></label>
                            <input class="form-control silver" type="text" name="reference" 
                                value = "<?php echo $updat_data["reference"] ?>" id="reference" required>
                            <small class="form-text text-muted">Laissez vide si correct</small>
                        </div>

                        <div class="form-group col-2">
                            <label for="locationid"><strong>Lieu</strong></label>
                            <input type="text" name="lieu" value = "<?= $updat_data["lieu"] ?>" id="locationid" class="form-control silver" required>
                            <small class="form-text text-muted">Laissez vide si correct</small>
                        </div>

                        <div class="form-group col-6">
                            <label for="type"><strong>Nom de l'acte</strong></label>
                            <select name="type" id="type" class="form-select form-select-md silver" required aria-label="Large select example">
                                <option selected value="NOTE DE REMPLACEMENT">NOTE DE REMPLACEMENT</option>
                                <option value="TITRE DE CONGÉ ADMINISTRATIF" disabled>TITRE DE CONGÉ ADMINISTRATIF</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="form-group col-6">
                            <label for="reference_note"><strong>Référence de la note de service (*)</strong></label>
                            <!-- <input type="text" name="reference_note" placeholder="" id="reference_note" class="form-control" required> -->
                            <textarea name="reference_note" id="reference_note" class="form-control"
                            placeholder="Ex: Note de service N°633/24/DDS-C/SSPR/SA du 12/09/2024" required><?= $updat_data["reference_note"] ?></textarea>
                        </div>
                        <div class="form-group col-6">
                            <label for="libele_activite"><strong>Libellé de l'activité (*)</strong></label>
                            <!-- <input type="text" name="libele_activite" id="libele_activite" class="form-control" required> -->
                             <textarea class="form-control" name="libele_activite" id="libele_activite" required><?= $updat_data["libele_activite"] ?></textarea>
                            <!-- <small class="form-text text-muted">Laissez vide si correct</small> -->
                        </div>
                        

                    </div>
                    
                    

                    <div class="row my-2">

                        <div class="form-group col">
                            <label for="nomsignataireid"><strong>Nom du signataire</strong></label>
                            <input type="text" name="nomsignataire" id="nomsignataireid" value="<?= $updat_data["nomsignataire"] ?>" class="form-control silver" required>
                        </div>
                        <div class="form-group col">
                            <label for="titresignataireid"><strong>Titre du signataire</strong></label>
                            <input type="text" name="titresignataire" id="titresignataireid" value="<?= $updat_data["titresignataire"] ?>" class="form-control silver" required>
                        </div>
                                                
                    </div>
                    <div class="row my-2">
                        <?php 
                            $BN = $updat_data["budget"] === "Budget National" ? "selected" : "";
                            $ORGA = $updat_data["budget"] === "Organisateur" ? "selected" : "";
                            $AUTRE = $updat_data["budget"] === "Autre" ? "selected" : "";
                         ?>
                        <div class="form-group col-2">
                            <label for="budget"><strong>Source de financement(*)</strong></label>
                            <select name="budget" id="budget" class="form-select" required aria-label="Large select example">
                                    <option <?= $BN ?> value="Budget National">Budget National</option>
                                    <option <?= $ORGA ?> value="Organisateur">Organisateur</option>
                                    <option <?= $AUTRE ?> value="Autre">Autre à préciser</option>
                            </select>
                        </div>
                        <div class="form-group col-4" id="divlignebn">
                            <label for="lignebudgetaire"><strong>Ligne budgétaire</strong></label>
                            <textarea name="lignebudgetaire" id="lignebudgetaire" placeholder="Ex: 045001000 3200121 2002000601 1 0111 6114" class="form-control">
                            <?= $updat_data["ligne_budgetaire"] ?>
                            </textarea>
                        </div>
                        <div class="form-group col-4 d-none" id="other">
                            <label for="othersource"><strong>Préciser source de financement</strong></label>
                            <input type="text" name="othersource" value="<?= $updat_data["autre_source"] ?>" id="othersource" placeholder="Ex: OMS, UNICEF, etc." 
                            class="form-control">
                        </div>
                        <div class="form-group col-4" id="divintitule_ligne">
                            <label for="intitule_ligne"><strong>Intitulé de la ligne budgétaire</strong></label>
                            <textarea name="intitule_ligne" value="<?= $updat_data["intitule_ligne"] ?>" class="form-control" placeholder="Ex: Indemnités de mission à l'intérieur" id="intitule_ligne"></textarea>
                        </div>
                        <div class="form-group col-2" id="divgestion">
                            <label for="gestion"><strong>Année de gestion</strong></label>
                            <input type="number" class="form-control" name="gestion" id="gestion" value="<?= $updat_data["annee_gestion"] ?>">
                        </div>
                        <div class="form-group col-2">
                            <label for="debutdateid"><strong>Date de début</strong></label>
                            <input type="date" name="debutdate" id="debutdateid" class="form-control" value="<?= $updat_data["datedebut"] ?>" required>
                        </div>
                        <div class="form-group col-2">
                            <label for="datefinid"><strong>Date de fin</strong></label>
                            <input type="date" name="datefin" id="datefinid" class="form-control" value="<?= $updat_data["datefin"] ?>" required>
                        </div>
                    
                    </div>
                    
                    <h5 class="mt-3">Remplacement (*)</h5>
                    <form id="remplacement_form" method="post" action="">
                    <div class="row"><div id="inputsContainer" class="col">
                        <div class="form-group my-2 row">
                            <div class="col">
                                <input class="form-control my-1" type="text" name="rempl1" id="rempl1" 
                                placeholder="NOM et Prénoms du remplacé N°" required>
                                <input class="form-control" type="text" name="funcrempl1" id="funcrempl1" 
                                placeholder="Fonction/Poste de l'agent" required>
                            </div>
                            <div class="col">
                                <input class="form-control my-1" type="text" name="replaceagent1" id="replaceagent1" 
                                placeholder="NOM et Prénoms du remplaçant N°" required>
                                <input class="form-control" type="text" name="funcreplaceagent1" id="funcreplaceagent1" 
                                placeholder="Fonction/Poste de l'agent" required>
                            </div>
                        </div>
                    </div></div>
                    <input type="number" name="remplCounter" id="remplCounter" value="1" hidden>
                    </form>

                    
                    <form id="generator_remp_form" method="post">
                        <div class="form-group row">
                            <div class="col-auto">
                                <label class="col-form-label" for="rempCount">Nombre de personnes remplacées:</label>
                            </div>
                            <div class="col-1">
                                <input type="number" class="form-control" id="rempCount" value="<?= $updat_data["replaceCount"] ?>" name="rempCount" min="1" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-success" onclick="generateInputs()">Générer</button>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger" onclick="clearInput()">Effacer</button>
                            </div>
                        </div>
                    </form>
                    

                    <!-- <div class="form-group form-check">
                        <input type="checkbox" name="confirmer" id="id_keep" class="form-check-input">
                        <label for="id_keep" class="form-check-label">Confirmer</label>
                    </div> -->
                    
                    <div class="form-group mt-1">
                        <input type="submit" value="Enregistrer" id="enregistrer_btn" class="btn btn-block btn-primary">
                    </div>
                </form> 

                
                
            </div>
        </div>
    </div>

</body>

<footer>
<!-- 
CDN
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
-->
    
    <script src="../styles/jquery-3.7.1.js"></script>
    <script src="../styles/jquery.validate.min.js"></script>
    <script src="../styles/popper.min.js"></script>
    <script src="../styles/bootstrap.js"></script>
    <!-- <script src="../styles/jquery-ui.min.js"></script> -->
    
    <!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script> -->

    <script>
        function generateInputs() {
            // Get the number of inputs to generate
            var numberOfInputs = document.getElementById('rempCount').value;
            var inputsContainer = document.getElementById('inputsContainer');
            var remplCounter = document.getElementById('remplCounter');
            
            
            remplCounter.value = numberOfInputs;
            // Clear any existing inputs
            inputsContainer.innerHTML = '';

            // Generate the new inputs
            for (var i = 0; i < numberOfInputs; i++) {
                var remplist = document.createElement('input');
                remplist.type = 'text';
                remplist.name = 'rempl' + (i + 1);
                remplist.classList.add("form-control", "my-1");
                remplist.required = true;
                remplist.placeholder = 'NOM et Prénoms du remplacé N°' + (i + 1);

                var funcremplist = document.createElement('input');
                funcremplist.type = 'text';
                funcremplist.name = 'funcrempl' + (i + 1);
                funcremplist.classList.add("form-control");
                funcremplist.required = true;
                funcremplist.placeholder = 'Fonction/Poste de l\'agent' + (i + 1);

                var replaceagent = document.createElement('input');
                replaceagent.type = 'text';
                replaceagent.name = 'replaceagent' + (i + 1);
                replaceagent.classList.add("form-control", "my-1");
                replaceagent.required = true;
                replaceagent.placeholder = 'NOM et Prénoms remplaçant N°' + (i + 1);

                var funcreplaceagent = document.createElement('input');
                funcreplaceagent.type = 'text';
                funcreplaceagent.name = 'funcreplaceagent' + (i + 1);
                funcreplaceagent.classList.add("form-control");
                funcreplaceagent.required = true;
                funcreplaceagent.placeholder = 'Fonction/Poste de l\'agent' + (i + 1);

                var divrow = document.createElement('div');
                var divtags1 = document.createElement('div');
                var divtags2 = document.createElement('div');

                divrow.classList.add("form-group", "row","my-2");
                divtags1.classList.add("col");
                divtags2.classList.add("col");
                // divtags2.nodeValue = "1";

                
                divtags1.appendChild(remplist);
                divtags1.appendChild(funcremplist);
                divtags2.appendChild(replaceagent);
                divtags2.appendChild(funcreplaceagent);
                // divtags.appendChild(document.createElement('br')); // Line break for better formatting

                divrow.appendChild(divtags1);
                divrow.appendChild(divtags2);
                divrow.classList.add("btborder", "pb-1");
                inputsContainer.appendChild(divrow);
                
            }
        }
        function getInputs() {
            // Get the number of inputs to generate
            var numberOfInputs = <?php echo $updat_data["replaceCount"] ?>;
            var inputsContainer = document.getElementById('inputsContainer');
            var remplCounter = document.getElementById('remplCounter');
            var subs_json = <?php echo json_encode($get_rep); ?>
            
            remplCounter.value = numberOfInputs;
            // Clear any existing inputs
            inputsContainer.innerHTML = '';

            // Generate the new inputs
            for (var i = 0; i < numberOfInputs; i++) {
                var remplist = document.createElement('input');
                remplist.type = 'text';
                remplist.name = 'rempl' + (i + 1);
                remplist.classList.add("form-control", "my-1");
                remplist.required = true;
                // remplist.placeholder = 'NOM et Prénoms du remplacé N°' + (i + 1);
                remplist.value = subs_json[i].subst_fullname ;

                var funcremplist = document.createElement('input');
                funcremplist.type = 'text';
                funcremplist.name = 'funcrempl' + (i + 1);
                funcremplist.classList.add("form-control");
                funcremplist.required = true;
                // funcremplist.placeholder = 'Fonction/Poste de l\'agent' + (i + 1);
                funcremplist.value = subs_json[i].subst_function;

                var replaceagent = document.createElement('input');
                replaceagent.type = 'text';
                replaceagent.name = 'replaceagent' + (i + 1);
                replaceagent.classList.add("form-control", "my-1");
                replaceagent.required = true;
                // replaceagent.placeholder = 'NOM et Prénoms remplaçant N°' + (i + 1);
                replaceagent.value = subs_json[i].new_fullname;

                var funcreplaceagent = document.createElement('input');
                funcreplaceagent.type = 'text';
                funcreplaceagent.name = 'funcreplaceagent' + (i + 1);
                funcreplaceagent.classList.add("form-control");
                funcreplaceagent.required = true;
                // funcreplaceagent.placeholder = 'Fonction/Poste de l\'agent' + (i + 1);
                funcreplaceagent.value = subs_json[i].new_function;

                var divrow = document.createElement('div');
                var divtags1 = document.createElement('div');
                var divtags2 = document.createElement('div');

                divrow.classList.add("form-group", "row","my-2");
                divtags1.classList.add("col");
                divtags2.classList.add("col");
                // divtags2.nodeValue = "1";

                
                divtags1.appendChild(remplist);
                divtags1.appendChild(funcremplist);
                divtags2.appendChild(replaceagent);
                divtags2.appendChild(funcreplaceagent);
                // divtags.appendChild(document.createElement('br')); // Line break for better formatting

                divrow.appendChild(divtags1);
                divrow.appendChild(divtags2);
                divrow.classList.add("btborder", "pb-1");
                inputsContainer.appendChild(divrow);
                
            }
        }
        getInputs();

        function clearInput() {
            document.getElementById('rempCount').value = "";
            document.getElementById('inputsContainer').innerHTML = "";
            
        }
    </script>
    <script src="action_script.js"></script>
</footer>
</html>

<?php
            }
        }
    }
 ?>