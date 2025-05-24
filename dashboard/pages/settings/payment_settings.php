<?php
require_once '/var/www/html/controllers/inc.sessions.php';
session_start();
require_once '/var/www/html/users/verify_login.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once '../controllers/database_connection.php';
require "send_mail.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->getConnection();

    // Dados do formulário
    $newCard = $_POST["cardnumber"];
    $newExpiry = $_POST["expiry"];
    // Verificar se o novo username está disponível
    $reference = $_SESSION['reference'];
    // O novo username está disponível, então atualize os dados do perfil
    $updateProfileQuery = "UPDATE billing_infos SET card = '$newCard', expiry = '$newExpiry' WHERE master_reference = '$reference'";
    $conn->query($updateProfileQuery);
    $email = $_SESSION['email'];
    $body = ' <div style="text-align: center; background-color: #2C3E50"> ';
    $body .= '<a style="color:#fff; padding-bottom: 50px" href="https://prosecurelsp.com/users"><strong>Login here</strong></a>';
    $body .='<img src="https://www.prosecurelsp.com/images/logo.png" style="padding-top: 50px"/></br>';
    $body .= '<h1 style="color:#fff">if you not make this action please change your password now </h1> <br/>';
    sendmail($email,$body);
    header("Location: payment_settings.php?success=1");
}

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
</style>

<?php
$db = new DatabaseConnection();
$conn = $db->getConnection();
$username = $conn->real_escape_string($_SESSION['username']);
$sql = "SELECT * FROM master_accounts WHERE username = '$username'";
$result = $conn->query($sql);
$reference_m = $conn->real_escape_string($_SESSION['reference']);
$getProfileDataQuery = "SELECT * FROM billing_infos WHERE master_reference = '$reference_m'"; // Modifique a consulta conforme necessário
$profileDataResult = $conn->query($getProfileDataQuery);

if ($profileDataResult && $profileDataResult->num_rows > 0) {
    $profileData = $profileDataResult->fetch_assoc();
    $currentCard = $profileData["card"];
    $currentExpiry = $profileData["expiry"];


}
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$_SESSION['reference'] = $row['reference_uuid'];
$_SESSION['email'] = $row['email'];
$_SESSION['name'] = $row['name'] . $row['lname'];
?>
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
                <span><?php echo $row['name'] . " ". $row['lname']; }}?></span>
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
                    <h2>Payment information</h2>
                </div>
                <div class="transfer-section-header">
                    <h4>You can adjust or change your payment information below.</h4>
                </div>
                <div class="container">
                    <?php
                    if (isset($errorMessage)) {
                        echo '<div class="message error">' . $errorMessage . '</div>';
                    } elseif ($_GET["success"] == 1) {
                        echo '<div class="message success">Billing updated successfully!</div>';
                    }
                    ?>

                    <?php

                    ?>
                    <div class="card-container" id="card-container">
                    <form method="post" action="" id="msform" class="msform">
                        <div class="form-group">
                            <label>Holder name:</label>
                            <input type="text" name="cardname" id="cardname" value="<?php echo $_SESSION['name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Card number:</label>
                            <input type="text" name="cardnumber" id="cardnumber" value="<?php echo $currentCard; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Expiration date:</label>
                            <input type="text" name="expiry" value="<?php echo $currentExpiry; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>CVV:</label>
                            <input type="text" name="cvv" value="<?php echo ""; ?>" required>
                        </div>

                        <button type="submit">Update Profile</button>

                    </form>
                        
                    </div>
                    
                </div>
                <button class="button-warning" style="margin-top: 20px; cursor:pointer" data-info="">Edit My Plans</button>
                <button class="button-error" style="margin-top: 20px; cursor:pointer" data-info="">Delete My Account</button>
            </section>
        </div>
    </div>
</div>
<!-- partial -->
<script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/card/2.5.0/card.min.js"></script>
<script>

    $(document).ready(function() {
        var card = new Card({
            form: '#msform',
            container: '#card-container',
            formSelectors: {
                nameInput: 'input[name="cardname"]',
                numberInput: 'input[name="cardnumber"]',
                expiryInput: 'input[name="expiry"]',
                cvcInput: 'input[name="cvv"]'
            },
            width: 250,
            formatting: true
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.button-error').click(function(){
            if (confirm('Are you sure you want to cancel your subscription?')) {
                $.ajax({
                    type: "POST",
                    url: "../controllers/cancel_subscription.php",
                    data: { action: 'cancel' },
                    success: function(response) {
                        alert('Subscription cancelled successfully.');
                        window.location.href = 'https://prosecurelsp.com/users/dashboard/pages/controllers/logout.php';
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            }
        });
        $('.button-warning').click(function(){
            window.location.href = 'https://prosecurelsp.com/users/dashboard/pages/settings/plan_settings.php';
        });
    });
</script>
</body>
</html>
