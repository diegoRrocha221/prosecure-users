<?php
require_once '/var/www/html/controllers/inc.sessions.php';
session_start();
require_once '/var/www/html/users/verify_login.php';
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
        <link rel="stylesheet" href="./style.css">

</head>
<body>
<?php
require_once('../../database_connection.php');
?>
<!-- partial:index.partial.html -->
<style>
    .faq-container, .videos-container {
      max-width: 800px;
      margin: 20px auto;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      padding: 20px;
    }

    /* FAQ Dropdown Styles */
    .faq-item {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }

    .faq-item:last-child {
      border-bottom: none;
    }

    .faq-title {
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      color: #333;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .faq-content {
      display: none;
      padding-top: 10px;
      color: #555;
      max-width: 450px;
    }

    .faq-title i {
      transition: transform 0.3s ease;
    }

    .faq-title.open i {
      transform: rotate(180deg);
    }

    /* Video Section Styles */
    .helpful-video {
      display: flex;
      background-color: rgba(128, 128, 128, 0.2);
      padding: 20px;
      margin-bottom: 20px;
    }

    .video-info {
      flex: 1;
      cursor: pointer;
    }

    .video-info h3 {
      font-size: 20px;
      font-weight: bold;
      margin-top: 0;
    }

    .video-thumbnail {
      margin-left: 20px;
    }

    .video-thumbnail img {
      max-width: 200px;
      height: auto;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.9);
    }

    .modal-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 20px;
      cursor: pointer;
    }

</style>
<?php


?>
<div class="app">
        <header class="app-header">
                <div class="app-header-logo">
                        <div class="logo">
                                <span>
                                        <img src="../images/logo.png" />
                                </span>
                        </div>
                </div>
                <div class="app-header-navigation">
                        <div class="tabs">
                                <a href="#" class="active">
                                        FAQ
                                </a>
                                <a href="./costumer_tickets.php" class="">
                                        Support Tickets
                                </a>
                        </div>
                </div>
                <div class="app-header-actions">
                        <button class="user-profile">
                                <span><?php if(isset($_SESSION['full_name'])){ echo  $_SESSION['full_name']; }else{echo 'err catch name'; }?></span>
                                <span>
                                        <img />
                                </span>
                        </button>
                        <div class="app-header-actions-buttons">
                                <button class="icon-button large">
                                        <i class="ph-bell"></i>
                                </button>
                        </div>
                </div>
                <div class="app-header-mobile">
			<button class="icon-button large" id="showBurger">
				<i class="ph-list"></i>
			</button>
		</div>
		<div class="mobile-nav">
                    <nav class="navigation" id="main-navigation" style="font-size:28px;margin:30px">
                        <a href="../index.php">
                            <i class="ph-browsers"></i>
                            <span>Home</span>
                        </a>
                        <a href="./invoices.php">
                            <i class="ph-check-square"></i>
                            <span>Invoices</span>
                        </a>
                        <a href="./accounts.php">
                            <i class="ph-swap"></i>
                            <span>Manage Devices</span>
                        </a>
                        <a href="./howto_main.php">
                            <i class="ph-file-text"></i>
                            <span style="">How to Videos</span>
                        </a>
                        <a href="./costumer_support.php">
                            <i class="ph-file-text"></i>
                            <span style="color:#fff;">Support</span>
                        </a>
                        <a href="./settings/billing_address.php">
                            <i class="ph-globe"></i>
                            <span>Account Settings</span>
                        </a>
                        <a href="https://prosecurelsp.com/users/dashboard/pages/controllers/logout.php">
                            <span>Logout</span>
                        </a>
                    </nav>
                </div>

        </header>
        <div class="app-body">
                <div class="app-body-navigation">
                        <nav class="navigation">
                                <a href="../index.php">
                                        <i class="ph-browsers"></i>
                                        <span>Home</span>
                                </a>
                                <a href="#">
                                        <i class="ph-check-square"></i>
                                        <span>Invoices</span>
                                </a>
                                <a href="./accounts.php">
                                        <i class="ph-swap"></i>
                                        <span>Manage Devices</span>
                                </a>
                                <a href="./howto_main.php">
                                        <i class="ph-file-text"></i>
                                        <span style="">How to Videos</span>
                                </a>
                                <a href="./costumer_support.php">
                                        <i class="ph-file-text"></i>
                                        <span style="color:#fff;">Support</span>
                                </a>
                                <a href="./settings/billing_address.php">
                                        <i class="ph-globe"></i>
                                        <span>Account Settings</span>
                                </a>
                <a href="https://prosecurelsp.com/users/dashboard/pages/controllers/logout.php">
                    <span>Logout</span>
                </a>
                        </nav>
                        <footer class="footer">
                                <div>
                                        ProsecureLSP ©<br />
                                        All Rights Reserved 2024
                                </div>
                        </footer>
                </div>
                <style>
                  .mainsec{
                    display: grid;
                    grid-template-columns: 2fr 1fr; 
                    gap: 10px;
                  }
                  @media (max-width: 600px) { 
                    .mainsec {
                      grid-template-columns: 1fr; 
                      grid-template-rows: auto auto; 
                    }
                  }
                </style>
                <div class="app-body-main-content">
                        <div class="mainsec">
                          <section class="transfer-section">
                                  <div class="transfer-section-header">
                                   <h2>Recurring questions</h2>
  
                                  </div>
                                  <div class="faq-container">
                                  
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>How to install our service on Android</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>We have a step-by-step video tutorial for setting up our service on your Android device, just follow the link below</p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/howto_main.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>How to install our service on IOS</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>We have a step-by-step video tutorial for setting up our service on your iPhone, just follow the link below</p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/howto_main.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>How to install our service on PC</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>We have a step-by-step video tutorial for setting up our service on your desktop, just follow the link below.</p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/howto_main.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>How to setup our service on Android</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>To configure your device to connect and protect itself with our portal just follow the step-by-step link below</p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/mobile_install.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>How to setup our service on IOS</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>To configure your device to connect and protect itself with our portal just follow the step-by-step link below</p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/mobile_install.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>How to setup our service on PC</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>To configure your device to connect and protect itself with our portal just follow the step-by-step link below</p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/desktop_install.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>How to unlink an account</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>To unassociate a plan assigned to an account, go to the “Manage Devices” tab or if you prefer, use the quick link, navigate to your purchased plans, locate the email you want to unassociate and click on the red “remove” button.</p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/accounts.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>How to cancel my subscription</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>to cancel your subscription navigate to the “Account Settings” tab at the top there will be a “Payment Settings” link click on it, or if you prefer use the quick link. at the bottom of the “Payment Settings” page there will be a red “Delete My Account” button. </p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/settings/payment_settings.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>how to cancel just one plan</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>To cancel just one plan navigate to the “Account Settings” tab. at the top there will be a “Payment Settings” link click on it, or if you prefer use the quick link. at the bottom of the “Payment Settings” page there will be an orange “Edit Plans” button. click on it and you will see a list of all the sub-plans you have contracted where you can cancel them by clicking on the red “Cancel” button. </p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/settings/payment_settings.php">Quick Link</a>
                                  </div>
                                  </div>
                                  <div class="faq-item">
                                  <div class="faq-title" onclick="toggleFaq(this)">
                                    <span>Couldn't find what you were looking for?</span>
                                    <i class="+">+</i>
                                  </div>
                                  <div class="faq-content">
                                    <p>If you can't find your question, please contact our support team. We'll be happy to help you, just click on the quick link below.</p>
                                    <a href="https://prosecurelsp.com/users/dashboard/pages/costumer_tickets.php">Quick Link</a>
                                  </div>
                                  </div>
                                </div>

                                  </div>
                          </section>
                        </div>
                </div>
        </div>
</div>
<div class="modal" id="videoModal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen></iframe>
  </div>
</div>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./script.js"></script>
  <script>
  function toggleFaq(element) {
    const content = element.nextElementSibling;
    content.style.display = content.style.display === "block" ? "none" : "block";
    element.classList.toggle("open");
  }
  </script>
</body>
</html>
