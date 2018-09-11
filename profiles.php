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
                <div style="width:100%; background-color:rgba(0,0,0,.6); position: relative; top: 20px; border-bottom: 1.5px solid #ff442a;">
                    <?php
                    $db = getDatabase();
                    $barbershopID = filter_input(INPUT_GET, 'barbershop-id');
                    $barberID = filter_input(INPUT_GET, 'barber-id');
                    if (isset($barbershopID)) {
                        $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopID = '$barbershopID'");
                        if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $profileName = $result['BarbershopName'];
                            $profileAddress = $result['Address'];
                            $profileZip = $result['Zip'];
                            $profilePhone = $result['PhoneNumber'];
                            $profileRating = $result['Rating'];
                            echo "<div style='margin-left: 5px; position: relative; top: 5px'><img style='width:150px;' src='./uploads/barbershops/barbershopID$barbershopID/profilepic.jpg'/></div>";
                            ?>
                            <div style="width:30%; position:relative; left:5px;">Shop Name: <?php echo $profileName ?></div>
                            <div style="width:10%; position:relative; left:5px;">Rating: <?php echo $profileRating ?> / 5</div>
                            <br/>
                            <div style="width:30%; position:relative; left:5px;">Address: <?php echo $profileAddress . ", " . $profileZip ?></div>
                            <div style="width:20%; position:relative; left:5px;">Phone: <?php echo $profilePhone ?></div>
                            <?php
                            $stmt2 = $db->prepare("SELECT * FROM barbers WHERE BarbershopID = '$barbershopID'");
                            if ($stmt2->execute() > 0 && $stmt2->rowCount() > 0) {
                                $results = $stmt2->fetchAll(PDO:: FETCH_ASSOC);
                                echo "<h3>Barbers</h3>";
                                foreach ($results as $x):
                                    echo "<a href='profiles.php?barber-id={$x['BarberID']}' style='text-decoration:none; color:white;'>" . $x['BarberName'] . "</a>";
                                    echo "<br/>";

                                endforeach;
                            } else {
                                echo 'This barbershop does not have barbers yet.';
                            }
                        } else {
                            echo 'failed2';
                        }
                    } elseif (isset($barberID)) {
                        $stmt = $db->prepare("SELECT * FROM barbers WHERE BarberID = '$barberID'");
                        if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $profileName = $result['BarberName'];
                            $profileRating = $result['Rating'];
                            echo "<div style='margin-left: 5px; position: relative; top: 5px'><img style='width:150px;' src='./uploads/barbers/barberID$barberID/profilepic.jpg'/></div>";
                            ?>

                            <div style="width:30%; position:relative; left:5px;">Barber Name: <?php echo $profileName ?></div>
                            <div style="width:10%; position:relative; left:5px;">Rating: <?php echo $profileRating ?> / 5</div>
                            <div style="width:10%; position:relative; left:5px;"><a style="text-decoration: none; color: white;"href="appointment.php?barber-id=<?php echo $result['BarberID'];?>">Book with me</a></div>
                            <br/>
                            <?php
                        } else {
                            echo 'failed3';
                        }
                    }
                    ?>
                </div>
                <h2 style="margin-top: 20px;">Reviews</h2>
                <?php
                include_once 'dbconnect.php';
                $db = getDatabase();
                if (isset($barbershopID)) {
                    $stmt = $db->prepare("SELECT * FROM shopreviews WHERE BarbershopID = '$barbershopID'");
                    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $x):
                            ?>
                            <div style="width:100%; position:relative; border-bottom: .5px solid #ff442a; background-color: rgba(0,0,0,.6);">
                                <div style="width:100px; position:relative;">Reviewer: <?php echo $x['Reviewer'] ?></div>
                                <div style="width:150px; position:relative;"><?php echo $x['ts'] ?></div>
                                <div style="width:80%; position:relative; border: .5px solid grey; left:19.5%; bottom:50.5px; min-height: 100px; background-color: white;"><?php echo $x['Review'] ?></div>
                            </div>
                            <?php
                        endforeach;
                    } else {
                        echo "There are no reviews for this barbershop yet.";
                    }
                } elseif (isset($barberID)) {
                    $stmt = $db->prepare("SELECT * FROM barbereviews WHERE BarberID = '$barberID'");
                    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $x):
                            ?>
                            <div style="width:100%; position:relative; border-bottom: .5px solid #ff442a; margin-bottom: 15px; background-color: rgba(0,0,0,.6);">
                                <div style="width:100px; position:relative;">Reviewer: <?php echo $x['Reviewer'] ?></div>
                                <div style="width:150px; position:relative;"><?php echo $x['ts'] ?></div>
                                <div style="width:80%; position:relative; border: .5px solid grey; left:19.5%; bottom:50.5px; min-height: 100px; background-color: white;"><?php echo $x['Review'] ?></div>
                            </div>
                            <?php
                        endforeach;
                    } else {
                        echo 'No Reviews for this profile yet.';
                    }
                } elseif ($_SESSION['accType'] === 'customer') {
                    header("Location: settings.php");
                }
                ?>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>