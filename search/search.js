var search = $("#search_bar");

function makeInvisible(selection) {
    if (selection.hasClass("d-none")) {
        selection.removeClass("d-none");
    } else {
        selection.addClass("d-none");
    };
};


$(document).ready(function(){

    

    $("#field").change(function(e) {
        if ($(this).val() === "NOTE DE REMPLACEMENT") {
            $(".titrehead").addClass("d-none");
            $(".replacehead").removeClass("d-none");
            search.val("");
            $("tbody").remove();
            $("#listpages").empty();
            search.focus();
        }
        else {
            $(".titrehead").removeClass("d-none");
            $(".replacehead").addClass("d-none");
            search.val("");
            $("tbody").remove();
            $("#listpages").empty();
            search.focus();
        }
    });


    const numbparpage = 4;

    search.keyup(function (e) {
        
        e.preventDefault();
        $.ajax({
            url: "processing.php",
            method: "post",
            data: $("#search_bar").serialize()+"&database="+$("#field").val(),
            success: function (data) {
                let currentpage = 1;
                if (data === "") {
                    $("#empty").removeClass("d-none");
                    $("tbody").remove();
                    $("#listpages").html("Recherchez un acte");
   
                }
                else {
                    $("tbody").remove();
                    $("#listpages").html("");
                    
                    donnees = data.events;
                    if (donnees.length>0) {
                        const totalPages = Math.ceil(donnees.length/numbparpage);
                        
                        for (let i = 1; i <= totalPages; i++) {

                            const debut = (i - 1)*numbparpage;
                            const fin = debut + numbparpage; 
                            var donneesPage = donnees.slice(debut, fin);
                            var showntable = i == currentpage ? "" : "d-none";
                            let minitable = `<tbody id="body${i}" class="${showntable}">`;

                            if ($("#field").val() === "TITRE DE CONGÉ ADMINISTRATIF"){
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
                                        <image src="../pictures/eye.svg" data-row="${acte.id_acte}" class="eye icon">
                                        <i class="fa-solid fa-download"></i>
                                        <i class="fa-solid fa-pencil icon" data-row="${acte.id_acte}"></i>
                                        <image src="../pictures/trash.svg" data-row="${acte.id_acte}"
                                            class="trash icon" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    </td>
                                    </tr>`;
                                });
                            }
                            else {
                                donneesPage.forEach(acte => {
                                    minitable += `<tr>
                                        <th scope="row">${acte.id}</th>
                                        <td>${acte.typeacte}</td>
                                        <td>${acte.libele_activite}</td>
                                        <td>${acte.replaceCount}</td>
                                        <td>${acte.datedebut}</td>
                                        <td>${acte.datefin}</td>
                                        <td>${acte.datedecreation}</td>
                                        <td class="">
                                            <image src="../pictures/eye.svg" data-row="${acte.id}" class="eye icon">
                                            <i class="fa-solid fa-download"></i>
                                            <i class="fa-solid fa-pencil icon" data-row="${acte.id}"></i>
                                            <image src="../pictures/trash.svg" data-row="${acte.id}"
                                                class="trash icon" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        </td>
                                        </tr>`;
                                    });
                            }
                            

                            minitable += "</tbody";

                            $("#tableActes").append(minitable);
                            var actived = i === currentpage ? "active" : "";
                            $("#listpages").append(`
                            <li class="page-item ${actived}">
                            <a class="page-link" data-page="${i}" id="page${i}">${i}</a>
                            </li>
                            `);
                        }

                        function displayTableofPage(page){
                            for (let i = 1; i <= totalPages; i++) {
                                
                                if (!$(`#body${i}`).hasClass("d-none")) {$(`#body${i}`).addClass("d-none");}
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
                        $("#empty").removeClass("d-none");
                    };
                };
                
            },
            complete: function () {
                $(".eye").on("click", function () {

                    if ($("#field").val() === "TITRE DE CONGÉ ADMINISTRATIF") {
                        window.open(`../pdf?id=${$(this).attr('data-row')}`, "_blank");                   
                    }
                    else {
                        window.open(`../remplacement/index.php?pin=${$(this).attr('data-row')}`, '_blank');
                    };
                    
                });

                $(".fa-download").on("click", function () {
                    // var iframe = $(`#targetPDF${$(this).attr("data-row")}`)[0];
                    // iframe.contentWindow.postMessage("executeFunction", "*");
                    alert("Non disponible. Essayez l'aperçu !!!!");
                });
                let id_trash;
                let note;

                $(".trash").on("click", function (){
                    note = $(this).parent().parent().children().eq(1).text();
                    id_trash = $(this).data("row");

                    
                });

                $(".fa-pencil").on("click", function () {
                    if ($("#field").val() === "TITRE DE CONGÉ ADMINISTRATIF") {
                        window.open(`../pdf/update.php?id=${$(this).attr('data-row')}`, "_blank");                   
                    }
                    else {
                        window.open(`../remplacement/update.php?pin=${$(this).attr('data-row')}`, '_blank');
                    };
                });

                $("#delete_btn").on("click", function () {
                    $.ajax({
                        url: "../useful/operations.php",
                        method: "post",
                        data: {id_trash: id_trash,
                               type_doc: note
                        },
                        success: function(response){
                            // $("#staticBackdrop").addClass("d-none");
                            $("#result").html(response);
                            $("#alert").addClass('alert-success');
                            $("#alert").removeClass('d-none');
                            setTimeout(() => {
                                $("#alert").addClass('d-none');
                            }, 5000);
                            
                        },
                        error: function (xhr, status, error) {
                            alert("An error occured: "+ error);
                        }
                    });

                });

                
            }

        });
    });
});