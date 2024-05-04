<?php
include "./databaseConnection.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registration</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/login/form.css">

        <script>
            // email validation
            function emailF() {
                document.getElementById("emailV").innerHTML = "";
                document.getElementById("email").style.boxShadow = "";
                document.getElementById("emailMsg").innerHTML = "Valid email address";
            }
            function emailB() {
                document.getElementById("emailMsg").innerHTML = "";
            }
            function emailCheck() {
                var emailVal = document.getElementById("email").value;
                if (/^[a-z][a-z0-9]+@(gmail|outlook|hotmail|yahoo|icloud|utu)[.](com|in)$/.test(emailVal)) {
                    document.getElementById("emailMsg").style.color = "green";
                    return true;
                } else {
                    document.getElementById("emailMsg").style.color = "red";
                    return false;
                }
            }
            function email2() {
                var emailVal = document.getElementById("email").value;
                if (emailVal != "" && emailCheck()) {
                    document.getElementById("emailV").innerHTML = "";
                    document.getElementById("email").style.boxShadow = "";
                    return true;
                } else {
                    document.getElementById("emailV").innerHTML = "Enter a valid email address";
                    document.getElementById("email").style.boxShadow = "0px 0px 1px 2px red";
                    return false;
                }
            }
            // password validation
            function passF() {
                document.getElementById("passV").innerHTML = "";
                document.getElementById("pass").style.boxShadow = "";
                document.getElementById("passMsg1").innerHTML = "8-15 case sensitive characters";
                document.getElementById("passMsg2").innerHTML = "Atleast one small alphabet";
                document.getElementById("passMsg3").innerHTML = "Atleast one capital alphabet";
                document.getElementById("passMsg4").innerHTML = "Atleast one number";
            }

            function passB() {
                document.getElementById("passMsg1").innerHTML = "";
                document.getElementById("passMsg2").innerHTML = "";
                document.getElementById("passMsg3").innerHTML = "";
                document.getElementById("passMsg4").innerHTML = "";
            }
            function pass1() {
                var passVal = document.getElementById("pass").value;
                if (passVal.length < 8 || passVal.length > 15) {
                    document.getElementById("passMsg1").style.color = "red";
                    return false;
                } else {
                    document.getElementById("passMsg1").style.color = "green";
                    return true;
                }
            }
            function pass2() {
                var passVal = document.getElementById("pass").value;
                if (/[a-z]/.test(passVal)) {
                    document.getElementById("passMsg2").style.color = "green";
                    return true;
                } else {
                    document.getElementById("passMsg2").style.color = "red";
                    return false;
                }
            }
            function pass3() {
                var passVal = document.getElementById("pass").value;
                if (/[A-Z]/.test(passVal)) {
                    document.getElementById("passMsg3").style.color = "green";
                    return true;
                } else {
                    document.getElementById("passMsg3").style.color = "red";
                    return false;
                }
            }
            function pass4() {
                var passVal = document.getElementById("pass").value;
                if (/[0-9]/.test(passVal)) {
                    document.getElementById("passMsg4").style.color = "green";
                    return true;
                } else {
                    document.getElementById("passMsg4").style.color = "red";
                    return false;
                }
            }
            function pass5() {
                var passVal = document.getElementById("pass").value;
                if (passVal != "" && pass1() && pass2() && pass3() && pass4()) {
                    document.getElementById("passV").innerHTML = "";
                    document.getElementById("pass").style.boxShadow = "";
                    return true;
                } else {
                    document.getElementById("passV").innerHTML = "Enter a valid password";
                    document.getElementById("pass").style.boxShadow = "0px 0px 1px 2px red";
                    return false;
                }
            }
            function passCheck() {
                const passArray = [pass1(), pass2(), pass3(), pass4()];
                for (var i = 0; i < 4; i++)
                    passArray[i];
            }


            function conPassF() {
                document.getElementById("conPassV").innerHTML = "";
                document.getElementById("conPass").style.boxShadow = "";
                document.getElementById("conPassMsg").innerHTML = "Password & confirm password must match"
            }

            function conPassB() {
                document.getElementById("conPassMsg").innerHTML = "";
            }

            function conPass1() {
                var passVal = document.getElementById("pass").value;
                var conPassVal = document.getElementById("conPass").value;
                if (passVal != conPassVal) {
                    document.getElementById("conPassMsg").style.color = "red";
                    return false;
                } else {
                    document.getElementById("conPassMsg").style.color = "green";
                    return true;
                }
            }

            function conPassCheck() {
                var conPassVal = document.getElementById("conPass").value;
                if (passVal != conPassVal) {
                    document.getElementById("conPassV").innerHTML = "";
                    document.getElementById("conPass").style.boxShadow = "";
                    return true;
                } else {
                    document.getElementById("conPassV").innerHTML = "Password & confirm password must match";
                    document.getElementById("conPass").style.boxShadow = "0px 0px 1px 2px red";
                    return false;
                }
            }


            // All validation
            function nullCheck() {
                var pass = pass5();
                var email = email2();

                if (email && pass)
                    return true;
                else
                    return false;
            }
        </script>
    </head>
    <body>
        <div class="registration-form">
            <form method="post" enctype="multipart/form-data" style="width: 110%" onsubmit="return nullCheck()">
                <h5 class="title">Registration Form</h5>
                <!--                <div class="form-icon">
                                    <span><i class="icon icon-user"></i></span>
                                </div>-->

                <div class="form-group">
                    <input type="email" class="form-control item" id="email" name="email" placeholder="Email" required onkeyup="emailCheck()" onfocus="emailF()" onblur="emailB()">
                    <span id="emailMsg" style="display:block;"></span>
                    <span id="emailV" style="display:block;"></span>
                    <span style="display:block;"><?php if (isset($emailE)) echo $emailE; ?></span>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control item" id="pass" name="password" placeholder="Password" onkeyup="passCheck()" onfocus="passF()" onblur="passB()" required>
                    <span id="passMsg1" style="display:block;"></span>
                    <span id="passMsg2" style="display:block;"></span>
                    <span id="passMsg3" style="display:block;"></span>
                    <span id="passMsg4" style="display:block;"></span>
                    <span id="passV" style="display:block;"></span>
                    <span style="display:block;"><?php if (isset($passE1)) echo $passE1; ?></span>
                    <span style="display:block;"><?php if (isset($passE2)) echo $passE2; ?></span>
                    <span style="display:block;"><?php if (isset($passE3)) echo $passE3; ?></span>
                    <span style="display:block;"><?php if (isset($passE4)) echo $passE4; ?></span>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control item" id="conPass" name="cpassword" placeholder="Confirm Password" onkeyup="conPassCheck()" onfocus="conPassF()" onblur="conPassB()"required>
                    <span id="conPassMsg"></span>
                    <span id="conPassV"></span>
                    <span><?php if (isset($cpass1)) echo $cpass1; ?></span>
                </div>
                <!-- hidden field for checking javascript is on or off -->
                <input type="hidden" name="javaScriptValid" id="jsValid" value="0" />

                <div class="form-group">
                    <i id="error"></i>
                    <button type="submit" name="submit" id="submit" class="btn btn-block create-account">Registration</button>
                </div>

                <hr/>
                <p class="subtitle">Already Registration? <a href="login.php">Login</a></p>
                <?php

                if (isset($_POST['submit'])) {
                    //creating variables for error msgs, E refers to error
                    $emailE = $passE1 = $passE2 = $passE3 = $passE4 = $cpass1 = "";
                    $Emailid = $_POST['email'];
                    $Password = $_POST['password'];
                    $cpassword = $_POST['cpassword'];
                    $valid = true;

                // checking javascript is on or off
                   if ($_POST["javaScriptValid"] == 0) {
                       // email
                       if (empty($Emailid)) {
                           $valid = false;
                           $emailE = "Enter a valid email";
                       } else {
                           if (!preg_match("/^[a-z][a-z0-9]+@(gmail|outlook|hotmail|yahoo|icloud|utu)[.](com|in)$/", $Emailid)) {
                               $valid = false;
                               $emailE = "Enter a valid email";
                           }
                       }


                       if (empty($Password)) {
                           $valid = false;
                           $passE1 = "Enter a valid password";
                       } else {
                           if (strlen($Password) < 8 && strlen($Password > 15)) {
                               $valid = false;
                               $passE1 = "8-15 case sensitive characters";
                           }
                           if (!preg_match("/[a-z]/", $Password)) {
                               $valid = false;
                               $passE2 = "Atleast one small alphabet";
                           }
                           if (!preg_match("/[A-Z]/", $Password)) {
                               $valid = false;
                               $passE3 = "Atleast one capital alphabet";
                           }
                           if (!preg_match("/[0-9]/", $Password)) {
                               $valid = false;
                               $passE4 = "Atleast one number";
                           }
                       }
                       if (empty($cpassword)) {
                           $valid = false;
                           $passE1 = "Enter a valid Confirm password";
                       }else {
                           if ($cpassword != $Password) {
                               $valid = false;
                               $cpass1 = "Password does not match with confirm password";
                           }
                       }
                    }
                if ($valid) {
                    $CheckP = $conn->prepare("SELECT * FROM customer WHERE Email = ?");
                    $CheckP->bind_param("s", $Emailid);
                    $result = $CheckP->execute();
                    $result = $CheckP->get_result()->fetch_all(MYSQLI_ASSOC);

                    if (!count($result) > 0) {
                                $_SESSION['Email'] = $Emailid;
                                $_SESSION['Password'] = $Password;
                                $_SESSION['Login'] = true;

                                $otp = rand(1000000, 9999999);

                                $sql1 = "INSERT INTO register(Email, Password,OTP,Verify) VALUES ('$Emailid','$Password','$otp','0')";
                                try {
                                    $resultCustomer = $conn->query($sql1);
                                } catch (mysqli_sql_exception $e) {
                                    echo $e->getMessage();
                                }

                                include 'otpMail.php';
                                sendMail($Emailid, $otp);
                                echo "<script>window.location.href='./otp.php'</script>";


                    } else {
                        echo '<div class="alert alert-danger" role="alert">This Email id is Exits.</div>';
                    }
                }

                }
                ?>
            </form>

            <!--    <div class="social-media">
                    <h5>Sign up with social media</h5>
                    <div class="social-icons">
                        <a href="#"><i class="icon-social-facebook" title="Facebook"></i></a>
                        <a href="#"><i class="icon-social-google" title="Google"></i></a>
                        <a href="#"><i class="icon-social-twitter" title="Twitter"></i></a>
                    </div>
                </div>-->
        </div>
    </body>
</html>
