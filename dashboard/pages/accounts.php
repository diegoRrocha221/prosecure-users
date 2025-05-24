<?php
require_once '/var/www/html/controllers/inc.sessions.php';
session_start();
require_once '/var/www/html/users/verify_login.php';
require_once('./controllers/test.php');

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

<style>
 .modal_1 {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Dark transparent background */
    z-index: 9999;
    overflow-y: auto;
}

.modal-dialog_1 {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
    position: relative;
}

.modal-header_1 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 10px;
    color: #25364d;
}

.modal-title_1 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #25364d;
}

.btn-close_1 {
    background: none;
    border: none;
    color: #25364d;
    font-size: 1.5rem;
    cursor: pointer;
}

.modal-body_1 {
    margin-top: 20px;
}

.plan-input-group {
    margin-bottom: 15px;
}

.plan-input-group label {
    font-size: 1rem;
    color: #25364d;
    display: block;
    margin-bottom: 5px;
}

.plan-input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    color: #25364d;
    outline: none;
    transition: border 0.3s ease;
}

.plan-input-group input:focus {
    border-color: #fca311;
}

.buttonnew {
    background-color: #fca311;
    border: none;
    color: #ffffff;
    padding: 15px 32px;
    font-size: 1rem;
    font-weight: bold;
    border-radius: 25px;
    cursor: pointer;
    display: inline-block;
    text-align: center;
    width: 100%;
    margin-top: 15px;
    transition: background-color 0.3s ease;
}

.buttonnew:hover {
    background-color: #f7a80a;
}

.divider {
    margin: 20px 0;
    border: 1px solid #e0e0e0;
}

#totalSection h4 {
    font-size: 1.2rem;
    color: #25364d;
    margin-bottom: 10px;
}

#totalSection p {
    font-size: 1rem;
    color: #25364d;
}

.explanation p {
    font-size: 0.9rem;
    color: #555;
    margin-top: 10px;
}

.modal-footer_1 {
    margin-top: 20px;
    padding-top: 10px;
    border-top: 1px solid #e0e0e0;
}

@media (max-width: 768px) {
    .modal-dialog_1 {
        max-width: 90%;
        padding: 15px;
    }

    .buttonnew {
        padding: 10px 20px;
    }

    #totalSection h4 {
        font-size: 1.1rem;
    }

    #totalSection p {
        font-size: 0.9rem;
    }
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
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        text-align: center;
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

    #tutorialModal {
        display: none;
        position: fixed;
        /*add position */
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
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


*,
::before,
::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}



#cCarousel {
  position: relative;
  max-width: 900px;
  margin: auto;
}

#cCarousel .arrow {
  position: absolute;
  top: 50%;
  display: flex;
  width: 45px;
  height: 45px;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  z-index: 1;
  font-size: 26px;
  color: white;
  background: #00000072;
  cursor: pointer;
}

#cCarousel #prev {
  left: 0px;
}

#cCarousel #next {
  right: 0px;
}

#carousel-vp {
  width: 770px;
  height: 400px;
  display: flex;
  align-items: center;
  position: relative;
  overflow: hidden;
  margin: auto;
}

@media (max-width: 770px) {
  #carousel-vp {
    width: 510px;
  }
}

@media (max-width: 510px) {
  #carousel-vp {
    width: 250px;
  }
}

#cCarousel #cCarousel-inner {
  display: flex;
  position: absolute;
  transition: 0.3s ease-in-out;
  gap: 10px;
  left: 0px;
}

.cCarousel-item {
  width: 250px;
  height: 365px;
  border: 2px solid white;
  border-radius: 15px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.cCarousel-item img {
  width: 100%;
  object-fit: cover;
  min-height: 246px;
  color: white;
}

.cCarousel-item .infos {
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-around;
  background: white;
  color: black;
}

.cCarousel-item .infos button {
  background: #222;
  padding: 10px 30px;
  border-radius: 15px;
  color: white;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
}



.input-container {
        margin-top: 20px;
        position: relative;
        display: flex;
        height: 2.8rem;
        width: 100%;
        min-width: 200px;
        max-width: 250px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 20px 20px 30px rgba(0, 0, 0, .05);
    }

    .input-container input {
        height: 100%;
        width: 100%;
        border-radius: 8px;
        border: 1px solid  rgb(176 190 197);
        background-color: transparent;
        padding: 0.625rem 70px 0.625rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 400;
        color: rgb(69 90 100);
        outline: none;
        transition: all .15s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-container input:focus {
        border: 1px solid rgb(236 72 153 );
    }

    .invite-btn {
        position: absolute;
        width: 65px;
        right: 4px;
        top: 4px;
        bottom: 4px;
        z-index: 10;
        border-radius: 4px;
        background-color: rgb(30 193 47 );
        color: #fff;
        padding-top: .25rem;
        padding-bottom: .25rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        text-align: center;
        vertical-align: middle;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        transition: .6s ease;
        cursor: pointer;
    }
    .buttonnew {
				background-color: #fca311;
				border: none;
				color: #25364D;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
				border-radius: 50px;
				cursor: pointer;
	}
    .invite-admin{
        position: absolute;
        width: 65px;
        right: 4px;
        top: 4px;
        bottom: 4px;
        z-index: 10;
        border-radius: 4px;
        background-color: dodgerblue;
        color: #fff;
        padding-top: .25rem;
        padding-bottom: .25rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        text-align: center;
        vertical-align: middle;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        transition: .6s ease;


    }
    .invite-btn:hover {
        right: 2px;
        top: 2px;
        bottom: 2px;
        border-radius: 8px;
    }

    .input-container input:placeholder-shown ~ .invite-btn {
        pointer-events: none;
        background-color: gray;
        opacity: 0.5;
    }
    #tutorialDropdown {
    position: relative;
    display: inline-block;
}

#dropdownButton {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    color: #25364D ;
    min-width: 500px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 20px;
    z-index: 1;
}

#tutorialDropdown:hover .dropdown-content {
    display: block;
}

.dropdown-content p {
    margin: 10px 0;
}

#dropdownButton:hover {
    background-color: #45a049;
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
					Manage Devices
				</a>
			</div>
		</div>
		<div class="app-header-actions">
			<button class="user-profile">
				<span><?php if(isset($_SESSION['full_name'])){ echo  $_SESSION['full_name']; }else{echo 'err catch name'; } ?></span>
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
                <a href="#">
                    <i class="ph-swap"></i>
                    <span style="color:#fff;">Manage Devices</span>
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

            <nav class="navigation" id="main-navigation">
                <a href="../index.php">
                    <i class="ph-browsers"></i>
                    <span>Home</span>
                </a>
                <a href="./invoices.php">
                    <i class="ph-check-square"></i>
                    <span>Invoices</span>
                </a>
                <a href="#">
                    <i class="ph-swap"></i>
                    <span style="color:#fff;">Manage Devices</span>
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
					<h2>Your Accounts</h2>
				</div>
                <div>
                <div id="tutorialDropdown">
                    <button id="dropdownButton">How does it work?</button>
                    <div class="dropdown-content">
                        <p>
                            Here you can create child or sub accounts for additional devices and plans. To provide you with the flexibility
                            to match the best plan for each of your devices, we need to identify which device should have which plan
                            applied. We do that by having unique accounts for each device matched with a plan.
                        </p>
                        <p>
                            Listed below are the different plans you selected, under each is a field where you can enter an email address
                            for each device you would like to protect. Begin by entering an email address and pressing invite. Like the
                            email address you entered when you initially signed up for CyberGate, this email address will be the username
                            for each device.
                        </p>
                        <p>
                            Once you click invite, an email will be sent with a link where you can create a password for that
                            child/sub account. After that, you need only to install the CyberGate application on the device you want to
                            protect and enter the child/sub account’s username and password.
                        </p>
                    </div>
                </div>
                </div>
                <div>
                <section>
                    
                    <div id="cCarousel">
                        <div class="arrow" id="prev"><i class="fa-solid fa-chevron-left"></i></div>
                        <div class="arrow" id="next"><i class="fa-solid fa-chevron-right"></i></div>
                            <div id="carousel-vp">
                                <div id="cCarousel-inner">
                                    <?php get_accounts(); ?>
                                </div>
                            </div>
                    </div>
                    <button onclick="openAddPlanModal()" class="buttonnew">Add New Plan</button>
                </section>
                </div>
            </section>
		</div>
	</div>
</div>

<!-- Modal -->
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



<div id="addPlanModal" class="modal_1" style="display: none;">
    <div class="modal-dialog_1">
        <div class="modal-header_1">
            <h5 class="modal-title_1">Add New Plans</h5>
            <button type="button" class="btn-close_1 custom-btn-close_1" onclick="closeAddPlanModal()">×</button>
        </div>
        <div class="modal-body_1">
            <form id="cartForm">
                <div class="plan-input-group">
                    <label for="kidsPlan">Kids Plan:</label>
                    <input type="number" id="kidsPlan" name="kidsPlan" min="0" value="0">
                </div>
                <div class="plan-input-group">
                    <label for="familyPlan">Family Plan:</label>
                    <input type="number" id="familyPlan" name="familyPlan" min="0" value="0">
                </div>
                <div class="plan-input-group">
                    <label for="businessPlan">Business Plan:</label>
                    <input type="number" id="businessPlan" name="businessPlan" min="0" value="0">
                </div>
                <div class="plan-input-group">
                    <label for="personalPlan">Personal Plan:</label>
                    <input type="number" id="personalPlan" name="personalPlan" min="0" value="0">
                </div>
                <button type="submit" class="buttonnew">Purchase Plans</button>
            </form>

            <!-- Divider -->
            <hr class="divider">

            <!-- Total cost section -->
            <div id="totalSection">
                <h4>Total Cost Breakdown:</h4>
                <p><strong>Monthly Total:</strong> $<span id="monthlyTotal">0.00</span></p>
                <p><strong>Annual Pro-rata Total:</strong> $<span id="proRataTotal">0.00</span></p>
                <p><strong>Grand Total (Next Invoice):</strong> $<span id="grandTotal">0.00</span></p>
            </div>
            <div id="proRataExplanation" class="explanation">
                <p>Annual plans are charged on a pro-rata basis. The amount displayed is the prorated portion of the plan for the current billing period.</p>
            </div>
        </div>
        <div class="modal-footer_1">
            <button onclick="closeAddPlanModal()" class="buttonnew">Close</button>
        </div>
    </div>
</div>


<!-- partial -->
<script src='https://unpkg.com/phosphor-icons'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script  src="./script.js"></script>
<script>
    $(document).ready(function() {
        $('.invite-btn').click(function() {
            const index = $(this).data('index');
            const old_email = $(this).data('old');
            const plan = $(this).data('plan');
            const input = $('input[data-index="' + index + '"]').val();

            const data = {
                action: 'add_child_account',
                old_email: old_email,
                plan: plan,
                input: input

            };
            $.ajax({
                type: 'POST',
                url: 'controllers/accounts_controller.php', 
                data: data,
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    $('#response-modal-body').html(response);
                    $('#myModal').css('display', 'block');
                },
                error: function(error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });
        });
        const closeModalBtn = document.getElementById("closeModalBtn");
        const modal = document.getElementById("myModal");

        closeModalBtn.addEventListener("click", () => {
            modal.style.display = "none";
            location.reload();
        });

        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
                location.reload();
            }
        });
    });
    
    function openTutorialModal() {
        document.getElementById('tutorialModal').style.display = 'flex';
    }

    function closeTutorialModal() {
        document.getElementById('tutorialModal').style.display = 'none';
    }
    const prev = document.querySelector("#prev");
const next = document.querySelector("#next");

let carouselVp = document.querySelector("#carousel-vp");

let cCarouselInner = document.querySelector("#cCarousel-inner");
let carouselInnerWidth = cCarouselInner.getBoundingClientRect().width;

let leftValue = 0;

const totalMovementSize =
  parseFloat(
    document.querySelector(".cCarousel-item").getBoundingClientRect().width,
    10
  ) +
  parseFloat(
    window.getComputedStyle(cCarouselInner).getPropertyValue("gap"),
    10
  );

prev.addEventListener("click", () => {
  if (!leftValue == 0) {
    leftValue -= -totalMovementSize;
    cCarouselInner.style.left = leftValue + "px";
  }
});

next.addEventListener("click", () => {
  const carouselVpWidth = carouselVp.getBoundingClientRect().width;
  if (carouselInnerWidth - Math.abs(leftValue) > carouselVpWidth) {
    leftValue -= totalMovementSize;
    cCarouselInner.style.left = leftValue + "px";
  }
});

const mediaQuery510 = window.matchMedia("(max-width: 510px)");
const mediaQuery770 = window.matchMedia("(max-width: 770px)");

mediaQuery510.addEventListener("change", mediaManagement);
mediaQuery770.addEventListener("change", mediaManagement);

let oldViewportWidth = window.innerWidth;

function mediaManagement() {
  const newViewportWidth = window.innerWidth;

  if (leftValue <= -totalMovementSize && oldViewportWidth < newViewportWidth) {
    leftValue += totalMovementSize;
    cCarouselInner.style.left = leftValue + "px";
    oldViewportWidth = newViewportWidth;
  } else if (
    leftValue <= -totalMovementSize &&
    oldViewportWidth > newViewportWidth
  ) {
    leftValue -= totalMovementSize;
    cCarouselInner.style.left = leftValue + "px";
    oldViewportWidth = newViewportWidth;
  }
}

</script>
<script>
    $(document).ready(function() {
        $('.invite').on('click', function() {
            var buttonClicked = $(this);
            var dataIssoai = buttonClicked.data('issoai');
            var inputElement = buttonClicked.siblings('input[type="text"]');
             var inputPasswordElement = buttonClicked.siblings('input[type="password"]');
             var inputValue = inputElement.val();
             var inputPasswordValue = inputPasswordElement.val();
             var myVariable = dataIssoai;
             const data = {
                 action: 'add_child_account',
                 issoai: myVariable,
                 email: inputValue,
                 pass: inputPasswordValue
             };
           
            $.ajax({
                type: 'POST',
                url: 'controllers/accounts_api.php', 
                data: data,
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    $('#response-modal-body').html(response);
                    $('#myModal').css('display', 'block');
                },
                error: function(error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });
        });
    });
    $(document).ready(function() {
        $('.invite-kids').on('click', function() {
            var buttonClicked = $(this);
            var dataIssoai = buttonClicked.data('issoai');
            var inputElement = buttonClicked.siblings('input[type="text"]');
             var inputPasswordElement = buttonClicked.siblings('input[type="password"]');
             var inputValue = inputElement.val();
             var inputPasswordValue = inputPasswordElement.val();
             var myVariable = dataIssoai;
             const data = {
                 action: 'add_child_account_kids',
                 issoai: myVariable,
                 email: inputValue,
                 pass: inputPasswordValue,
                 repass: inputPasswordValue
             };
           
            $.ajax({
                type: 'POST',
                url: 'controllers/accounts_api.php', 
                data: data,
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    $('#response-modal-body').html(response);
                    $('#myModal').css('display', 'block');
                },
                error: function(error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });
        });
    });
    $(document).ready(function() {
        $('.remove-kids').on('click', function() {
            var buttonClicked = $(this);
            var dataIssoai = buttonClicked.data('issoai');
            var dataOld = buttonClicked.data('old');
            //console.log('Botão clicado com data-issoai:', dataIssoai);
            //console.log('Botão clicado com data-old:', dataOld);
            var myVariable = dataIssoai;

            const data = {
                action: 'remove_child_account',
                issoai: myVariable,
                old_email: dataOld
            };
            $.ajax({
                type: 'POST',
                url: 'controllers/accounts_api.php', 
                data: data,
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    $('#response-modal-body').html(response);
                    $('#myModal').css('display', 'block');
                },
                error: function(error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });

        });
    });
    $(document).ready(function() {
        $('.remove').on('click', function() {
            var buttonClicked = $(this);
            var dataIssoai = buttonClicked.data('issoai');
            var dataOld = buttonClicked.data('old');
            //console.log('Botão clicado com data-issoai:', dataIssoai);
            //console.log('Botão clicado com data-old:', dataOld);
            var myVariable = dataIssoai;

            const data = {
                action: 'remove_child_account',
                issoai: myVariable,
                old_email: dataOld
            };
            $.ajax({
                type: 'POST',
                url: 'controllers/accounts_api.php', 
                data: data,
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    $('#response-modal-body').html(response);
                    $('#myModal').css('display', 'block');
                },
                error: function(error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });

        });
    });
    $(document).ready(function() {
        $('.turnadmin').on('click', function() {
            var buttonClicked = $(this);
            var dataIssoai = buttonClicked.data('issoai');
            var myVariable = dataIssoai;
            
            const data = {
                action: 'turn_blank_into_master_account',
                issoai: myVariable,
            };

            $.ajax({
                type: 'POST',
                url: 'controllers/accounts_api.php', 
                data: data,
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    $('#response-modal-body').html(response);
                    $('#myModal').css('display', 'block');
                },
                error: function(error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });

        });
    });
    $(document).ready(function() {
        $('.turnadminprevassociated').on('click', function() {
            var buttonClicked = $(this);
            var dataIssoai = buttonClicked.data('issoai');
            var dataOld = buttonClicked.data('old');
            console.log('Botão clicado com data-issoai:', dataIssoai);
            console.log('Botão clicado com data-old:', dataOld);
            var issoai = dataIssoai;
            const data = {
                action: 'switch_child_and_master',
                issoai: issoai,
                dataOld: dataOld
            };
            $.ajax({
                type: 'POST',
                url: 'controllers/accounts_api.php', 
                data: data,
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    $('#response-modal-body').html(response);
                    $('#myModal').css('display', 'block');
                },
                error: function(error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });
        });
        
    });
</script>
<script>
function openAddPlanModal() {
    document.getElementById('addPlanModal').style.display = 'flex';
}

// Function to close the modal
function closeAddPlanModal() {
    document.getElementById('addPlanModal').style.display = 'none';
}
const planDetails = {
    5: { name: 'Kids Plan', price: 24.99, isAnnual: false },
    4: { name: 'Family Plan', price: 19.99, isAnnual: false },
    7: { name: 'Business Plan', price: 18.99, isAnnual: true },
    6: { name: 'Personal Plan', price: 15.99, isAnnual: false }
};

// Calculate pro-rata (assuming 30 days per month and 365 days in a year for simplicity)
function calculateProRata(planPrice) {
    const currentDate = new Date();
    const daysInYear = 365;
    const dayOfYear = Math.ceil((currentDate - new Date(currentDate.getFullYear(), 0, 1)) / 86400000);
    const remainingDays = daysInYear - dayOfYear;
    return (planPrice / 12) * (remainingDays / daysInYear);
}

// Update the total cost when the form inputs are changed
function updateTotal() {
    let monthlyTotal = 0;
    let proRataTotal = 0;

    // Get the selected number of plans
    const kidsPlanCount = parseInt($('#kidsPlan').val());
    const familyPlanCount = parseInt($('#familyPlan').val());
    const businessPlanCount = parseInt($('#businessPlan').val());
    const personalPlanCount = parseInt($('#personalPlan').val());

    // Add costs for each plan to the totals
    if (kidsPlanCount > 0) {
        monthlyTotal += planDetails[5].price * kidsPlanCount;
    }
    if (familyPlanCount > 0) {
        monthlyTotal += planDetails[4].price * familyPlanCount;
    }
    if (businessPlanCount > 0) {
        monthlyTotal += planDetails[7].price * familyPlanCount;
    }
    if (businessPlanCount > 0) {
        proRataTotal += calculateProRata(planDetails[7].price) * businessPlanCount;
    }
    if (personalPlanCount > 0) {
        monthlyTotal += planDetails[6].price * personalPlanCount;
    }

    // Update the totals on the page
    $('#monthlyTotal').text(monthlyTotal.toFixed(2));
    $('#proRataTotal').text(proRataTotal.toFixed(2));
    $('#grandTotal').text((monthlyTotal + proRataTotal).toFixed(2));
}

// Attach event listeners to the form inputs
$('#kidsPlan, #familyPlan, #businessPlan, #personalPlan').on('input', updateTotal);

// Initialize the total display
updateTotal();

$('#cartForm').submit(function(event) {
    event.preventDefault();

    const cart = [];

    const kidsPlanCount = parseInt($('#kidsPlan').val());
    const familyPlanCount = parseInt($('#familyPlan').val());
    const businessPlanCount = parseInt($('#businessPlan').val());
    const personalPlanCount = parseInt($('#personalPlan').val());

    if (kidsPlanCount > 0) {
        cart.push({ plan_id: 5, quantity: kidsPlanCount, plan_name: 'Kids Plan' });
    }
    if (familyPlanCount > 0) {
        cart.push({ plan_id: 4, quantity: familyPlanCount, plan_name: 'Family' });
    }
    if (businessPlanCount > 0) {
        cart.push({ plan_id: 7, quantity: businessPlanCount, plan_name: 'Business' });
    }
    if (personalPlanCount > 0) {
        cart.push({ plan_id: 6, quantity: personalPlanCount, plan_name: 'Personal' });
    }
    console.log(cart);
    $.ajax({
        type: 'POST',
        url: 'controllers/add_multiple_plans.php',
        data: { cart: cart },
        success: function(response) {
            alert('Plans added successfully!');
            closeAddPlanModal(); // Close the modal on success
            location.reload();
        },
        error: function(error) {
            console.error('Error processing the cart:', error);
        }
    });
});

</script>
</body>
</html>
