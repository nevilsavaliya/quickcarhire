<!DOCTYPE html>
<html lang="en">
    <head>
        <title>QuickCarHire | Contact us</title>
        <?php
        include "./headLink.php";
        include "./databaseConnection.php";
        include "./header.php";
//        include "./sessionwithoutlogin.php";
        ?>
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

            function fnF() {
                document.getElementById("fnV").innerHTML = "";
                document.getElementById("cname").style.boxShadow = "";
                document.getElementById("fnMsg1").innerHTML = "2-20 characters";
                document.getElementById("fnMsg2").innerHTML = "Only alphabets";
            }
            function fnB() {
                document.getElementById("fnMsg1").innerHTML = "";
                document.getElementById("fnMsg2").innerHTML = "";
            }
            function fn1() {
                var fnVal = document.getElementById("cname").value;
                if (fnVal.length < 2 || fnVal.length > 80) {
                    document.getElementById("fnMsg1").style.color = "red";
                    return false;
                } else {
                    document.getElementById("fnMsg1").style.color = "green";
                    return true;
                }
            }
            function fn2() {
                var fnVal = document.getElementById("cname").value;
                if (/^[a-zA-Z ]+$/.test(fnVal)) {
                    document.getElementById("fnMsg2").style.color = "green";
                    return true;
                } else {
                    document.getElementById("fnMsg2").style.color = "red";
                    return false;
                }
            }
            function fn3() {
                var fnVal = document.getElementById("cname").value;
                if (fnVal != "" && fn1() && fn2()) {
                    document.getElementById("fnV").innerHTML = "";
                    document.getElementById("cname").style.boxShadow = "";
                    return true;
                } else {
                    document.getElementById("fnV").innerHTML = "Enter a valid first name";
                    document.getElementById("cname").style.boxShadow = "0px 0px 1px 2px red";
                    return false;
                }
            }
            function fnCheck() {
                fn1();
                fn2();
            }

            //Subject validation
            function subF() {
                document.getElementById("subV").innerHTML = "";
                document.getElementById("sub").style.boxShadow = "";
                document.getElementById("subMsg1").innerHTML = "2-20 characters";
                document.getElementById("subMsg2").innerHTML = "Only alphabets";
            }
            function subB() {
                document.getElementById("subMsg1").innerHTML = "";
                document.getElementById("subMsg2").innerHTML = "";
            }
            function sub1() {
                var subVal = document.getElementById("sub").value;
                if (subVal.length < 2 || subVal.length > 20) {
                    document.getElementById("subMsg1").style.color = "red";
                    return false;
                } else {
                    document.getElementById("subMsg1").style.color = "green";
                    return true;
                }
            }

            function sub2(){
                var subject = document.getElementsByName("sub")[0].value;
                if(/^[a-zA-Z]+$/.test(subject)){
                    document.getElementById("subMsg2").style.color = "green";
                    return true;
                }
                else{
                    document.getElementById("subMsg2").style.color = "red";
                    return false;
                }
            }
            function sub3() {
                var subVal = document.getElementById("sub").value;
                if (subVal != "" && sub1() && sub2()) {
                    document.getElementById("subV").innerHTML = "";
                    document.getElementById("sub").style.boxShadow = "";
                    return true;
                } else {
                    document.getElementById("subV").innerHTML = "Enter a valid subject";
                    document.getElementById("sub").style.boxShadow = "0px 0px 1px 2px red";
                    return false;
                }
            }
            function subCheck() {
                sub1();
                sub2();
            }

            //Message validation
            function msgF() {
                document.getElementById("msgV").innerHTML = "";
                document.getElementById("msg").style.boxShadow = "";
                document.getElementById("Msg1").innerHTML = "2-50 characters";
                document.getElementById("Msg2").innerHTML = "Only alphabets";
            }
            function msgB() {
                document.getElementById("Msg1").innerHTML = "";
                document.getElementById("Msg2").innerHTML = "";
            }
            function msg1() {
                var msgVal = document.getElementById("msg").value;
                if (msgVal.length < 2 || msgVal.length > 50) {
                    document.getElementById("Msg1").style.color = "red";
                    return false;
                } else {
                    document.getElementById("Msg1").style.color = "green";
                    return true;
                }
            }

            function msg2(){
                var msgVal = document.getElementById("msg").value;
                if(/^[a-zA-Z]+$/.test(msgVal)){
                    document.getElementById("Msg2").style.color = "green";
                    return true;
                }
                else{
                    document.getElementById("Msg2").style.color = "red";
                    return false;
                }
            }
            function msg3() {
                var msgVal = document.getElementById("msg").value;
                if (msgVal != "" && msg1() && msg2()) {
                    document.getElementById("msgV").innerHTML = "";
                    document.getElementById("msg").style.boxShadow = "";
                    return true;
                } else {
                    document.getElementById("msgV").innerHTML = "Enter a valid Message";
                    document.getElementById("msg").style.boxShadow = "0px 0px 1px 2px red";
                    return false;
                }
            }
            function msgCheck() {
                msg1();
                msg2();
            }


            // All validation
            function nullCheck() {
                var name = fn3();
                var email = email2();
                var subject = sub3();
                var Message = msg3();
                if (email && name && subject && Message) {
                    return true;
                }
                else
                {return false;
                }
            }

        </script>
    </head>
    <body>
        <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bgimg/car-3.jpg');background-position: center;">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                    <div class="col-md-9 ftco-animate pb-5">
                        <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span>
                            <span>Contact <i class="ion-ios-arrow-forward"></i></span></p>
                        <h1 class="mb-3 bread">Contact Us</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section contact-section">
            <div class="container">
                <div class="row d-flex mb-1 contact-info">
                    <div class="col-md-12 block-9">
                        <?php
                            if (isset($_POST['submit'])) {
                                $cname = $_POST['cname'];
                                $email = $_POST['email'];
                                $sub = $_POST['sub'];
                                $message = $_POST['message'];

                                $contact = $conn->prepare("INSERT INTO contact (Name, Email,Subject,Message)VALUES (?,?,?,?)");
                                $contact->bind_param("ssss", $cname, $email, $sub, $message);
                                $contactshow = $contact->execute();
                                if ($contactshow > 0) {
                                    include 'ajax/contactMail.php';
                                    ContactMail($email, $sub, $message);
                                    echo '<script>alert("Sent Message.");</script>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Not Sent Message.</div>';

                                }
                            }

                        ?>
                        <form id="contactForm" action="#" class="bg-light p-4 contact-form" method="post" onsubmit="return nullCheck()">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Name" id="cname" name="cname"
                                       required="" onkeyup="fnCheck()" onfocus="fnF()" onblur="fnB()">
                                <span id="fnMsg1" style="display:block;"></span>
                                <span id="fnMsg2" style="display:block;"></span>
                                <span id="fnV" style="display:block;"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" placeholder="Your Email" name="email" onkeyup="emailCheck()" onfocus="emailF()" onblur="emailB()" required="">
                                <span id="emailMsg" style="display:block;"></span>
                                <span id="emailV" style="display:block;"></span>

                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="sub" placeholder="Subject" name="sub" required="" onkeyup="subCheck()" onfocus="subF()" onblur="subB()">
                                <span id="subMsg1" style="display:block;"></span>
                                <span id="subMsg2" style="display:block;"></span>
                                <span id="subV" style="display:block;"></span>
                            </div>
                            <div class="form-group">
                                <textarea rows="4" class="form-control" id="msg" name="message" required=""
                                          placeholder="Message" maxlength="50" onkeyup="msgCheck()" onfocus="msgF()" onblur="msgB()"></textarea>
                                <span id="Msg1" style="display:block;"></span>
                                <span id="Msg2" style="display:block;"></span>
                                <span id="msgV" style="display:block;"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5" name="submit" >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
        include "./footerLink.php";
        ?>
    </body>
</html>