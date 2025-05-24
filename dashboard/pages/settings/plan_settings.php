<?php
require_once '/var/www/html/controllers/inc.sessions.php';
session_start();
require_once '/var/www/html/users/verify_login.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once '/var/www/html/users/dashboard/pages/controllers/edit_plans.php';

?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Home Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="../style.css">

</head>
<body>
<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .button-error {
        background: rgb(202, 60, 60);
    }
    .button-warning {
        background: #f0ad4e;
    }
    .form-group {
        margin-bottom: 10px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 5px;
    }
    .message {
        margin-top: 10px;
        padding: 10px;
        border-radius: 5px;
    }
    .success {
        background-color: #d4edda;
        color: #155724;
    }
    .error {
        background-color: #f8d7da;
        color: #721c24;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #2e2e2e;
    }
    tr:hover {
        background-color: #2e2e2e;
    }
    .button-error, .button-warning {
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
    }
    .button-error {
        background: rgb(202, 60, 60);
    }
    .button-warning {
        background: #f0ad4e;
    }
    .modal-content {
        background-color: #fff;
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: #2C3E50;
    }

    #closeModal {
        cursor: pointer;
        color: #333;
        font-size: 20px;
        position: absolute;
        top: 10px;
        right: 15px;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center; 
        z-index: 999;
    }

    .modal-dialog {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        max-width: 500px;
    }

    .modal-header {
        background-color: #25364d;
        color: #fff;
        padding: 10px;
        display: flex;
        justify-content: space-between;
    }

    .modal-title {
        margin: 0;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        text-align: right;
        padding: 10px;
        background-color: #25364d;
    }

    .btn-close {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 20px;
        color: #fff;
    }

    .btn-close:hover {
        color: #f00;
    }

</style>


<div class="app">
    <header class="app-header">
        <div class="app-header-logo">
            <div class="logo">
				<span>
					<img src="../../images/logo.png" />
				</span>
            </div>
        </div>
        <div class="app-header-navigation">
            <div class="tabs">
                <a href="./profile_settings.php" >
                    Profile
                </a>
                <a href="./billing_address.php" class="">
                    Billing Address
                </a>
                <a href="./payment_settings.php" class="active">
                    Payment settings
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

    </header>
    <div class="app-body">
        <div class="app-body-navigation">
            <nav class="navigation">
                <a href="../../index.php">
                    <i class="ph-browsers"></i>
                    <span>Home</span>
                </a>
                <a href="../invoices.php">
                    <i class="ph-check-square"></i>
                    <span>Invoices</span>
                </a>
                <a href="../accounts.php">
                    <i class="ph-swap"></i>
                    <span>Manage Devices</span>
                </a>
                <a href="../howto_main.php">
                    <i class="ph-file-text"></i>
                    <span>How to Videos</span>
                </a>
                <a href="../costumer_support.php">
                    <i class="ph-file-text"></i>
                    <span>Support</span>
                </a>
                <a href="#">
                    <i class="ph-globe"></i>
                    <span style="color:#fff;">Account Settings</span>
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
                <div class="transfer-section-header">
                    <h2>Plans Settings</h2>
                </div>
                <div class="transfer-section-header">
                    <h4>You can remove plans from your account without deleting your account</h4>
                </div>
                <div class="container">
                    <h2>Your plans</h2>

                    <table>
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Username</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php get_plans(); ?>
                        </tbody>
                    </table>
                </div>

            </section>
        </div>
    </div>
</div>
<div class="modal" id="myModal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-header">
            <h5 class="modal-title" id="response-modal-label">Message</h5>
            <button type="button" class="btn-close custom-btn-close" id="closeModalBtn">x</button>
        </div>
        <div class="modal-body" id="response-modal-body" style="color:gray">

        </div>
        <div class="modal-footer">

        </div>
    </div>
</div>

<!-- partial -->
<script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('.button-error').on('click', function() {
            var buttonClicked = $(this);
            var psp = buttonClicked.data('psp');
            var psr = buttonClicked.data('psr');
            
            console.log(psr);
            console.log(psp);
            const data = {
                action: 'cancel_plan',
                psp: psp,
                psr: psr
            };
            if (confirm('Are you sure you want to cancel this plan?')) {
            $.ajax({
                type: 'POST',
                url: '../controllers/edit_plan_handler.php', 
                data: data,
                success: function(response) {
                    console.log('Response:', response);
                    $('#response-modal-body').html(response);
                    $('#myModal').css('display', 'block');
                },
                error: function(error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });
          }
        });
        
    });
    const closeModalBtn = document.getElementById("closeModalBtn");
        const modal = document.getElementById("myModal");

        closeModalBtn.addEventListener("click", () => {
            modal.style.display = "none";
            location.reload();
        });
</script>
</body>
</html>
