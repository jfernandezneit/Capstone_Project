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
                <div style="width:100%; height: 200px; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        <label for="custUsername">Email (will be your username): </label>
                        <input id="custUsername" type="email" name="custUsername">
                        <br/>
                        <br/>
                        <label for="custPass">Password: </label>
                        <input id="custPass" type="password" name="custPass">
                        <br/>
                        <br/>
                        <label for="custPhone">Phone Number: </label>
                        <input id="custPhone" type="text" name="custPhone">
                        <br/>
                        <br/>
                        <label for="custPic">Upload Image:</label>
                        <input id="custPic" name="custPic" type="file">
                        <br/>
                        <br/>     
                        <input type="submit" value="Create Account">
                        <input type="hidden" value="customer" name="form-action">
                    </form>
                    <?php include_once 'signup-sc.php'; ?>
                </div>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>
