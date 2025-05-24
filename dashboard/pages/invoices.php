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
					Payments
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
                    <span style="color:#fff;">Invoices</span>
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
				<a href="../index.php">
					<i class="ph-browsers"></i>
					<span>Home</span>
				</a>
				<a href="#">
					<i class="ph-check-square"></i>
					<span style="color:#fff;">Invoices</span>
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
					<h2>Invoices</h2>

				</div>
                <?php if(isset($_GET['scs'])){?>
                    <h4 style="color: green">Invoice delivered, please check your email</h4>
                <?php } ?>
				<?php 
					$db = new DatabaseConnection();
					$conn = $db->getConnection();
					$masterReference = $conn->real_escape_string($_SESSION['reference']);

				// Consulta na tabela invoices
				$sqlInvoices = "SELECT * FROM invoices WHERE master_reference = '$masterReference' LIMIT 3";
				$resultInvoices = $conn->query($sqlInvoices);
				function statusInvoice($status){
					if($status == 0){return "not paid";} else{ return "paid";}
				}
				if ($resultInvoices->num_rows > 0) {
				    // Há registros correspondentes na tabela invoices
				    while ($row = $resultInvoices->fetch_assoc()) {			
						echo '
						<div class="transfers">
						<div class="transfer">
						<dl class="transfer-details">
							<div>
								<dt>Invoice</dt>
								<dd>Master Invoice</dd>
							</div>
							<div>
							<dt>Due date</dt>
							<dd>'. $row['due_date'] .'</dd>
							</div>
							<div>
								<dt>Status</dt>
								<dd>'. statusInvoice($row['is_paid']) .'</dd>
							</div>
						</dl>
						<div class="transfer-number">
							 $ '. $row['total'] .'
						</div>
						<div class="transfer-number">
							 <a href="./partials/_invoice.php?'.$_SESSION['email'].'&muid='.$_SESSION['reference'].'&inuid='.$row['id'].'" target="_blank" >View</a>
						</div>
					</div>
						';
						}
					}
				echo "</div>";					
				?>
			</section>
		</div>
	</div>
</div>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script  src="./script.js"></script>

</body>
</html>
