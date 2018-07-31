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
                <form method="POST" action="poop.php" style="position:relative; left:42%; top:38px; width:450px;">
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

            <div id="content" style="background-color: white; min-height: 300px;">
                <div style="width:100%; background-color:rgba(0,0,0,.6); position: relative; top: 50px;">
                    <?php
                    include_once 'functions.php';
                    $key = filter_input(INPUT_POST, 'search');
                    $action = filter_input(INPUT_POST, 'searchAction');
                    $results = search($key);
                    if ($action === 'Barbershop') {
                        foreach ($results as $x) {
                            ?>
                            <div style="width:50%; margin:auto; margin-bottom: 15px; border-bottom: 1.5px solid #ff442a; ">
                                <div><a href="profiles.php?barbershop-id=<?php echo $x['BarbershopID'];?>"><img style="width:50px;"src="uploads/barbershops/barbershopID<?php echo $x['BarbershopID']; ?>/profilepic.jpg"></a></div>
                                <div>Shop Name:<?php echo $x['BarbershopName']; ?></div>
                                <div>Address:<?php echo $x['Address']; ?></div>
                                <div>Phone:<?php echo $x['PhoneNumber']; ?></div>
                                <div>Rating:<?php echo $x['Rating']; ?> / 5</div>
                            </div>
                            <?php
//                            echo "<a href='profiles.php?barber-id={$x['BarbershopID']}' style='text-decoration:none; color:green;'>{$x['BarbershopName']}</a>";
//                            echo "<br/>";
                        }
                    } elseif ($action === 'Barber') {
                        foreach ($results as $x) {
//                            echo "<a href='profiles.php?barber-id={$x['BarberID']}' style='text-decoration:none; color:green;'>{$x['BarberName']}</a>";
//                            echo "<br/>";
                        }
                    }
                    ?>
                </div>
            </div> <!-- End of content div -->

        </div> <!--End of wrapper div --> 

    </body>
</html>






