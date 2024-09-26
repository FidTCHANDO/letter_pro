<?php
    session_start();
    if (isset($_SESSION["username"])) {
        header("location:main.php");
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link rel="stylesheet" href="styles/mystyle.css">
    
    <title>LetterPro: Connexion</title>
</head>
<body class="bg-dark">
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="alert" id="alert">
                    <span id="result"></span>
                </div>
            </div>
        </div>

        <!-- Login -->

        <div class="row">
            <div class="col-lg-4 offset-lg-4 bg-light card-body rounded border-top-primary" id="login-box">
                <div class="d-flex justify-content-center invisible" id="spinner-box" >
                    <div class="spinner-border" role="status">   
                    </div>
                </div>

                <h2 class="text-center">LOGIN</h2>
                <form action="" method="post" role="form" id="log_form">
                    <div class="form-group ">
                        <label for="id_loguser">Username or email</label>
                        <input class="form-control" type="text" name="logusername" value = "<?php if (isset($_COOKIE["username"])) {echo $_COOKIE["username"];} ?>" id="id_loguser" required>
                        <!-- <small class="form-text text-muted">Type your username here</small> -->
                    </div>
                    <div class="form-group">
                        <label for="id_logpass">Password</label>
                        <input type="password" name="logpassword" value = "<?php if (isset($_COOKIE["password"])) {echo $_COOKIE["password"];} ?>" id="id_logpass" class="form-control" required>
                        <!-- <small class="form-text text-muted">Type your password here</small> -->
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="keep" id="id_keep" <?php if (isset($_COOKIE["username"])) {?> checked<?php } ?> class="form-check-input">
                        <label for="id_keep" class="form-check-label">Remember me</label>
                        <a href="#" class="float-right" id="forgot-link">Forgot password</a>
                    </div>
                    
                    <div class="form-group mt-1">
                        <input type="submit" value="Connexion" id="log-btn" class="btn btn-block btn-primary">
                    </div>
                </form>
                <div class="py-2">
                    Don't have an account ? Sign up <a href="#" id="signup-btn">here</a> for free.
                </div>
            </div>
        </div>

        <!-- Registration -->

        <div class="row">
            <div class="col-lg-4 offset-lg-4 bg-light rounded d-none" id="signup-box">
                <div class="d-flex justify-content-center invisible" id="spinner-box2" >
                    <div class="spinner-border" role="status">   
                    </div>
                </div>
                <h2 class="text-center">SIGN UP</h2>
                <form action="action.php" method="post" id="sig_form">
                    <div class="form-group">
                        <!-- <label for="id_fullname">Full name</label> -->
                        <input class="form-control" type="text"  minlength="3" placeholder="Name" name="Fullname" id="id_fullname" required>
                        <!-- <small class="form-text text-muted">Type your username here</small> -->
                    </div>
                    <div class="form-group">
                        <!-- <label for="id_user">Username</label> -->
                        <input class="form-control" type="text" name="Username" minlength="3" placeholder="Username" id="id_user" required>
                        <!-- <small class="form-text text-muted">Type your username here</small> -->
                    </div>
                    <div class="form-group">
                        <!-- <label for="id_pass">Password</label> -->
                        <input type="password" name="Password" id="id_pass" minlength="1" placeholder="Password" class="form-control" required>
                        <!-- <small class="form-text text-muted">Type your password here</small> -->
                    </div>
                    <div class="form-group">
                        <!-- <label for="id_cpass">Confirm password</label> -->
                        <input type="password" name="Cpassword" id="id_cpass" minlength="1" placeholder="Confirm password" class="form-control" required>
                        <!-- <small class="form-text text-muted">Type your password here</small> -->
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="agree" id="id_agree" class="form-check-input">
                        <label for="id_agree" class="form-check-label">Agree to the <a href="#">terms and conditions</a></label>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Register" id="sbm-register" class="btn btn-block btn-primary" disabled>
                    </div>
                </form>
                <div class="py-2">
                    Already have an account ? <a href="#" id="login-btn">Login here</a>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <script src="styles/jquery.min.js"></script>
    <script src="styles/popper.min.js"></script>
    <script src="styles/bootstrap.js"></script>
    <script src="styles/myjquery.js"></script>
    <script src="styles/jquery.validate.min.js"></script>
</footer>
</html>