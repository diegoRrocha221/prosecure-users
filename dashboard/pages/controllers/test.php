<?php
require_once '/var/www/html/controllers/inc.sessions.php';
session_start();
include("database_connection.php");
require_once '/var/www/html/controllers/hashing_lsp.php';


function getPurchasedPlans(){
  $db = new DatabaseConnection();
  $conn = $db->getConnection();
  $username = $conn->real_escape_string($_SESSION['username']);
  $sql = "SELECT purchased_plans FROM master_accounts WHERE username = '$username'";
  $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $purchasedPlansJson = $row['purchased_plans'];
          return json_decode($purchasedPlansJson, true);
      }
    return null;    
}


function has_email_associated($email_json_node){
  return $email_json_node !== 'none';
}

function create_html_element($plans_json_unserialized){
  $master_plan_id = 0;
  $html_element = '';
  $c = ' ';
  foreach ($plans_json_unserialized as $index => $plan) {
    $email = has_email_associated($plan['email']);
    if($plan['is_master'] === 1 && $email === true){
      $master_plan_id = $plan['plan_id'];
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $hash_old_email = encrypt_lsp($plan['email']);
      $html_element .= '
                      <article class="cCarousel-item"> 
                      <div class="infos">
                      <h4 style="color:red; ">Current admin plan</h4><br>
                      <h2 style="transform: translateY(-40px)" class="plan-title">'.$plan['plan_name'].'</h2>
                      <p style="transform: translateY(-40px)">To change the type of plan for your admin account, press the link to administrator button on the desired plan.</p>
                      <input style="transform: translateY(-10px)" type="text" placeholder="" value="'.$plan['email'].'" disabled>
                      <button style="transform: translateY(-10px)" class="buttonnew">Settings</button>
                      </div>
                      </article>                
                      ';
    break;  
    }

  }
  
  foreach ($plans_json_unserialized as $index => $plan) {
    $email = has_email_associated($plan['email']);

    if($email === true &&  $plan['is_master'] == 0 && $plan['plan_id'] !== $master_plan_id && $plan['plan_id'] !== 5){
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $hash_old_email = encrypt_lsp($plan['email']);
      $html_element .= '
                      <article class="cCarousel-item"> 
                      <div class="infos">
                      <h2 class="plan-title">'.$plan['plan_name'].'</h2>
                      <p>To assign this plan to a device, enter a unique email address and password below. An email will be sent to that address with an installation guide.</p>
                      <input type="text" placeholder="E-mail to invite" value="'.$plan['email'].'" disabled>
                      <button data-index="' . $index . '" data-issoai='.$hash_plan_id.' data-old="'.$hash_old_email.'" class="remove" style="background-color:red">Remove</button>
                      <button data-index="' . $index . '" data-issoai='.$hash_plan_id.' data-old="'.$hash_old_email.'" class="turnadminprevassociated" style="background-color:blue">Link to administrator</button>                      
                      </div>
                      </article>                    
                      ';
    }
    if($email === true &&  $plan['is_master'] == 0 && $plan['plan_id'] === $master_plan_id){
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $hash_old_email = encrypt_lsp($plan['email']);
      $html_element .= '
                      <article class="cCarousel-item"> 
                      <div class="infos">
                      <h2 class="plan-title">'.$plan['plan_name'].'</h2>
                      <p>To assign this plan to a device, enter a unique email address and password below. An email will be sent to that address with an installation guide.</p>
                      <input type="text" placeholder="E-mail to invite" value="'.$plan['email'].'" disabled>
                      <button data-index="' . $index . '" data-issoai='.$hash_plan_id.' data-old="'.$hash_old_email.'" class="remove" style="background-color:red">Remove</button>                      
                      </div>
                      </article>                    
                      ';
    }
    if($email === true &&  $plan['is_master'] == 0 && $plan['plan_id'] === 5){
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $hash_old_email = encrypt_lsp($plan['username']);
      $html_element .= '
                      <article class="cCarousel-item"> 
                      <div class="infos">
                      <h2 class="plan-title">'.$plan['plan_name'].'</h2>
                      <p>To set up this plan, simply create a username and password. Then login to the prosecurelsp website from your child’s device. You will find and install guide once you log in. If you need it, we have a handy guide for this plan. <a href="">Guide</a></p>
                      <input type="text" placeholder="E-mail to invite" value="'.$plan['username'].'" disabled>
                      <button data-index="' . $index . '" data-issoai='.$hash_plan_id.' data-old="'.$hash_old_email.'" class="remove-kids" style="background-color:red">Remove</button>                      
                      </div>
                      </article>                    
                      ';
    }
    if($email === false && $plan['plan_id'] !== $master_plan_id && $plan['plan_id'] !== 5){
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $html_element .= '
                      <article class="cCarousel-item"> 
                      <div class="infos">
                      <h2 class="plan-title">'.$plan['plan_name'].'</h2>
                      <p>To assign this plan to a device, enter a unique email address and password below. An email will be sent to that address with an installation guide.</p>
                      <input type="text" placeholder="E-mail to invite">
                      <input type="password" placeholder="Password">
                      <button data-index="' . $index . '" data-issoai='.$hash_plan_id.' class="invite">Invite</button>
                      <button data-index="' . $index . '" data-issoai='.$hash_plan_id.' class="turnadmin" style="background-color:blue">Link to administrator</button>
                      
                      </div>
                      </article>                    
                      ';
    }
    if($email === false && $plan['plan_id'] === $master_plan_id){
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $html_element .= '
                      <article class="cCarousel-item"> 
                      <div class="infos">
                      <h2 class="plan-title">'.$plan['plan_name'].'</h2>
                      <p>To assign this plan to a device, enter a unique email address and password below. An email will be sent to that address with an installation guide.</p>
                      <input type="text" placeholder="E-mail to invite">
                      <input type="password" placeholder="Password">
                      <button data-index="' . $index . '" data-issoai='.$hash_plan_id.' class="invite">Invite</button>
                      </div>
                      </article>                    
                      ';
    }
    if($email === false && $plan['plan_id'] === 5){
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $html_element .= '
                      <article class="cCarousel-item"> 
                      <div class="infos">
                      <h2 class="plan-title">'.$plan['plan_name'].'</h2>
                      <p>To set up this plan, simply create a username and password. Then login to the prosecurelsp website from your child’s device. You will find and install guide once you log in. If you need it, we have a handy guide for this plan. <a href="">Guide</a></p>
                      <input type="text" placeholder="Username">
                      <input type="password" placeholder="Password">
                      <button data-index="' . $index . '" data-issoai='.$hash_plan_id.' class="invite-kids">Create</button>
                      </div>
                      </article>                    
                      ';
    }
  }
  
  return $html_element;

}





function get_accounts(){
    $plans_json_unserialized = getPurchasedPlans();
    $accounts_partial = create_html_element($plans_json_unserialized);
    echo $accounts_partial;
}
?>