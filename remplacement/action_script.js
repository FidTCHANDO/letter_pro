$sender = $("#enregistrer_btn");
// function convertDate(value) {
//     const [month, day, year] = value.split("/");
//     return `${year}-${month.padStart(2,0)}-${day.padStart(2,0)}`;
// };

$(document).ready(function(){
    // TITRE DE CONGES ADMINISTRATIF
    $.validator.addMethod("greatEqThan", function(value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) >= new Date($(params).val());
        }
        return isNaN(value) && isNaN($(params).val()) || (Number(value) >= Number($(params).val()));
    }, 'La date doit être supérieure ou égale à la date de début.');

    $("#replace_form").validate({
        rules : {
            datefin : {
                greatEqThan: "#debutdateid"
            }
        }
    });
    $("#debutdateid").change(function(e){
        e.preventDefault();
        $("#datefinid").attr("min", $("#debutdateid").val());
        // alert($("#debutdateid").val());
    });

    $("#budget").change(function () {
        if ($(this).val() != "Budget National") {
            $("#divlignebn").addClass("d-none");
            $("#divgestion").addClass("d-none");
            $("#divintitule_ligne").addClass("d-none");
            // $("#lignebudgetaire").attr("required", false);
            if ($(this).val() === "Autre") {
                $("#other").removeClass("d-none");
                // $("#divintitule_ligne").addClass("d-none");
                $("#othersource").attr("required", true);
            } else {
                $("#othersource").attr("required", false);
                $("#other").addClass("d-none");
            };
        }
        else {
            $("#divlignebn").removeClass("d-none");
            $("#divintitule_ligne").removeClass("d-none");
            $("#divgestion").removeClass("d-none");
            // $("#lignebudgetaire").attr("required", true);
            $("#other").addClass("d-none");
        }
    });

    $sender.on("click", function (e) {
        e.preventDefault();

        $("#replace_form").valid();

        if ($("#replace_form").valid()) {
            // alert($("#replace_form").serialize()+'&action=replacement');
            $.ajax({
                url: '../action.php',
                method: 'post',
                data: $("#replace_form").serialize()+'&action=replacement',
                success: function (data) {
                    if (data === "ok") {
                        alert("No saving");
                    }
                    else {
                        $("#result").html(data);
                        // $("#alert").slideDown(5000).fadeOut(3000);
                        $("#alert").addClass('alert-success');
                        $("#alert").removeClass('d-none');
                        setTimeout(() => {
                            $("#alert").addClass('d-none');
                        }, 7000);
                    }
                },
                complete: function () {
                    // $("#replace_form")[0].reset();
                }
            });
        }

        
    });
});