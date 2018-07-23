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
                <div style="width:100%; background-color:rgba(0,0,0,.6); position: relative; top: 20px; border-bottom: 1.5px solid #ff442a">
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
                                echo 'success1';
                                echo "<div><img style='width:150px;' src='./uploads/barbershops/barbershopID$barbershopID/profilepic.jpg'/></div>";
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
                        } else{
                            echo 'failed3';
                        }
                    }
                    ?>
                </div>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>