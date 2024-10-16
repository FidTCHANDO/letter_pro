<?php 
    require_once("../session.php");
    if (!isset($_SESSION["username"])) {
        header("location:../index.php");
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LetterPro: Recherche</title>
    <link rel="stylesheet" href="../styles/bootstrap.css">
    <link rel="stylesheet" href="../styles/css/all.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../styles/css/fontawesome.min.css">
    <style>
        
        .icon:focus, .icon:hover {
            cursor: pointer;
        }


    </style>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark align-right bg-dark" >
        <div class="container justify-content">
            <a class="navbar-brand" href="../">LetterPro</a>
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
                        <a class="nav-link" href="./select.php">Enregistrer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Rechercher</a>
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
    <div class="mt-2">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="alert alert-success d-flex justify-content-between d-none" id="alert">
                    <span id="result"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mt-3" id="tables">

        <div class="row d-flex justify-content-end mx-auto">

            <div class="col-3">
                <div class="input-group">
                    <select name="field" id="field" class="form-select">
                        <option value="TITRE DE CONGÉ ADMINISTRATIF" selected>TITRE DE CONGÉ ADMINISTRATIF</option>
                        <option value="NOTE DE REMPLACEMENT">NOTE DE REMPLACEMENT</option>
                    </select>
                </div>
            </div>

            <div class="col-3">
                <!-- <div class="display-3"> -->
                    <!-- <i class="fa fa-search" aria-hidden="true">Recherche</i> -->
                    <!-- <div class="row"> -->
                        <!-- <div class="mt-2"> -->
                            <div class="input-group mb-3">
                                <input type="text" id="search_bar" name="search_bar" class="form-control" autofocus
                                placeholder="Rechercher" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button> -->
                            </div>
                        <!-- </div> -->
                    <!-- </div> -->
                    
                <!-- </div> -->
            </div>
            
        </div>
        
        <div id="disp_result">
            
        </div>
        
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment supprimer cet enregistrement ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="delete_btn" data-bs-dismiss="modal" class="btn btn-danger">Confirmer</button>
            </div>
            </div>
        </div>
        </div>

        <div class="table-responsive">
        <table class="table align-middle table-striped table-hover" id="tableActes">
        <thead>
            <tr class="text-white align-middle">
            <th class="bg-primary" scope="col">#</th>
            <th class="bg-primary" scope="col" style="width: 260px" id="hd_nom">Nom de l'acte</th>
            <th class="titrehead bg-primary" scope="col"><span>Nom et Prénoms</span></th>
            <th class="titrehead bg-primary" scope="col"><span>Sexe</span></th>
            <th class="replacehead d-none bg-primary" scope="col" style="width: 350px;" id="hd_lib"><span>Libellé de l'activité</span></th>
            <th class="replacehead d-none bg-primary" scope="col"><span >Nombre de <br>remplaçants</span></th>
            <th scope="col" class="bg-primary"><span>Date de début</span></th>
            <th scope="col" class="bg-primary"><span>Date de fin</span></th>
            <th scope="col" class="bg-primary">Ajouté le</span></th>
            <th scope="col" class="bg-primary" style="min-width: 130px;">Actions</th>
            </tr>
        </thead>
        <div id="empty" class="d-none">Pas de données</div>
        </table>
        </div>

    <nav class="" aria-label="pages" id="pagination_nav">
    <ul class="pagination" id="listpages">
        
    </ul>
    </nav>
        
    </div>


</body>

<footer>
<!-- 
CDN
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
-->
    <script src="../styles/jquery.min.js"></script>
    <script src="../styles/popper.min.js"></script>
    <script src="../styles/bootstrap.js"></script>
    <script src="./search.js"></script>

</footer>
</html>