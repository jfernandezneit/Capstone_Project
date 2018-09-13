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
        <link rel="stylesheet" type="text/css" href="style.css">
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
                <?php
                include_once 'dbconnect.php';
                $barbershopName = filter_input(INPUT_GET,'barbershop-name');
                $results = getBarbers();
                if ($results !== false) {
                    ?>
                    <div style="font-size: 25px; margin:auto; position:relative; top:20px; width:200px;">Barbershop:<?php echo $barbershopName; ?></div>
                    <table style="margin:auto; border-bottom: 1.5px solid #ff442a; background-color: rgba(0,0,0,.6); position:relative; top:20px; width:277px;">
                        <tr style="border-bottom: .5px solid lightgray;">
                            <th style="text-align:center;">Name</th>
                            <th style="text-align:center;">Book</th>
                        </tr>
                        <?php foreach ($results as $index): ?>
                            <tr>
                                <td style="text-align:center;"><a style="text-decoration:none; color:lightgrey;" href="personal-Profile.php?barber-id=<?php echo$index['BarberID'] ?>"><?php echo $index['Name'] ?></a></td>
                                <td style="text-align:center;"><a style="text-decoration:none; color:lightgrey;" href="appointment.php?barber-id=<?php echo $index['BarberID'] ?>&barbershop-id=<?php echo $index['BarbershopID'] ?>">Book Now</a></td>
                            </tr>
                            <?php
                        endforeach;
                    } else {
                        echo "This barbershop does not yet have any barbers.";
                    }
                    ?>
                </table>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>
