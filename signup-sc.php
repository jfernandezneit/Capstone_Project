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
                        echo "<a href='personal-Profile.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                    } else {
                        echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                    }
                } else {
                    echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                }
                ?>
            </div><!-- End of nav div -->

            <div id="content" style="background-color: white; min-height: 300px;">
                <?php
                include_once 'dbconnect.php';

                $db = getDatabase();
                $action = filter_input(INPUT_GET, 'form-action');

                if (isset($action)) {
                    if (!empty($action)) {
                        if ($action === 'barbershop') {
                            include_once'form-barbershop.php';
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $shopName = filter_input(INPUT_POST, 'shopName');
                                $shopEmail = filter_input(INPUT_POST, 'shopEmail');
                                $check1 = checkShopRecs($shopName, $shopEmail);
                                if ($check1 === false) {
                                    $result = insShop();
                                    if ($result === true) {
                                        header("Location: index.php");
                                    } else {
                                        echo 'failed to create account';
                                    }
                                } else {
                                    echo 'Please choose another name or email for shop.';
                                }
                            }
                        } elseif ($action === 'barber') {
                            include_once'form-barber.php';
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $barbEmail = filter_input(INPUT_POST, 'barbEmail');
                                $barbAffiliation = filter_input(INPUT_POST, 'barbAffiliation');
                                $check1 = checkAffl($barbAffiliation);
                                if ($check1 === true) {
                                    $check2 = checkBarberEmail($barbEmail);
                                    if ($check2 === false) {
                                        $result = insBarb();
                                        if ($result === true) {
                                            header("Location: index.php");
                                        } else {
                                            echo 'failed to create account';
                                        }
                                    } else {
                                        echo "Please choose another email.";
                                    }
                                } else {
                                    echo 'This is not a valid barbershop name.';
                                }
                            }
                        } elseif ($action === 'customer') {
                            include_once'form-customer.php';
                            $result = insCust();
                            if ($result === true) {
                                header("Location: index.php");
                            } else {
                                echo 'failed to create account';
                            }
                        }
                    } else {
                        header("Location: signup.php");
                    }
                } else {
                    header("Location: signup.php");
                }
                ?>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>
