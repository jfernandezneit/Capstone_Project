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
                        echo "<a href='persProfile.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                    } else {
                        echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                    }
                } else {
                    echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                }
                ?>
            </div><!-- End of nav div -->

            <div id="content" style="background-color: white; min-height: 400px;">
                <?php
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        if ($_SESSION['accType'] === 'barbershop') {
                            include_once 'functions.php';
                            include_once 'dbconnect.php';
                            $result = getShopInfo();
                            if ($result !== false) {
                                ?>
                                <div style="width:75%; margin:auto;">
                                    <div>

                                        <div style="font-size:22px;"><b>Current info</b></div>
                                        <hr>
                                        <label>Shop Name: <b><?php echo $result['BarbershopName'] ?></b></label>
                                        <br/>
                                        <label>Shop Username: <b><?php echo $result['Username'] ?></b></label>
                                        <br/>
                                        <label>Shop Address: <b><?php echo $result['Address'] ?></b></label>
                                        <br/>
                                        <label>Shop Zip: <b><?php echo $result['Zip'] ?></b></label>
                                        <br/>
                                        <label>Shop Number: <b><?php echo $result['PhoneNumber'] ?></b></label>
                                        <br/>
                                        <div>Profile Picture:  <img style="width:150px;" src="./uploads/barbershops/barbershopID<?php echo $result['BarbershopID'] ?>/profilepic.jpg"/></div>
                                        <br/>
                                        <div style="font-size:22px;"><b>Change info</b></div>
                                        <hr/>
                                        <?php
                                        include_once'form-barbershop.php';
                                        ?>

                                    </div>
                                </div>
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                    $result = insShop();
                                    if ($result === true){
                                        echo 'success';
                                    }else {
                                        echo 'failed';
                                    }
                                }
                            } else {
                                echo "You need to sign in.";
                            }
                        } elseif ($_SESSION['accType'] === 'barber') {
                            
                        } elseif ($_SESSION['accType'] === 'customer') {
                            
                        } else {
                            echo "You are not signed in. Please sign in.";
                        }
                    }
                } //End of the isset for authentication
                ?>
            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>


