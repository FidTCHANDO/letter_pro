function makeInvisible(selection) {
    if (selection.hasClass("d-none")) {
        selection.removeClass("d-none");
    } else {
        selection.addClass("d-none");
    };
};

function formVisibile(visible, invisible) {
    makeInvisible(visible);
    makeInvisible(invisible);
}

// Variables for the boutons
$validation = $("#id_keep");
$enregister_btn = $("#enregistrer_btn");
$login_link = $("#login-btn");
$signup_link = $("#signup-btn");
$back = $("#back-btn");

// Form boxes variables
$login_b = $("#login-box");
$signup_b = $("#signup-box");


// Form variables
$titreconge_f = $("#conges_form");
$ampliation_f = $("#ampliation_form");
$login_f = $("#log_form");
$signup_f = $("#sig_form");


$(document).ready(function(){
    $signup_link.click(function(){
        formVisibile($login_b, $signup_b);
    });

    $login_link.click(function () {
        formVisibile($signup_b, $login_b);
    });

    // Validation
    $login_f.validate();
    $signup_f.validate({
        rules:{
            Cpassword:{
                equalTo: '#id_pass',
            }
        }
    });

    $agree = $("#id_agree");
    $sbmReg = $("#sbm-register");

    // Control the submit button for registration whether the terms and 
    // conditions are read and checked
    $agree.click(function () {
        if ($agree.is(":checked")) {
            $sbmReg.removeAttr("disabled");
        } else {
            $sbmReg.attr("disabled", "disabled");
        };
    });
    
    $("#log-btn").on("click", function (e) {
        $("#spinner-box").removeClass("invisible");
        if (document.getElementById("log_form").checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: 'action.php',
                method: 'post',
                data:$("#log_form").serialize()+'&action=login',
                success: function(data) {
                    if (data === "ok") {
                        window.location = "main.php";
                    }
                    else {
                        
                        $("#result").html(data);
                        // $("#alert").slideDown(5000).fadeOut(3000);
                        $("#alert").addClass('alert-success');
                        $("#alert").slideDown('slow');
                        setTimeout(() => {
                            $("#alert").fadeOut();
                        }, 5000);
                        $("#spinner-box").addClass("invisible");
                    }
                    
                }
            });
        }
        return true;
    });


    // Submit registration into the database
    $sbmReg.click(function (e) {
        $("#spinner-box2").removeClass("invisible");
        if (document.getElementById("sig_form").checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: 'action.php',
                method: 'post',
                data:$("#sig_form").serialize()+'&action=register',
                success: function(data) {
                    $("#result").html(data);
                    // $("#alert").slideDown(5000).fadeOut(3000);
                    $("#alert").addClass('alert-success');
                    $("#alert").slideDown('slow');
                    setTimeout(() => {
                        $("#alert").fadeOut();
                    }, 5000);
                    $("#spinner-box2").addClass("invisible");
                    $("#sig_form")[0].reset();
                }
            });
        }
        return true;
    });




    


    // TITRE DE CONGES ADMINISTRATIF
    $.validator.addMethod("greaterThan", function(value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) > new Date($(params).val());
        }
        return isNaN(value) && isNaN($(params).val()) || (Number(value) > Number($(params).val()));
    }, 'La date doit être supérieure à la date de début.');

    $titreconge_f.validate({
        rules : {
            sexe : {
                required : true
            },
            retourdate : {
                greaterThan: "#debutdateid"
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "sexe") {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    


    $enregister_btn.click(function (e) {
    //    var formulaire = $("#conges_form").serialize();
    //    alert(formulaire);
        e.preventDefault();
        
        $("#conges_form").valid();

        if ($("#conges_form").valid()) {
            $.ajax({
                url: 'action.php',
                method: 'post',
                data:$("#conges_form").serialize()+'&action=letter',
                success: function(data) {
                    if (data === "ok") {
                        // window.location = "profile.php";
                    }
                    else {
                        $("#result").html(data);
                        // $("#alert").slideDown(5000).fadeOut(3000);
                        $("#alert").addClass('alert-success');
                        $("#alert").removeClass('d-none');
                        setTimeout(() => {
                            $("#alert").addClass('d-none');
                        }, 7000);
                        // $("#spinner-box").addClass("invisible");
                        $("#conges_form")[0].reset();
                        $("#generator_ampl_form")[0].reset();
                        clearInput();
                    }
                    
                }
            });
        }
        else {
            // $("#conges_form").valid();
            alert("not good");
        }
    });

});