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
                        if ($_SESSION['accType'] === 'admin') {
                            echo "<a href='admin-home.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        } elseif ($_SESSION['accType'] === 'customer') {
                            echo "<a href='settings.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        } else {
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
                <div style="width:100%; background-color:rgba(0,0,0,.6); position: relative; top: 20px; border-bottom: 1.5px solid #ff442a;">
                    <?php
                    $db = getDatabase();
                    $barbershopID = filter_input(INPUT_GET, 'barbershop-id');
                    $barberID = filter_input(INPUT_GET, 'barber-id');
                    if (isset($barbershopID)) {
                        $result = getBarberInfo();
                        if ($result !== false) {
                            $profileName = $result['Name'];
                            $profileAddress = $result['Address'];
                            $profileZip = $result['Zip'];
                            $profilePhone = $result['PhoneNumber'];
                            echo "<div style='margin-left: 5px; position: relative; top: 5px'><img style='width:150px;' src='./uploads/barbershops/barbershopID$barbershopID/profilepic.jpg'/></div>";
                            ?>
                            <div style="width:30%; position:relative; left:5px;">Shop Name: <?php echo $profileName ?></div>
                            <br/>
                            <div style="width:30%; position:relative; left:5px;">Address: <?php echo $profileAddress . ", " . $profileZip ?></div>
                            <div style="width:20%; position:relative; left:5px;">Phone: <?php echo $profilePhone ?></div>
                            <?php
                            $results = getShopInfo();
                            if ($results !== false) {
                                echo "<h3>Barbers</h3>";
                                foreach ($results as $x):
                                    echo "<a href='profiles.php?barber-id={$x['BarberID']}' style='text-decoration:none; color:white;'>" . $x['Name'] . "</a>";
                                    echo "<br/>";

                                endforeach;
                            } else {
                                echo 'This barbershop does not have barbers yet.';
                            }
                        } else {
                            echo 'failed2';
                        }
                    } elseif (isset($barberID)) {
                        $result = getBarberInfoProfiles();
                        if ($result !== false) {
                            $profileName = $result['Name'];
                            echo "<div style='margin-left: 5px; position: relative; top: 5px'><img style='width:150px;' src='./uploads/barbers/barberID$barberID/profilepic.jpg'/></div>";
                            ?>

                            <div style="width:30%; position:relative; left:5px;">Barber Name: <?php echo $profileName ?></div>
                            <div style="width:10%; position:relative; left:5px;"><a style="text-decoration: none; color: white;"href="appointment.php?barber-id=<?php echo $result['BarberID']; ?>">Book with me</a></div>
                            <br/>
                            <?php
                        } else {
                            echo 'failed3';
                        }
                    } elseif ($_SESSION['accType'] === 'customer') {
                        header("Location: settings.php");
                    }
                    ?>
                </div>
                <h2 style="margin-top: 20px;">Reviews</h2>
                <?php
                include_once 'dbconnect.php';
                $db = getDatabase();
                if (isset($barberID)) {
                    $result = getReviews();
                    if ($result !== false) {
                        $cnt = 1;
                        foreach ($result as $x):
                            ?>
                            <div style="width:100%; position:relative; border-bottom: .5px solid #ff442a; margin-bottom: 15px; background-color: rgba(0,0,0,.6);">
                                <div style="width:100px; position:relative;">Review <?php echo $cnt; ?> </div>
                                <div style="width:150px; position:relative;"><?php echo $x['ts'] ?></div>                                
                                <div style="width:100px; position:relative;">Rating: <?php echo $x['Rating'] ?> / 5</div>
                                <div style="width:80%; position:relative; border: .5px solid grey; left:19.5%; bottom:30px; min-height: 100px; background-color: white;"><?php echo $x['Review'] ?></div>
                            </div>
                            <?php
                            $cnt++;
                        endforeach;
                    } else {
                        echo 'No Reviews for this profile yet.';
                    }
                }
                ?>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>