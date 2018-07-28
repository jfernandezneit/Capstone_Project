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
                include_once 'dbconnect.php';
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
                <div style="width:100%; background-color:rgba(0,0,0,.6); position: relative; top: 20px; ;">
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
                            echo "<div><img style='width:150px;' src='./uploads/barbershops/barbershopID$barbershopID/profilepic.jpg'/></div>";
                            ?>
                            <div style="width:30%; position:relative; left:5px;">Shop Name: <?php echo $profileName ?></div>
                            <div style="width:10%; position:relative; left:5px;">Rating: <?php echo $profileRating ?> / 5</div>
                            <br/>
                            <div style="width:30%; position:relative; left:5px;">Address: <?php echo $profileAddress . ", " . $profileZip ?></div>
                            <div style="width:20%; position:relative; left:5px;">Phone: <?php echo $profilePhone ?></div>
                            <div style="width:100px; font-size: 18px; position:relative; left:93.5%; bottom:180px;"><a href="settings.php" style="text-decoration: none; color:white;">Settings</a></div>
                            <br/>
                            <?php
                            $stmt2 = $db->prepare("SELECT * FROM barbers WHERE BarbershopID = '$barbershopID'");
                            if ($stmt2->execute() > 0 && $stmt2->rowCount() > 0) {
                                $results = $stmt2->fetchAll(PDO:: FETCH_ASSOC);
                                foreach ($results as $x):
                                    echo "<a href='profiles.php?barber-id={$x['BarberID']}'>" . $x['BarberName'] . "</a>";

                                endforeach;                               
                            } else {
                                echo 'failed1';
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
                            echo "<div><img style='width:150px;' src='./uploads/barbers/barberID$barberID/profilepic.jpg'/></div>";
                            ?>

                            <div style="width:30%; position:relative; left:5px;">Barber Name: <?php echo $profileName ?></div>
                            <div style="width:10%; position:relative; left:5px;">Rating: <?php echo $profileRating ?> / 5</div>
                            <div style="width:100px; font-size: 18px; position:relative; left:93.5%; bottom:180px;"><a href="settings.php" style="text-decoration: none; color:white;">Settings</a></div>
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
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        include_once 'dbconnect.php';
                        $db = getDatabase();
                        if (isset($barbershopID)) {
                            $stmt = $db->prepare("SELECT * FROM shopreviews WHERE BarbershopID = '$barbershopID'");
                            if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $x):
                                    $temp = $x['ts'];
                                    $date = date("m-d-Y", $temp);
                                    ?>
                                    <div style="width:100%; position:relative; border-bottom: .5px solid #ff442a; background-color: rgba(0,0,0,.6);">
                                        <div style="width:100px; position:relative;">Reviewer: <?php echo $x['Reviewer'] ?></div>
                                        <div style="width:150px; position:relative;"><?php echo $date ?></div>
                                        <div style="width:100px; position:relative;">Rating: <?php echo $x['Rating'] ?> / 5</div>
                                        <div style="width:80%; position:relative; border: .5px solid grey; left:19.5%; bottom:50.5px; min-height: 100px; background-color: white;"><?php echo $x['Review'] ?></div>
                                    </div>
                                    <?php
                                endforeach;
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
                                        <div style="width:100px; position:relative;">Rating: <?php echo $x['Rating'] ?> / 5</div>
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
                    }
                }
                ?>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>