<?php
require_once '/var/www/html/controllers/inc.sessions.php';
session_start();
require_once '/var/www/html/users/verify_login.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once '../controllers/database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->getConnection();

    // Dados do formulário
    $newEmail = $_POST["new_email"];
    $newUsername = $_POST["new_username"];
    $newPassword = $_POST["new_password"];

    // Verificar se o novo username está disponível
    $checkUsernameQuery = "SELECT * FROM master_accounts WHERE username = '$newUsername'";
    $result = $conn->query($checkUsernameQuery);

    if ($result->num_rows == 0) {
        // O novo username está disponível, então atualize os dados do perfil
        $updateProfileQuery = "UPDATE master_accounts SET email = '$newEmail', username = '$newUsername', password = '$newPassword' WHERE id = 1";
        $conn->query($updateProfileQuery);

        // Atualizar o campo purchased_plans
        $updatePlansQuery = "UPDATE master_accounts SET purchased_plans = JSON_REPLACE(purchased_plans, '$[0].username', '$newUsername') WHERE JSON_EXTRACT(purchased_plans, '$[0].username') = 'drocha'";
        $conn->query($updatePlansQuery);

        // Redirecionar para a página de perfil com uma mensagem de sucesso
        header("Location: profile.php?success=1");
    } else {
        // O novo username já está em uso, exibir uma mensagem de erro
        $errorMessage = "O novo username já está em uso.";
    }
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
$getProfileDataQuery = "SELECT email, username FROM master_accounts WHERE username = '$username'"; // Modifique a consulta conforme necessário
$profileDataResult = $conn->query($getProfileDataQuery);

if ($profileDataResult && $profileDataResult->num_rows > 0) {
    $profileData = $profileDataResult->fetch_assoc();
    $currentEmail = $profileData["email"];
    $currentUsername = $profileData["username"];
}
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$_SESSION['reference'] = $row['reference_uuid'];
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
                <a href="#" class="active">
                    Profile
                </a>
                <a href="./billing_address.php" class="">
                    Billing Address
                </a>
                <a href="./payment_settings.php" class="">
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
                    <h2>Profile</h2>
                </div>
                <div class="transfer-section-header">
                    <h4>You can change the username, email address, and password<br>
                        associated with the administrator account here.</h4>
                </div>
                <div class="container">
                    <?php
                    if (isset($errorMessage)) {
                        echo '<div class="message error">' . $errorMessage . '</div>';
                    } elseif ($_GET["success"] == 1) {
                        echo '<div class="message success">Profile updated successfully!</div>';
                    }
                    ?>

                    <?php

                    ?>
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" name="new_email" value="<?php echo $currentEmail; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" name="new_username" value="<?php echo $currentUsername; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" name="new_username" value="<?php echo $currentUsername; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" name="new_password" required>
                        </div>
                        <button type="submit">Update Profile</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- partial -->
<script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
