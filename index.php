<?php
  ini_set('error_reporting', E_ALL);
  
  // TODO :: MOVE ALL INCLUDE CLASSES TO NAMESPACE
  include 'model/models.php';
  include 'controller/user.controller.php';

  $userHandle = new Users();
  $userHandle->processLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--  ZMDI Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="include/css/index.css">
    <!-- Roboto Font CDN -->
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    
    <title>Trax</title>
</head>
<body>
    <div class="container-login">
        <div id="loginForm" class="login-section">
            <form id="login-form" name="login" method="post" action="" class="validate-form login-form">
                <span class="login-form-logo"><i class="zmdi zmdi-landscape"></i></span>
                <span class="login-title">Log In</span>
                <div class="wrap-input validate-input" data-validate="Enter username">
                    <i class="zmdi zmdi-account icon"></i>
                    <input class="input-field" id="username" type="text" name="username" placeholder="Username" required>
                </div>
                <div class="wrap-input validate-input" data-validate="Enter password">
                    <i class="zmdi zmdi-lock icon"></i>
                    <input class="input-field" id="password" type="password" name="password" placeholder="Password">
                </div>
                <div id="login-error-message" class="login-error"></div>
                <div class="container-login-button">
                    <button id="login" name="login" type="submit" class="login-button btn-lg">Submit</button>
                </div>    
                <div class="text-center password-footer">
                    <a href="#" class="link-text footer-link">Forgot Password</a>
                    <a href="#" class="link-text register">Register</a>
                </div>
            </form>
        </div>
        <!-- PASSWORD RESET FORM -->
        <div id="resetForm" class="login-section" style="display:none;">
            <form id="resetPassword" name="resetPassword" method="post" action="#" class="validate-form login-form">
                <span class="login-form-logo"><i class="zmdi zmdi-landscape"></i></span>
                <span class="login-title">Reset Password</span>
                <div class="wrap-input validate-input" data-validate="Enter username">
                    <i class="zmdi zmdi-account icon"></i>
                    <input class="input-field" type="email" name="email" id="email" placeholder="E-mail">
                </div>
                <div id="login-error-message" class="login-error"></div>
                <div class="container-login-button">
                    <button id="resetPassword" name="resetPassword" type="submit" class="login-button btn-lg">Submit</button>
                </div>
                <div class="text-center password-footer">
                    <a href="#" class="link-text footer-link">Login</a>
                    <a href="#" class="link-text register">Register</a>
                </div>
            </form>
        </div>
        <!-- NEW USER REGISTRATION FORM -->
        <div id="registrationForm" class="login-section" style="display:none;">
            <form id="login-form" action="#" class="validate-form login-form">
                <span class="login-form-logo"><i class="zmdi zmdi-landscape"></i></span>
                <span class="login-title">Register</span>
                <div class="wrap-input validate-input" data-validate="Enter username">
                    <i class="zmdi zmdi-account icon"></i>
                    <input class="input-field" id="username" type="text" name="username" placeholder="Username" required>
                </div>
                <div class="wrap-input validate-input" data-validate="Enter password">
                    <i class="zmdi zmdi-lock icon"></i>
                    <input class="input-field" id="password" type="password" name="password" placeholder="Password">
                </div>
                <div id="login-error-message" class="login-error"></div>
                <div class="container-login-button">
                    <button id="submit" type="submit" class="login-button btn-lg">Submit</button>
                </div>    
                <div class="text-center password-footer">
                    <a href="#" class="link-text footer-link">Forgot Password</a>
                    <a href="#" class="link-text register">Register</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="include/js/index.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>