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
                        echo "<a href='profile.php' style='position:relative; left:887px; top:27px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                    } else {
                        echo "<div style='width:125px; position: relative; left:875px; top:45px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                    }
                } else {
                    echo "<div style='width:125px; position: relative; left:875px; top:45px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                }
                ?>
            </div><!-- End of nav div -->

            <div id="content" style="background-color: white; min-height: 300px;">
                <?php
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        include_once 'dbconnect.php';
                        $db = getDatabase();
                        ?>  
                        <div style="width:100%; background-color:rgba(0,0,0,.6); height:200px; position:relative; top:20px;">
                            <?php
                            if ($_SESSION['accType'] === 'barbershop') {
                                $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopID = {$_SESSION['user-id']}");
                                $stmt2 = $db->prepare("SELECT * FROM barbers WHERE BarbershopID = {$_SESSION['user-id']}");
                                if ($stmt->execute() > 0 && $stmt->rowCount() > 0 && $stmt2->execute() > 0 && $stmt2->rowCount() > 0) {
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $results = $stmt2->fetchAll(PDO:: FETCH_ASSOC);
                                    $profileName = $result['BarbershopName'];
                                    $profileAddress = $result['Address'];
                                    $profileZip = $result['Zip'];
                                    $profilePhone = $result['PhoneNumber'];
                                    $profileRating = $result['Rating'];
                                    $barbList = array();
                                    foreach ($results as $x):
                                        echo "<a href='profile.php?barber-id={$x['BarberID']}'>" . $x['BarberName'] . "</a>";

                                    endforeach;
                                    print_r($barbList);
                                    die('herher');
                                    //bring up a list of all the barbers affiliated with the barbershops
                                }
                                echo "<div><img style='width:150px;' src='./uploads/barbershops/barbershopID{$_SESSION['user-id']}/profilepic.jpg'/></div>";
                            } elseif ($_SESSION['accType'] === 'barber') {
                                $stmt = $db->prepare("SELECT * FROM barber WHERE BarberID = {$_SESSION['user-id']}");
                                if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $profileName = $result['BarberName'];
                                    $profileRating = $result['Rating'];
                                    //Then I'm going to pull in the barbershop the barber is affiliated with
                                }
                                echo "<div><img style='width:150px;' src='./uploads/barbers/barberID{$_SESSION['user-id']}/profilepic.jpg'/></div>";
                            } elseif ($_SESSION['accType'] === 'customer') {
                                header("Location: settings.php");
                            } else {
                                $barbershopID = filter_input(INPUT_GET, 'barbershop-id');
                                $barberID = filter_input(INPUT_GET, 'barber-id');
                                if (isset($barbershopID)) {
                                    $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopID = '$barbershopID'");
                                    $stmt2 = $db->prepare("SELECT * FROM barbers WHERE BarbershopID = '$barbershopID'");
                                    if ($stmt->execute() > 0 && $stmt->rowCount() > 0 && $stmt2->execute() > 0 && $stmt2->rowCount() > 0) {
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $results = $stmt2->fetchAll(PDO:: FETCH_ASSOC);
                                        $profileName = $result['BarbershopName'];
                                        $profileAddress = $result['Address'];
                                        $profileZip = $result['Zip'];
                                        $profilePhone = $result['PhoneNumber'];
                                        $profileRating = $result['Rating'];
                                        $barbList = array();
                                        foreach ($results as $x):
                                            echo "<a href='profile.php?barber-id={$x['BarberID']}'>" . $x['BarberName'] . "</a>";

                                        endforeach;
                                        echo "<div><img style='width:150px;' src='./uploads/barbershops/barbershopID$barbershopID/profilepic.jpg'/></div>";
                                    } elseif (isset($barberID)) {
                                        $stmt = $db->prepare("SELECT * FROM barber WHERE BarberID = '$barberID'");
                                        if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $profileName = $result['BarberName'];
                                            $profileRating = $result['Rating'];
                                            echo 'we did it hooray';
                                            //Then I'm going to pull in the barbershop the barber is affiliated with
                                        }
                                        echo "<div><img style='width:150px;' src='./uploads/barbers/barberID$barberID/profilepic.jpg'/></div>";
                                    }
                                }
                                ?>

                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>
