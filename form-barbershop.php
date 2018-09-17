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
        <div id="content" style="background-color: white; min-height: 350px;">
            <div style="width:100%; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a;" >
                <form method="POST" action="#" enctype="multipart/form-data">
                    <?php if (basename($_SERVER['PHP_SELF']) === 'settings.php') { ?>
                        <label for="shopName" style="margin-left:5px;">Shop Name: </label>
                        <input id="shopName" type="text" name="shopName" style="margin-top:2.5px;" value="<?php echo $result['Name']; ?>">
                        <br/>
                        <br/>
                        <label for="shopEmail" style="margin-left:5px;">Email: </label>
                        <input id="shopEmail" type="email" name="shopEmail" value="<?php echo $result['Email']; ?>">
                        <br/>
                        <br/>
                        <label for="shopAddress" style="margin-left:5px;">Address: </label>
                        <input id="shopAddress" type="text" name="shopAddress" value="<?php echo $result['Address']; ?>">
                        <br/>
                        <br/>
                        <label for="shopZip" style="margin-left:5px;">Zip Code: </label>
                        <input id="shopZip" type="text" name="shopZip" value="<?php echo $result['Zip']; ?>">
                        <br/>
                        <br/>
                        <label for="shopPhone" style="margin-left:5px;">Phone: </label>
                        <input id="shopPhone" type="text" name="shopPhone" value="<?php echo $result['PhoneNumber']; ?>">
                        <br/>
                        <br/>
                                              
                        <input type="submit" value="Save Changes" name="UpdateBarbershop" style="margin-left:5px; margin-bottom: px;">
                    <?php } else { ?>

                        <label for="shopName" style="margin-left:5px;">Shop Name: </label>
                        <input id="shopName" type="text" name="shopName" style="margin-top:2.5px;">
                        <br/>
                        <br/>
                        <label for="shopEmail" style="margin-left:5px;">Email: </label>
                        <input id="shopEmail" type="email" name="shopEmail" style="margin-left:36px;">
                        <br/>
                        <br/>
                        <label for="shopPass" style="margin-left:5px;">Password: </label>
                        <input id="shopPass" type="password" name="shopPass" style="margin-left:12px;">
                        <br/>
                        <br/>
                        <label for="shopAddress" style="margin-left:5px;">Address: </label>
                        <input id="shopAddress" type="text" name="shopAddress" style="margin-left:19px;">
                        <br/>
                        <br/>
                        <label for="shopZip" style="margin-left:5px;">Zip Code:  </label>
                        <input id="shopZip" type="text" name="shopZip" style="margin-left:10px;">
                        <br/>
                        <br/>
                        <label for="shopPhone" style="margin-left:5px;">Phone: </label>
                        <input id="shopPhone" type="text" name="shopPhone">
                        <br/>
                        <br/>
                        <label for="shopPic" style="margin-left:5px;">Upload Image:</label>
                        <input id="shopPic" name="shopPic" type="file">
                        <br/>
                        <br/>
                        <input type="submit" value="Create Account" name="CreateBarbershop" style="margin-left:5px; margin-bottom: 5px;">
                    <?php } ?>

                </form>
            </div>

        </div><!-- End of content div -->


    </body>
</html>



