<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="script-src 'self' https://www.google.com https://www.gstatic.com https://unpkg.com https://code.jquery.com; object-src 'none';">
  <title>Home Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <script src="https://www.google.com/recaptcha/api.js?render=6LfbZUgqAAAAAE7dui7Q2z3OChVMJuv--hvzkLtz"></script>

  <link rel="stylesheet" href="./style.css">
  <style>
    .new-ticket-btn {
      background-color: green;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      border-radius: 10px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-header {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .modal-body input, .modal-body textarea {
      width: 100%;
      padding: 10px;
      margin: 5px 0 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .modal-body button {
      background-color: green;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .ticket {
      background-color: white;
      padding: 20px;
      margin-bottom: 10px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .ticket-title {
      color:black;
      font-size: 20px;
      margin-bottom: 10px;
    }

    .ticket-info {
      font-size: 14px;
      color: gray;
    }

    .ticket-status {
      font-size: 14px;
      font-weight: bold;
      text-align: right;
    }

    .status-waiting {
      color: green;
    }

    .status-reply {
      color: blue;
    }

    .status-closed {
      color: red;
    }
  </style>
</head>
<body>
<?php
require_once('/var/www/html/controllers/inc.sessions.php');
session_start();
require_once('/var/www/html/users/verify_login.php');
require_once('../../database_connection.php');

// Fetch tickets from the database
$db = new DatabaseConnection();
$conn = $db->getConnection();
$reference = $_SESSION['reference'];
$query = "SELECT * FROM customer_tickets WHERE reference_uuid = '$reference'";
$result = $conn->query($query);
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
        <a href="costumer_support.php" class="">FAQ</a>
        <a href="#" class="active">Support Tickets</a>
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
                    <span style="color:#ffff">Support</span>
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
    <div class="app-body-main-content">
      <div class="mainsec">
        <section class="transfer-section">
          <div class="transfer-section-header">
            <h2>Your tickets</h2><br>
          </div>
          <button class="new-ticket-btn" id="newTicketBtn">New ticket</button>
          <div style="margin-top:20px;">
              <?php
                if ($result && $result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      $status_class = '';
                      $status_text = '';
                      if ($row['status'] == 0) {
                          $status_class = 'status-waiting';
                          $status_text = 'Waiting for a reply';
                      } elseif ($row['status'] == 1) {
                          $status_class = 'status-reply';
                          $status_text = 'In reply';
                      } elseif ($row['status'] == 2) {
                          $status_class = 'status-closed';
                          $status_text = 'Closed';
                      }
                      echo '<div class="ticket">';
                      echo '<div class="ticket-title">' . htmlspecialchars($row['title']) . '</div>';
                      echo '<div class="ticket-info">Created at: ' . htmlspecialchars($row['created_at']) . '<br>Last updated: ' . htmlspecialchars($row['updated_at']) . '</div>';
                      echo '<div class="ticket-status ' . $status_class . '">' . $status_text . '</div>';
                      echo '</div>';
                  }
                } else {
                  echo 'No tickets found.';
                }
            ?>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="newTicketModal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <div class="modal-header" style="color:black">New ticket</div>
    <div class="modal-body">
      <input type="text" id="ticketTitle" name="title" placeholder="Title" required>
      <textarea id="ticketMessage" rows="5" placeholder="Message" required></textarea>
      <div class="h-captcha" data-sitekey="2895684a-7158-4357-8c78-18da7039ff4f"></div>
      <button id="submitTicket">Submit</button>
    </div>
  </div>
</div>
<!-- partial -->
<script src='https://unpkg.com/phosphor-icons'></script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./script.js"></script>
<script src="./recaptcha.js"></script>
</body>
</html>
