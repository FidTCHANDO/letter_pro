<?php
    // require_once("../session.php");    
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:../index.php");
    };

    include_once("../config.php");
    require_once("../datetotext.php");
    
    function interDate ($debut, $fin) {
        [$jourDB, $dateDB, $moisDB, $anneeDB] = explode(" ",datetotext($debut));
        [$jourF, $dateF, $moisF, $anneeF] = explode(" ",datetotext($fin));
        if ($debut === $fin) {
            $msg = "journée du <strong>".datetotext($debut);
        }
        else {
            $msg = "période du <strong>";
            if ($anneeDB === $anneeF) {
                if ($moisDB === $moisF) {
                    $msg = $msg.$dateDB." au ".$dateF." ".$moisDB." ".$anneeDB;
                }
                else {
                    $msg = $msg.$dateDB." ".$moisDB." au ".$dateF." ".$moisF." ".$anneeDB;
                }
            }
            else {
                $msg = $msg.$dateDB." ".$moisDB." ".$anneeDB." au ".$dateF." ".$moisF." ".$anneeF;
            }
        };

        return $msg."</strong>";
    }
    
    if (isset($_GET["pin"])) {

        $order = check_input($_GET["pin"]);
        $pdfsql = $conn -> prepare("SELECT * FROM replacement WHERE id = ?");
        $pdfsql -> bind_param("i", $order);
        $pdfsql -> execute();
        $result = $pdfsql -> get_result();
    
        $amplsql = $conn -> prepare("SELECT id_substitute, subst_fullname, subst_function, new_fullname, new_function 
        FROM substitutes WHERE id_rempl = ? ORDER BY 1");
        $amplsql -> bind_param("i", $order);
        $amplsql -> execute();
        $resultreplace = $amplsql -> get_result();
    
        if ($result -> num_rows ==1) {
            // echo "Hello";
            $element = $result -> fetch_assoc();
            $subst = $resultreplace -> fetch_all(MYSQLI_ASSOC);
            $nbr = $element["replaceCount"];
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu: Remplacement</title>
    <link rel="stylesheet" href="./format.css">
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
            <div id="reference"><?=$element["reference"] ?></div>
            <div id="location"><?=$element["lieu"] ?></div>
        </div>
        <div id="titre" class="my-3 text-center">
            <div class="mx-auto">
                <strong id="type"><span class="underlined important">NOTE DE SERVICE</span></strong>
            </div>
            
        </div>

        
        <div class="my-4" id="bodyletter">
        <div class="row reference">
            <div class="col-auto"><span style="text-decoration: underline;">Référence :</span></div>
            <div class="col pl-0"><span style="font-weight: bold;"><?=$element["reference_note"] ?></span></div>
        </div>
        
         
        <p class="mt-2">Dans le cadre de l'activité ci-dessus référencée, intitulé <span class="important">
            « <?=$element["libele_activite"] ?> »</span> et pour raisons d'implication dans d'autres activités :
        </p>
        <div class="m-0" id="interest_people">
            <ul>
                <?php 
                    for ($i=0; $i < $element["replaceCount"]; $i++) {
                        $end1 = $i == $nbr - 1 ? "": ($i < $nbr-2 ? ",": " et");
                        ?>
                        <li><span class="important"><?= $subst[$i]["subst_fullname"]; ?></span>, <?= $subst[$i]["subst_function"]; ?><?=$end1;?></li>
                <?php
                    }
                 ?>
                
            </ul>
        </div>
        <?php
            $etre = $nbr<2 ? "est" : "sont";
            $s = $nbr<2 ? "" : "s respectivement";
        ?>
        <?=$etre?> remplacé(e)<?=$s?> durant la <?= interDate($element["datedebut"], $element["datefin"])?> par :
        <div class="m-0" id="interest_people">
            <ul>
            <?php 
                    for ($i=0; $i < $nbr; $i++) { 
                        $end = $i == $nbr - 1 ? ".": ($i < $nbr-2 ? ",": " et");
                        ?>
                        <li><span class="important"><?= $subst[$i]["new_fullname"]; ?></span>, <?php echo $subst[$i]["new_function"].$end; ?></li>
                <?php
                    }
                 ?>
            </ul>
        </div>
        
        <?php echo $element["replaceCount"] >=2 ? "Les intéressé(e)s sont pris(es)" : "L'intéressé(e) est pris(e)"?> en charge par 
        <?php 
            if ($element["budget"] === "Organisateur") {
                $pec = "l'".$element["budget"].".";
            }
            elseif ($element["budget"] === "Autre") {
                $pec = $element["autre_source"].".";
            }
            else {
                $pec = "";
                if (isset($element["ligne_budgetaire"]) && $element["ligne_budgetaire"] != "") {
                    $pec = $pec.'la ligne budgétaire <span class="important">'.$element["ligne_budgetaire"].'</span>';
                    if (isset($element["intitule_ligne"]) && isset($element["intitule_ligne"]) != "") {
                        $pec = $pec.",<< ".$element["intitule_ligne"]." >>";
                    }
                    if (isset($element["annee_gestion"]) && $element["annee_gestion"] != "") {
                        $pec = $pec.", Gestion ".$element["annee_gestion"];
                    }
                }
                else {
                    $pec = $pec."le ".$element["budget"];
                }
                $pec = $pec.".";
            };
            echo $pec;
         ?>
        

            
        </div>
        <div id="signature" class="d-flex justify-content-end">
            <div id="namefonction" class="text-center">
                <p><strong><em><u><span id="nomsignataire"><?= $element["nomsignataire"]; ?></span></u></em></strong></p>
                <p><span id="titresignataire"><?= $element["titresignataire"]; ?></span></p>
            </div>
        </div>

    </div>
</body>
<footer>
    <script src="../styles/jquery.min.js"></script>
    <script src="../styles/popper.min.js"></script>
    <script src="../styles/bootstrap.min.js"></script>
    <script src="../styles/html2pdf.bundle.min.js"></script>

    

    <script>
        function genererpdf() {
            var element = document.getElementById("pdfpage")
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
        };

    }
    else {
        header("location:../search");
    };
 ?>