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

<?php


?>
<style>
    .custom-iframe-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* Proporção para manter a altura do iFrame */
    }

    .custom-iframe-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none; /* Remove a borda padrão do iFrame */
    }
</style>
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
                <a href="../" class="">
                    Home Dashboard
                </a>
                <a href="./mobile_install.php" class="">
                    Mobile install guide
                </a>
                <a href="#" class="active">
                    Desktop install guide
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
            <button class="icon-button large">
                <i class="ph-list"></i>
            </button>
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
                    <span style="color:#fff;">Home</span>
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
                    <span>How to Videos</span>
                </a>
                <a href="./costumer_support.php">
                    <i class="ph-file-text"></i>
                    <span>Support</span>
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
                <a href="../">
                    <i class="ph-browsers"></i>
                    <span style="color:#fff;">Home</span>
                </a>
                <a href="#">
                    <i class="ph-check-square"></i>
                    <span >Invoices</span>
                </a>
                <a href="./accounts.php">
                    <i class="ph-swap"></i>
                    <span>Manage Devices</span>
                </a>
                <a href="./howto_main.php">
                    <i class="ph-file-text"></i>
                    <span>How to Videos</span>
                </a>
                <a href="./settings/billing_address.php">
                    <i class="ph-globe"></i>
                    <span>Account Settings</span>
                </a>
                <a href="./costumer_support.php">
                    <i class="ph-file-text"></i>
                    <span>Support</span>
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
        <div class="app-body-main-content">
            <section class="transfer-section">
                <div class="custom-iframe-container">
                    <iframe src="https://prosecurelsp.com/users/dashboard/pages/_deskto_install.php" frameborder="0" ></iframe>
                </div>
            </section>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./script.js"></script>
</body>
</html>
