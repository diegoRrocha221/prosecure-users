<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Carousel Example</title>
</head>
<body>
<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Introduction
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong> Installing Prosecurelsp on your mobile device </strong><br>
                Phones and Pads running iOS or Android<br><br>

                If you’ve installed an app or two, and are tech savvy, installation is super easy. Just follow our handy<br>
                dandy quick guide below and you’ll have your device protected in about 60 seconds flat.<br>
                Prefer vinyl over CDs? We agree, they sound better! Below the quick guide we have a more detailed<br>
                step by step guide to get you set up in just a few minutes. Trust us, it’s easier then programing a VCR!<br>
                Rocking a windows phone or something else unusual? Reach out to us directly here and we’ll get you set
                up personally
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Quick Install guide
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>Frist download the Global Protect app from your app store by clicking your store’s link below</strong><br>
                Open the app. The App will ask you to enter a portal address.<br><br>
                <style>
                    .dummy-img{
                        width: 200px;
                        height: 80px;

                    }
                </style>
                <div class="d-flex align-items-center">
                    <div class="col-md-6" onclick="openPlay();" style="cursor: pointer">
                        <img class="dummy-img"
                             src="./googleplay.png"
                             alt="">
                    </div>
                    <div class="col-md-6" onclick="openApp();" style="cursor: pointer">
                        <img class="dummy-img"
                             src="./appstore.png"
                             alt="">
                    </div>
                </div>
                <center>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqDJgETc_gQ_JF0p_RsHQ1XM-O013SGpycS5hR3NAcqtDVsPqgDzNZ8S5-4tF2YnWRYQg&usqp=CAU" />
                </center>
                Enter cportal.prosecurelsp.com, then
                press connect. Sometimes on some devices there may be a popup stating something like “Global protect
                would like to configure secure vpn connections” and offer the choice of “Allow” or “Don’t allow” press
                allow. You may need to enter the code or passphrase for your phone or tablet.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Second Step
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                Global protect will then connect to the Cybergate portal, and then ask you for your username. Just like
                the PC version of Cybergate your username will be the email address you used when you signed up.
                <center>
                    <img src="https://images2.imgbox.com/ab/3d/aFTw8n9p_o.png" width="300px" height="700px"/>
                </center><br>
                Global protect will then ask for your password. Once you enter it, press sign in.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseF" aria-expanded="false" aria-controls="collapseF">
                Succesful
            </button>
        </h2>
        <div id="collapseF" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>you will see something like this</strong><br>
                <center>
                    <img src="https://success.bju.edu/wp-content/uploads/2021/11/GP_Connected.png" width="300px" height="700px"/>
                </center><br>
                Your all set and your device is now protected by CybergateLSP!
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>
    function openApp(){
        window.open("https://apps.apple.com/us/app/globalprotect/id1400555706", '_blank');
    }
    function openPlay(){
        window.open("https://play.google.com/store/apps/details?id=com.paloaltonetworks.globalprotect&hl=en_US", '_blank');
    }

</script>
</body>
</html>
