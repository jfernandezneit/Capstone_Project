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

            <div id="content" style="background-color: white; min-height: 500px;">
                <div style="width:100%; height: px; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        <label for="shopName">Barbershop Name: </label>
                        <input id="shopName" type="text" name="shopName">
                        <br/>
                        <br/>
                        <label for="shopUsername">Email (will be your username): </label>
                        <input id="shopUsername" type="email" name="shopUsername">
                        <br/>
                        <br/>
                        <label for="shopPass">Password: </label>
                        <input id="shopPass" type="password" name="shopPass">
                        <br/>
                        <br/>
                        <label for="shopAddress">Address</label>
                        <input id="shopAddress" type="text" name="shopAddress">
                        <br/>
                        <br/>
                        <label for="shopZip">Zip Code:  </label>
                        <input id="shopZip" type="text" name="shopZip">
                        <br/>
                        <br/>
                        <label for="shopPhone">Phone: </label>
                        <input id="shopPhone" type="text" name="shopPhone">
                        <br/>
                        <br/>
                        <label for="shopPic">Upload Image:</label>
                        <input id="shopPic" name="shopPic" type="file">
                        <br/>
                        <br/>
                        <?php if (basename($_SERVER['PHP_SELF']) === 'settings.php') {
                            ?>
                            <input type="submit" value="Save Changes" name="submit">
                            <?php } else {
                            ?>
                            <input type="submit" value="Create Account" name="submit">
                            <?php
                        }
                        ?>

                    </form>
                </div>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>



