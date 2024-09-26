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
        .acte {
            background: rgba(225, 225, 225, 0.3);
        }
        .acte:hover {
            border: 1px rgba(0, 0, 0, 0.3) solid;
            box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            transform: scale(1.01);
            transition: .2s ease-in-out;
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
                        <a class="nav-link" href="../new.php">Enregistrer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./index.php">Rechercher</a>
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
    
<div class="container my-4 ">
    <div class="row d-flex justify-content-center m-2">
        <div class="card my-3 acte" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Congés administratifs</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                    <a href="../new.php" class="btn btn-primary">Créer nouveau</a>
                </div>
                </div>
                <div class="col-md-4 p-1">
                <img src="../pictures/apercu_conges.png" class="img-fluid rounded-end shadow-sm" alt="...">
                </div>
                
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center m-2">
        <div class="card my-3 acte" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Note de remplacement</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                    <a href="../remplacement/form" class="btn btn-primary">Créer nouveau</a>
                </div>
                </div>
                <div class="col-md-4 p-1">
                <img src="../pictures/apercu_remplacement.png" class="img-fluid rounded-end shadow-sm" alt="...">
                </div>
                
            </div>
        </div>
    </div>

</div>
<div class="container">
        
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
    

</footer>
</html>