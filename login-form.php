<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>BarberStop website</title>
        <link rel="stylesheet" type="text/css" href="./style.css"/>
    </head>
    <body>
        <div id="wrapper">
            <div id="nav">
                <a id="btn-home" href="index.php" style="text-decoration:none; width:200px;"><div style="color:white;">Barber<span style="color:#ff442a;">Stop</span></div></a>
                <?php
                include_once 'login.php';
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        echo "<a href='logout.php' style='position:relative;text-decoration:none; color:lightgrey; left: 877px; top:25px'>Log Out</a>";
                        echo "<a href='persProfile.php' style='position:relative; left:887px; top:27px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                    } else {
                        echo "<div style='width:125px; position: relative; left:875px; top:45px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                    }
                } else {
                    echo "<div style='width:125px; position: relative; left:875px; top:45px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                }
                ?>
            </div><!-- End of nav div -->

            <div id="content" style="background-color: white; min-height: 300px;">
                <div style="width:50%; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a; margin:auto;">
                    <div style="position:relative; left:110px;">
                        <form method="POST" action="#">
                            <label for="loginUsername">Username: </label>
                            <input id="loginUsername" type="email" name="loginUsername">
                            <br/>
                            <br/>
                            <label for="loginPass">Password: </label>
                            <input id="loginPass" type="password" name="loginPass">
                            <br/>
                            <br/>
                            <label><b>What type of account ?</b></label>
                            <br/>
                            <br/>
                            <label for="loginAcc1">Barbershop</label>
                            <input id="loginAcc1"type="radio" name="loginAcc" value="barbershop">
                            <label for="loginAcc2">Barber</label>
                            <input id="loginAcc2"type="radio" name="loginAcc" value="barber">
                            <label for="loginAcc3">User</label>
                            <input id="loginAcc3"type="radio" name="loginAcc" value="customer">
                            <br/>
                            <br/>
                            <a href="signup.php">Don't have an account?</a>
                            <br/>
                            <br/>
                            <input type="submit" name="login" value="Login">
                        </form>
                    </div>
                </div>
                <?php
                include_once 'login.php';
                ?>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>

