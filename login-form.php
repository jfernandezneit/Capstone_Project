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
                <a id="btn-home" href="index.php" style="text-decoration:none; width:250px;"><div style="color:white; width:250px">Barber<span style="color:#ff442a;">Stop</span></div></a>
                <form method="GET" action="results-search.php" style="position:relative; left:42%; top:38px; width:450px;">
                    <input type="text" name="search">
                    <input id="action1" type="radio" value="Barbershop" name="searchAction">
                    <label for="action1">Barbershop</label>
                    <input id="action2" type="radio" value="Barber" name="searchAction">
                    <label for="action2">Barber</label>
                    <input type="submit" name="submit">
                </form>
                <?php
                include_once 'login.php';
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        echo "<a href='logout.php' style='position:relative;text-decoration:none; color:lightgrey; left: 877px;'>Log Out</a>";
                        if($_SESSION['accType'] === 'admin') {
                            echo "<a href='admin-home.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        }elseif($_SESSION['accType'] === 'customer'){
                            echo "<a href='settings.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        } else{
                            echo "<a href='personal-Profile.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        }
                    } else {
                        echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                    }
                } else {
                    echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
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
                            <a href="signup.php" style="text-decoration: none; color:#ff442a;">Don't have an account <span style="color:black;"></a>
                            <br/>
                            <br/>
                            <a href="admin-login-form.php" style="text-decoration: none; color:white;">Admin Login</a>
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

