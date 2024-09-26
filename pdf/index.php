<?php

include_once("../config.php");
require_once("../datetotext.php");
if (isset($_GET["id"])) {

    $order = $_GET["id"];
    $pdfsql = $conn -> prepare("SELECT * FROM titredeconge WHERE id_acte = ?");
    $pdfsql -> bind_param("i", $order);
    $pdfsql -> execute();
    $result = $pdfsql -> get_result();

    $amplsql = $conn -> prepare("SELECT amplist, numamplist FROM ampliations WHERE id_titre = ?");
    $amplsql -> bind_param("i", $order);
    $amplsql -> execute();
    $resultampli = $amplsql -> get_result();

    if ($result -> num_rows ==1) {
        // echo "Hello";
        $element = $result -> fetch_assoc();
        $ampliations = $resultampli -> fetch_all(MYSQLI_ASSOC);
        
        $name = $element['name_agent'];

        $name = explode(" ", $name);

        $name[0] = strtoupper($name[0]);

        $name = implode(" ",$name);

        // print($name);
        

        
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu: Congés</title>
    <link rel="stylesheet" href="../styles/mystyle2.css">
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
</head>
<body>

    <div class="d-flex justify-content-center my-3" id="boutondiv">
        <button id="printer" class="btn btn-primary" onclick="printPage()">Imprimer</button>
    </div>

    <div id="pdfpage">
        <div class="d-flex justify-content-between">
            <div class="logo_ms">
                <img id="logoms" src="../gallery/logo_ms.png" alt="logo_ms" srcset="">
            </div>
            <div id="lineheightsmall">
                <p>Adresse postale : BP 02 Azovè <br>Téléphone : +229 62 87 52 80 
                    <br>Email: <a href="mailto:ddscouffosante@yahoo.com">ddscouffosante@yahoo.com</a>
                    <br>Site web: <a href="www.sante.gouv.bj">www.sante.gouv.bj</a>
                </p>
            </div>
            <!-- <div class="address_div">
                <img src="../gallery/address.png" alt="address" id="address">
            </div> -->
        </div>

        <div class="my-3 text-center" id="entete">
                <div class="mx-auto mb-2">
                    <strong>SECRETARIAT GENERAL DU MINISTERE</strong>
                </div>
                <div class="mx-auto">DIRECTION DEPARTEMENTALE DE LA SANTE DU COUFFO</div>
        </div>

        <div id="refandlocation" class="my-3 d-flex justify-content-between">
            <div id="reference"><?= $element["reference"]?></div>
            <div id="location"><?= $element["lieu"] ?></div>
        </div>
        <div id="titre" class="my-3 text-center">
            <div class="mx-auto">
                <strong id="type"><?= $element["typeacte"] ?></strong>
            </div>
            <div class="mx-auto mb-3">
                <strong>***********</strong>
            </div>
        </div>

        <div class="my-4" id="bodyletter">
            <p>
                <span id="gender"><?php echo ($element['sexe'] == "M") ? "Monsieur" : "Madame" ; ?></span> <span id="name" class="important"><?= $name ?></span>, 
                <span id="fonction"><?= $element['fonction_agent']?></span> <!-- Chef Division des Systèmes d'Information et de la Documentation -->
                en service à <span id="poste">la Direction Départementale de la Santé du Couffo</span>, est 
                autorisé<?php echo ($element['sexe'] == "M") ? "" : "e" ; ?> à jouir <span id="periode"><?php echo $element['periode']; ?></span> de congé administratif au titre 
                de l'année <span id="annee"><?php echo $element['annee']; ?></span>, pour compter du <span id="debutdate">
                    <?php echo datetotext($element['debutdate']); ?>
                </span>.
            </p>
            <p>L'intéressé devra rejoindre son poste de travail, le <span id="retourdate" class="important">
            <?php echo datetotext($element['retourdate']); ?></span> à <span class="important">(<span id="heureretour"><?php echo date("H", strtotime($element['heureretour'])); ?></span>) </span> 
                <span class="important">heures.</span>
            </p>
        </div>
        <div id="signature" class="d-flex justify-content-end">
            <div id="namefonction" class="text-center">
                <p><strong><em><u><span id="nomsignataire"><?= $element['nomsignataire'] ?></span></u></em></strong></p>
                <p><span id="titresignataire"><?= $element['titresignataire'] ?></span></p>
            </div>
        </div>

        <div id="ampliation">
            <div><strong><u>Ampliations:</u></strong></div>
            <div id="listampli" class="col-6">
                <div id="list">
                    <!-- <li><span id="amplistid">Chefs Services DDS-C</span> : ....... <span id="numberli">05</span></li>
                    <li>Intéressé : …………………….. 01</li>
                    <li>Archives : ……………………… 01</li> -->
                    <?php 
                        
                        if ($element['inputCount'] > 0) {
                            for ($i=0; $i < $element['inputCount']; $i++) { 
                                echo '<div class="row d-flex justify-content-between"><div class="">'.$ampliations[$i]['amplist'].':</div><div style="border-bottom: dotted 1px; width: auto; margin-bottom: 8px;flex-grow: 2;
                                flex-shrink: 2; flex-basis: auto;" class="dotted"></div><div class="" id="numberli">'.$ampliations[$i]['numamplist'].'</div></div>';
                            }
                        }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <script src="../styles/jquery.min.js"></script>
    <script src="../styles/popper.min.js"></script>
    <script src="../styles/bootstrap.min.js"></script>
    <!-- <script src="../styles/es6-promise.auto.min.js"></script>
    <script src="../styles/jspdf.umd.min.js"></script> -->
    <!-- <script src="../styles/html2canvas.min.js"></script> -->
    <script src="../styles/html2pdf.bundle.min.js"></script>

    

    <script>
        function genererpdf() {
            var element = document.getElementById("pdfpage");
            var opt = {
                margin: 0,
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] },
                filename: 'acte.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: window.devicePixelRatio},
                jsPDF: {unit: 'in', format: 'a4', orientation: 'portrait'}
                };
            
            html2pdf().set(opt).from(element).save()
        }

        function printPage() {
            window.print();
        }
        
    </script>
</footer>
</html>

<?php 

    }
    else {
        header("location:../index.php");
    }
 ?>