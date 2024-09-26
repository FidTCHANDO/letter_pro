<?php
    require_once("./session.php");    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer</title>
    <link rel="stylesheet" href="styles/bootstrap.css">
    <link rel="stylesheet" href="styles/mystyle.css">
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
                        <a class="nav-link" href="./" aria-current="page">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Enregistrer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./search/">Rechercher</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <?= $_SESSION["username"]?><img class="rounded mx-1 bg-white" src="<?php if (isset($_SESSION["profpicture"])) {
                            echo $_SESSION["profpicture"];
                          } else {
                            echo "./pictures/default.png";
                          } ?>" alt="Pic" style="height: 20px; width: 20px;" srcset="">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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

                <h3 class="">Formulaire de rédaction d'actes administratifs</h3>
                <form action="" method="post" role="form" id="conges_form">
                    <div class="row my-2">
                        <div class="form-group col-4">
                            <label for="reference"><strong>Référence</strong></label>
                            <input class="form-control silver" type="text" name="reference" value = "<?php echo 'N°______/'.substr(date("Y"),-2).'/DDS-Cou/SPAF/SA' ?>" id="reference" required>
                            <small class="form-text text-muted">Laissez vide si correct</small>
                        </div>

                        <div class="form-group col-auto">
                            <label for="locationid"><strong>Lieu</strong></label>
                            <input type="text" name="lieu" value = "Aplahoué, le" id="locationid" class="form-control silver" required>
                            <small class="form-text text-muted">Laissez vide si correct</small>
                        </div>

                        <div class="form-group col-4">
                            <label for="type"><strong>Nom de l'acte</strong></label>
                            <select name="type" id="type" class="form-select form-select-md silver" required aria-label="Large select example">
                                <option selected>TITRE DE CONGÉ ADMINISTRATIF</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="form-group col-6">
                            <label for="name_agent"><strong>Nom et prénoms de l'agent (*)</strong></label>
                            <input type="text" name="name_agent" id="name_agent" class="form-control" required>
                            <!-- <small class="form-text text-muted">Laissez vide si correct</small> -->
                        </div>
                        <div class="form-group col-6">
                            <label for="fonction_agentid"><strong>Fonction de l'agent (*)</strong></label>
                            <input type="text" name="fonction_agent" placeholder = "Ex: Chef Division... / Technicien... " id="fonction_agentid" class="form-control" required>
                        </div>

                    </div>
                    
                    <div class="form-group col-3 my-2">
                        <strong>Sexe :</strong>
                        <input class="form-check-input" value="M" type="radio" name="sexe" id="M">
                        <label class="form-check-label" for="M">M</label>
                        <input class="form-check-input" value="F" type="radio" name="sexe" id="F">
                        <label class="form-check-label" for="F">F</label>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="posteid"><strong>Poste de l'agent</strong> (en service à :)</label>
                            <input type="text" name="poste" placeholder = "Ex: la Direction Départementale.../ l'Hopital..." id="posteid" class="form-control" required>
                        </div>
                        <div class="form-group col-4">
                            <label for="periodeid"><strong>Période des congés</strong></label>
                            <input type="text" name="periode" placeholder = "Ex: d'un (01) mois/d'une (01) semaine/..." id="periodeid" class="form-control" required>
                        </div>
                        <div class="form-group col-2">
                            <label for="anneeid"><strong>Année de compte</strong></label>
                            <input type="number" name="annee" placeholder = "Ex: 2022/2023/etc." id="anneeid" class="form-control" max="<?php echo date("Y"); ?>" required>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="form-group col-2">
                            <label for="debutdateid"><strong>Date de début</strong></label>
                            <input type="date" name="debutdate" id="debutdateid" class="form-control" required>
                        </div>
                        <div class="form-group col-2">
                            <label for="retourdateid"><strong>Date de retour</strong></label>
                            <input type="date" name="retourdate" id="retourdateid" class="form-control" required>
                        </div>
                        <div class="form-group col-2">
                            <label for="heureretourid"><strong>Heure de retour</strong></label>
                            <input type="time" name="heureretour" id="heureretourid" value="08:00" class="form-control silver" required>
                        </div>
                        <div class="form-group col-3">
                            <label for="nomsignataireid"><strong>Nom du signataire</strong></label>
                            <input type="text" name="nomsignataire" id="nomsignataireid" value="Dr Jean Yaovi DAHO" class="form-control silver" required>
                        </div>
                        <div class="form-group col-3">
                            <label for="titresignataireid"><strong>Titre du signataire</strong></label>
                            <input type="text" name="titresignataire" id="titresignataireid" value="Le Directeur" class="form-control silver" required>
                        </div>

                    </div>

                    <form id="ampliation_form" method="post" action="">
                    <div class="row"><div id="inputsContainer" class="col-6"></div></div>
                    <input type="number" name="ampliCount" id="ampliCount" hidden>
                    </form>

                    <h5 class="mt-3">Ampliations</h5>
                    <form id="generator_ampl_form">
                        <div class="form-group row">
                            <div class="col-auto">
                                <label class="col-form-label" for="inputCount">Nombre de champs de texte:</label>
                            </div>
                            <div class="col-1">
                                <input type="number" class="form-control" id="inputCount" value="0" name="inputCount" min="0" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-success" onclick="generateInputs()">Ajouter</button>
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
    
    <script src="styles/jquery-3.7.1.js"></script>
    <script src="styles/jquery.validate.min.js"></script>
    <script src="styles/popper.min.js"></script>
    <script src="styles/bootstrap.js"></script>
    
    <!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script> -->

    <script>
        function generateInputs() {
            // Get the number of inputs to generate
            var numberOfInputs = document.getElementById('inputCount').value;
            var inputsContainer = document.getElementById('inputsContainer');
            var ampliCount = document.getElementById('ampliCount');
            
            ampliCount.value = numberOfInputs;
            // Clear any existing inputs
            inputsContainer.innerHTML = '';

            // Generate the new inputs
            for (var i = 0; i < numberOfInputs; i++) {
                var amplist = document.createElement('input');
                amplist.type = 'text';
                amplist.name = 'amplist' + (i + 1);
                amplist.classList.add("form-control");
                amplist.required = true;
                amplist.placeholder = 'Structure/service...' + (i + 1);

                var numamplist = document.createElement('input');
                numamplist.type = 'number';
                numamplist.name = 'numamplist' + (i + 1);
                numamplist.classList.add("form-control");
                numamplist.required = true;
                numamplist.value = 1;
                // amplist.placeholder = 'Structure/service ' + (i + 1);

                var divrow = document.createElement('div');
                var divtags1 = document.createElement('div');
                var divtags2 = document.createElement('div');

                divrow.classList.add("form-group", "row","my-2");
                divtags1.classList.add("col-auto");
                divtags2.classList.add("col-2");
                // divtags2.nodeValue = "1";

                
                divtags1.appendChild(amplist);
                divtags2.appendChild(numamplist);
                // divtags.appendChild(document.createElement('br')); // Line break for better formatting

                divrow.appendChild(divtags1);
                divrow.appendChild(divtags2);
                inputsContainer.appendChild(divrow);
                
            }
        }

        function clearInput() {
            document.getElementById('inputCount').value = "";
            document.getElementById('inputsContainer').innerHTML = "";
            
        }
    </script>
    <script src="styles/myjquery.js"></script>
</footer>
</html>