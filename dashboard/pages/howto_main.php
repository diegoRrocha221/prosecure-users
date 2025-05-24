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
  font-size:20px;      
  font-weight:bold;
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
.videos-container {
    max-height: 400px; 
    overflow-y: auto; 
    margin-bottom: 20px; 
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
  cursor: pointer;
}
@media (max-width: 768px) {
    .helpful-video {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-bottom: 20px;
    }

    .helpful-video .video-info {
        margin-top: 20px; /* Adiciona espaço entre a imagem e o título */
    }
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
                                        Tutorials
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
                            <span style="color:#fff;">How to Videos</span>
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
                                        <span>Invoices</span>
                                </a>
                                <a href="./accounts.php">
                                        <i class="ph-swap"></i>
                                        <span>Manage Devices</span>
                                </a>
                                <a href="./howto_main.php">
                                        <i class="ph-file-text"></i>
                                        <span style="color:#fff;">How to Videos</span>
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
                <style>
                  .mainsec{
                    display: grid;
                    grid-template-columns: 2fr 1fr; /* Duas colunas de largura igual */
                    gap: 10px;
                  }
                  @media (max-width: 600px) { /* Ajuste o valor conforme necessário */
                    .mainsec {
                      grid-template-columns: 1fr; /* Muda para uma coluna única */
                      grid-template-rows: auto auto; /* Ajusta a altura das linhas automaticamente */
                    }
                  }
                </style>
                <div class="app-body-main-content">
                        <div class="mainsec">
                          <section class="transfer-section">
                                  <div class="transfer-section-header">
                                          <h2>Helpful Videos</h2>
  
                                  </div>
                                  <div class="videos-container">
                                  <div class="helpful-video" id="video4" data-video-id="PlnB7WTqOUo">
                                    <div class="video-info">
                                      <h3>How to install Cybergate agent on Android</h3>
                                      <p>In this video you will see a brief tutorial on how to install<br> it on your client in a simple and fast way</p>
                                    </div>
                                    <div class="video-thumbnail">
                                      <img src="./install_and.png" alt="Thumbnail do Vídeo 2">
                                    </div>
                                  </div>
                                  <div class="helpful-video" id="video3" data-video-id="p9IfYyS0qDs">
                                    <div class="video-info">
                                      <h3>How to install Cybergate agent on IOS</h3>
                                      <p>In this video you will see a brief tutorial on how to install<br> it on your client in a simple and fast way</p>
                                    </div>
                                    <div class="video-thumbnail">
                                      <img src="./install_ios.png" alt="Thumbnail do Vídeo 2">
                                    </div>
                                  </div>
                                  <div class="helpful-video" id="video1" data-video-id="FR6ylaQZI1o">
                                  <div class="video-info">
                                      <h3>How to install Cybergate agent on Windows</h3>
                                      <p>In this video you will see a brief tutorial on how to install<br> it on your client in a simple and fast way</p>
                                    </div>
                                    <div class="video-thumbnail">
                                      <img src="./install.png" alt="Thumbnail do Vídeo 1">
                                    </div>
                                  </div>
                                  <div class="helpful-video" id="video4" data-video-id="tR1HXQ6_Jfw">
                                    <div class="video-info">
                                      <h3>How to uninstall Cybergate agent on Android</h3>
                                      <p>In this video you will see a brief tutorial on how to uninstall<br> it on your client in a simple and fast way</p>
                                    </div>
                                    <div class="video-thumbnail">
                                      <img src="./uninstall_and.png" alt="Thumbnail do Vídeo 2">
                                    </div>
                                  </div>
                                  <div class="helpful-video" id="video4" data-video-id="QKfdxCrWJJ0">
                                    <div class="video-info">
                                      <h3>How to uninstall Cybergate agent on IOS</h3>
                                      <p>In this video you will see a brief tutorial on how to uninstall<br> it on your client in a simple and fast way</p>
                                    </div>
                                    <div class="video-thumbnail">
                                      <img src="./uninstall_ios.png" alt="Thumbnail do Vídeo 2">
                                    </div>
                                  </div>
                                  <div class="helpful-video" id="video2" data-video-id="AjfCo5UjHWI">
                                    <div class="video-info">
                                      <h3>How to uninstall Cybergate agent on Windows</h3>
                                      <p>In this video you will see a brief tutorial on how to uninstall<br> it on your client in a simple and fast way</p>
                                    </div>
                                    <div class="video-thumbnail">
                                      <img src="./uninstall.png" alt="Thumbnail do Vídeo 2">
                                    </div>
                                  </div>
                                  </div>
                          </section>
                          <section>
                            <div style="margin-top: 2.5rem;font-size: 1.5rem;">
                                <h2>Written Tutorials</h2>
                                <article class="tile" style="margin-top:10px;">
					                      	<div class="tile-header">
					                      		<i style="color: #25364D" class="ph-lightning-light"></i>
					                      		<h3>
					                      			<span style="color: #25364D">Setup GlobalProtect</span>
					                      			<span style="color: #25364D">Mobile devices</span>
					                      		</h3>
					                      	</div>
					                      	<a href="./desktop_install.php">
					                      		<span style="color: #25364D">Go to tutorial</span>
					                      		<span class="icon-button">
					                      			<i style="color: #25364D" class="ph-caret-right-bold"></i>
					                      		</span>
					                      	</a>
					                      </article>
					                      <article class="tile" style="margin-top:20px;">
					                      	<div class="tile-header">
					                      		<i style="color: #25364D" class="ph-fire-simple-light"></i>
					                      		<h3>
					                      			<span style="color: #25364D">Setup GlobalProtect</span>
					                      			<span style="color: #25364D">Desktop Devices</span>
					                      		</h3>
					                      	</div>
					                      	<a href="./mobile_install.php">
					                      		<span style="color: #25364D">Go to tutorial</span>
					                      		<span class="icon-button">
					                      			<i style="color: #25364D" class="ph-caret-right-bold"></i>
					                      		</span>
					                      	</a>
					                      </article>
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
        var videoElements = document.querySelectorAll('.helpful-video');

        videoElements.forEach(function(videoElement) {
          videoElement.addEventListener('click', function() {
            var videoId = this.getAttribute('data-video-id');
            var modal = document.getElementById('videoModal');
            var modalContent = modal.querySelector('.modal-content');

            modalContent.innerHTML = `
              <span class="close">&times;</span>
              <!-- Adicione o vídeo aqui, substituindo o iframe vazio -->
              <iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>
            `;
        
            modal.style.display = 'block';
          });
        });
        
        document.querySelector('.close').addEventListener('click', function() {
          var modal = document.getElementById('videoModal');
          modal.style.display = 'none';
        });

        window.addEventListener('click', function(event) {
          var modal = document.getElementById('videoModal');
          if (event.target == modal) {
            modal.style.display = 'none';
          }
        });
  </script>
</body>
</html>
