<html>
    <head>
        <meta charset="UTF-8">
        <title>BarberStop website</title>
        <link rel="stylesheet" type="text/css" href="./style.css"/>
    </head>
    <body>

        <?php
        include_once 'functions.php';

        if (basename($_SERVER['PHP_SELF']) === 'settings.php') {
            $result = getShopInfo();
            if ($result === false) {
                echo "Please sign in.";
            }
        }
        ?>
        <div id="content" style="background-color: white; min-height: 500px;">
            <div style="width:100%; height: px; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a">
                <form method="POST" action="#" enctype="multipart/form-data">
                    <?php if (basename($_SERVER['PHP_SELF']) === 'settings.php') { ?>
                        <label for="shopName">Barbershop Name: </label>
                        <input id="shopName" type="text" name="shopName" value="<?php echo $result['BarbershopName']; ?>">
                        <br/>
                        <br/>
                        <label for="shopUsername">Email (will be your username): </label>
                        <input id="shopUsername" type="email" name="shopUsername" value="<?php echo $result['Username']; ?>">
                        <br/>
                        <br/>
                        <label for="shopAddress">Address</label>
                        <input id="shopAddress" type="text" name="shopAddress" value="<?php echo $result['Address']; ?>">
                        <br/>
                        <br/>
                        <label for="shopZip">Zip Code:  </label>
                        <input id="shopZip" type="text" name="shopZip" value="<?php echo $result['Zip']; ?>">
                        <br/>
                        <br/>
                        <label for="shopPhone">Phone: </label>
                        <input id="shopPhone" type="text" name="shopPhone" value="<?php echo $result['PhoneNumber']; ?>">
                        <br/>
                        <br/>
                        <label for="shopPic">Upload Image:</label>
                        <input id="shopPic" name="shopPic" type="file">
                        <br/>
                        <br/>
                        <input type="submit" value="Save Changes" name="submit">
                    <?php } else { ?>
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
                        <input type="submit" value="Create Account" name="submit">
                    <?php } ?>

                </form>
            </div>

        </div><!-- End of content div -->


    </body>
</html>



