<?php 
    require_once("./session.php");
    if (!isset($_SESSION["username"])) {
        header("location:index.php");
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="styles/bootstrap.css">
    <link rel="stylesheet" href="./styles/css/all.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="./styles/css/fontawesome.min.css">
    <style>
        .icon:hover {
            cursor: pointer;
        }

        /* .dashcard {
            height: 10rem;
        } */
        .value {
            font-size: 4rem;
            font-family: monospace;
        }
        .indicator {
            font-size: 1.5rem;
            
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark align-right bg-dark" >
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
                        <a class="nav-link active" href="#" aria-current="page">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./search/select.php">Enregistrer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./search">Rechercher</a>
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
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="alert" id="alert">
                    <span id="result"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container mt-3" id="tables">

        <table class="table table-striped table-hover" id="tableActes">
        <thead>
            <tr>
            <th scope="col" onclick="sortTable2(2)">#</th>
            <th scope="col-2">Nom de l'acte</th>
            <th scope="col" onclick="sortTable(3)">Nom et Prénoms</th>
            <th scope="col">Sexe</th>
            <th scope="col">Date début</th>
            <th scope="col">Date fin</th>
            <th scope="col">Date d'ajout</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        
        </table>

    <nav class="" aria-label="pages" id="pagination_nav">
    <ul class="pagination" id="listpages">
        
    </ul>
    </nav>
        
    </div> -->
    <div class="m-2 px-2">
        <strong>Tableau de bord ></strong>
    </div>


    <div class="m-2 row d-flex justify-content-start">
        <div class="card col-md-3 dashcard shadow col-sm-4 bg-info rounded m-2 p-1">
            <div class="row m-0 card-header">
                <div class="col-8">
                    <span class="h1 text-white text-robot value" id="CountConge">-- </span>
                    <br>
                
                </div>
                <div class="col-4">
                    <div class="icon icon-lg icon-shape text-center border-radius-xl mt-n4 position-absolute">
                    
                    </div>
                </div>
            </div>
            <div class="row m-1">
            <span class="indicator"><strong>Titres de congés</strong></span>
            </div>
        </div>
        <div class="col-md-3 card dashcard col-sm-4 bg-warning rounded m-2 p-1">
            <div class="row m-0 card-header">
                <div class="col-8">
                    <span class="h1 text-white text-robot value" id="CountReplace">100 M</span>
                    
                </div>
                <div class="col-4"></div>
            </div>
            <div class="row m-1">
            <span class="indicator"><strong>Notes de Remplacement</strong></span>
            
            </div>
        </div>
        
    </div>
</body>

<footer>
<!-- 
CDN
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
-->
    <script src="styles/jquery.min.js"></script>
    <script src="styles/popper.min.js"></script>
    <script src="styles/bootstrap.js"></script>
    <script src="useful/animations.js"></script>
    <script>
        
        $(document).ready(function(){
            const numbparpage = 4;
            let currentpage = 1;
            // let tousactes = [];

            $.ajax({
                url: "tousactes.php",
                method: 'GET',
                dataType: "json",
                success: function (data) {
                    donnees = data.events;
                    if (donnees.length>0) {
                        const totalPages = Math.ceil(donnees.length/numbparpage);
                        
                        for (let i = 1; i <= totalPages; i++) {

                            const debut = (i - 1)*numbparpage;
                            const fin = debut + numbparpage; 
                            var donneesPage = donnees.slice(debut, fin);
                            var showntable = i == currentpage ? `` : `d-none`;
                            let minitable = `<tbody id="body${i}" class="${showntable}">`;

                            donneesPage.forEach(acte => {
                                minitable += `<tr>
                                    <th scope="row">${acte.id_acte}</th>
                                    <td>${acte.typeacte}</td>
                                    <td>${acte.name_agent}</td>
                                    <td>${acte.sexe}</td>
                                    <td>${acte.debutdate}</td>
                                    <td>${acte.retourdate}</td>
                                    <td>${acte.datedecreation}</td>
                                    <td class="">
                                        <image src="./pictures/eye.svg" data-row="${acte.id_acte}" class="eye icon">
                                        <i class="fa-solid fa-download icon"></i>
                                        <iframe class="d-none" id="targetPDF${acte.id_acte}" src="./pdf/index.php?id=${acte.id_acte}"></iframe>
                                        <image src="./pictures/trash.svg" data-row="${acte.id_acte}" class="trash icon">
                                    </td>
                                </tr>`
                            });

                            minitable += "</tbody";

                            $("#tableActes").append(minitable);
                            var actived = i === currentpage ? `active` : ``;
                            $("#listpages").append(`
                            <li class="page-item ${actived}">
                            <a class="page-link" data-page="${i}" id="page${i}">${i}</a>
                            </li>
                            `);
                        }

                        function displayTableofPage(page){
                            for (let i = 1; i <= totalPages; i++) {
                                if (!$(`#body${i}`).hasClass('d-none')) {$(`#body${i}`).addClass("d-none");}
                                if ($(`#page${i}`).parent().hasClass("active")) {$(`#page${i}`).parent().removeClass("active");}
                                
                            }
                            $(`#body${page}`).removeClass("d-none");
                            $(`#page${page}`).parent().addClass("active");

                        }

                        $(".page-link").on("click", function () {
                            const page = $(this).data("page");

                            currentpage = page;
                            
                            displayTableofPage(page);

                        });

                        
                        
                    }
                    else {
                        $("#tables").html("Pas de données");
                    }

                    
                },
                complete: function(){
                    
                    $(".eye").on("click", function () {
                        window.location.href = `pdf/?id=${$(this).attr('data-row')}`;
                    });
                    $(".fa-download").on("click", function () {
                        alert("Non disponible. Essayez l'aperçu !!!!");
                    });

                    $(".trash").on("click", function (){
                        var note = $(this).parent().parent().children().eq(1).text();
                        
                        $.ajax({
                            url: "./useful/operations.php",
                            method: "post",
                            data: {id_trash: $(this).data("row"),
                                   type_doc: note
                            },
                            success: function(response){
                                $("#result").html(response);
                                $("#alert").addClass('alert-success');
                                $("#alert").removeClass('d-none');
                                setTimeout(() => {
                                    $("#alert").addClass('d-none');
                                }, 5000);
                                
                            },
                            error: function (xhr, status, error) {
                                alert("An error occured:"+error);
                            }
                        });
                    });
                    
                }

                
            });

            $.ajax({
                url: "./useful/operations.php",
                method: "post",
                data: {"donnees": "titre"},
                success: function (response) {
                    $("#CountConge").animateNumber(response.donnees[0], 1000);
                    $("#CountReplace").animateNumber(response.donnees[1], 1000);
                    
                }
            });

        });
    </script>
    <script src="./useful/sorting.js"></script>
</footer>
</html>