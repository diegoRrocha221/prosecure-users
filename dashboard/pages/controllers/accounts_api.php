<?php 
require_once '/var/www/html/controllers/inc.sessions.php';
session_start();
include("database_connection.php");
require_once '/var/www/html/controllers/hashing_lsp.php';
require_once '/var/www/html/users/dashboard/pages/controllers/maillers/_new_child_users.php';
require_once '/var/www/html/users/dashboard/pages/controllers/maillers/_remove_child_user_email.php';
require_once '/var/www/html/users/dashboard/pages/controllers/maillers/_switch_accounts_email.php';
require "../../../../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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

function getMasterName(){
  $db = new DatabaseConnection();
  $conn = $db->getConnection();
  $master_reference = $conn->real_escape_string($_SESSION['reference']);
  $sql = "SELECT name, lname FROM master_accounts WHERE reference_uuid = '$master_reference'";
  $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $full_name = $row['name']. ' ' . $row['lname'];
          return $full_name;
      }
    return null;    
}

function rollback_available_plans($child_email, $plan_id, $master){
  $plans_json_unserialized = getPurchasedPlans();
  foreach($plans_json_unserialized as &$item){
    if($item['plan_id'] === $plan_id && $item['is_master'] === 0 && $item['email'] === $child_email){
      $item['username'] = 'none';
      $item['email'] = 'none';
      break;
    }
  }
  $new_json_plans = json_encode($plans_json_unserialized);

  try {
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->getConnection();
    $sql = "UPDATE master_accounts SET purchased_plans = ? WHERE reference_uuid = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro ao preparar a instrução: " . $conn->error);
    }

    $pass = generateUniqueRandomCode();
    $stmt->bind_param("ss", $new_json_plans, $master);

    if ($stmt->execute()) {
        return 'rolledback';
    } else {
        throw new Exception("Erro ao inserir usuário: " . $stmt->error);
    }
  } catch (Exception $e) {
    error_log("Erro na função register_new_user: " . $e->getMessage());
    return $e->getMessage();
  }

}

function rollback_user($child_email){
  try {
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->getConnection();

    $sql = "DELETE FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro ao preparar a instrução: " . $conn->error);
    }

    $stmt->bind_param("s", $child_email);

    if ($stmt->execute()) {
        return 'deleted';
    } else {
        throw new Exception("Err " . $stmt->error);
    }
  } catch (Exception $e) {
    error_log("Err delete_user_by_email: " . $e->getMessage());
    return $e->getMessage();
  }
}



function verify_if_is_child_to_remove($child_email,$plan_id){
  $plans_json_unserialized = getPurchasedPlans();
  $count = 0;
  foreach($plans_json_unserialized as &$item){
    if($item['plan_id'] === $plan_id && $item['is_master'] === 0 && $item['email'] === $child_email &&  $item['email'] === $child_email){
      $count++;
      break;
    }
  }
  if($count > 0){
    return true;
  }
  return false;
}

function verify_if_child_exist($child_email){
  $db = new DatabaseConnection();
  $conn = $db->getConnection();
  $username = $conn->real_escape_string($_SESSION['username']);
  $sql = "SELECT email FROM users WHERE email = '$child_email'";
  $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          return true;
          return json_decode($purchasedPlansJson, true);
      }
    return false;
}


function send_deactivation_email_to_child($child_email){
  $title = "Notice";
  $name = $child_email;
  $subtitle = "Unfortunately your account has been disabled";
  $content = "The administrator of your plan has chosen to deactivate your account. If you believe this may be an error, please contact your administrator.
  <br>
  If you are interested in remaining protected, we have some plans that you may be interested in, just click on the link below to view them<br>
  <strong><a href='https://prosecurelsp.com/plans.php'>Access here</a></strong>";
  $html_content_email = remove_user_email_template($title,$name,$subtitle,$content);

  $mail = new PHPMailer(true);
  $mail->SMTPDebug = 0;
  $mail->isSMTP();
  $mail->Host = '172.31.255.82';
  $mail->SMTPAuth = false;
  $mail->Username = 'jcosta@prosecure.com';
  $mail->Port = 25;
  $mail->SMTPAutoTLS = false;
  $mail->setFrom('no-reply@prosecure.com', 'ProsecureLSP');
  $mail->addAddress($child_email);
  $mail->isHTML(true);
  $mail->Subject = 'Notice: account deactivated :(';
  $mail->Body = $html_content_email;
  if ($mail->Send()) {
      return true;
  } else {
      return false;
  }
}


if(isset($_POST['action']) && isset($_POST['old_email']) && isset($_POST['issoai']) && $_POST['action'] == 'remove_child_account'){
  $plan_id = intval(decrypt_lsp($_POST['issoai']));
  $email = decrypt_lsp($_POST['old_email']);
  $master = $_SESSION['reference'];


  if(!verify_if_is_child_to_remove($email, $plan_id)){
    echo "It is not possible to remove this user. If you have any questions, please contact our support team. LSP0030";
    exit();
  }

  if(!verify_if_child_exist($email)){
    echo "It is not possible to remove this user. If you have any questions, please contact our support team. LSP0031";
    exit();
  }
  if($plan_id !== 5){
  if(send_deactivation_email_to_child($email)){
    if(rollback_user($email) !== 'deleted'){
      echo "It is not possible to remove this user. If you have any questions, please contact our support team. LSP0032";
      exit();
    }
    if(rollback_available_plans($email, $plan_id, $master) !== 'rolledback'){
      echo "It is not possible to remove this user. If you have any questions, please contact our support team. LSP0033";
      exit();
    }
    echo "Account successfully removed";
    exit(); 
    }
  }else{
    if(rollback_user($email) !== 'deleted'){
      echo "It is not possible to remove this user. If you have any questions, please contact our support team. LSP0032";
      exit();
    }
    if(rollback_available_plans($email, $plan_id, $master) !== 'rolledback'){
      echo "It is not possible to remove this user. If you have any questions, please contact our support team. LSP0033";
      exit();
    }
    echo "Account successfully removed";
    exit();
  }

}

function verify_if_child_is_not_master_to_add($email){
  $db = new DatabaseConnection();
  $conn = $db->getConnection();
  $sql = "SELECT email FROM master_accounts WHERE email = '$email'";
  $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          return true;
      }
    return false;
}

function verify_if_account_not_exist($email){
  $db = new DatabaseConnection();
  $conn = $db->getConnection();
  $sql = "SELECT email FROM users WHERE email = '$email'";
  $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          return true;
      }
    return false;
}

function verify_if_is_valid_email($email){
  if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    return true;
  }else{
    return false;
  }
}

function register_invite($ssid, $master, $child_email, $link){
  try {
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->getConnection();


    $sql = "INSERT INTO tmp_invites (ssid, master_reference, email, invite_link, status_invite, created_at) VALUES (?, ?, ?, ? , 0, NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssss", $ssid, $master, $child_email, $link);
    if ($stmt->execute()) {
        return 'created';
    } else {
        throw new Exception("Erro ao inserir usuário: " . $stmt->error);
        return $stmt->error;
    }
  } catch (Exception $e) {
    error_log("Erro na função addUser: " . $e->getMessage());
    return $conn->error;
  }
}

function update_available_plans($master, $child_email, $plan_id){
  $plans_json_unserialized = getPurchasedPlans();
  foreach($plans_json_unserialized as &$item){
    if($item['plan_id'] === $plan_id && $item['is_master'] === 0 && $item['email'] === 'none'){
      $item['username'] = $child_email;
      $item['email'] = $child_email;
      break;
    }
  }
  $new_json_plans = json_encode($plans_json_unserialized);

  try {
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->getConnection();
    $sql = "UPDATE master_accounts SET purchased_plans = ? WHERE reference_uuid = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro ao preparar a instrução: " . $conn->error);
    }

    $pass = generateUniqueRandomCode();
    $stmt->bind_param("ss", $new_json_plans, $master);

    if ($stmt->execute()) {
        return 'created';
    } else {
        throw new Exception("Erro ao inserir usuário: " . $stmt->error);
    }
  } catch (Exception $e) {
    error_log("Erro na função register_new_user: " . $e->getMessage());
    return $e->getMessage();
  }

}

function register_new_user($master, $child_email, $plan_id, $pass) {
  try {
      $dbConnection = new DatabaseConnection();
      $conn = $dbConnection->getConnection();
      $sql = "INSERT INTO users (master_reference, username, email, passphrase, is_master, plan_id, is_active, created_at) VALUES (?, ?, ?, ?, 0, ?, 1, NOW())";

      $stmt = $conn->prepare($sql);
      if (!$stmt) {
          throw new Exception("Erro ao preparar a instrução: " . $conn->error);
      }

      $hashed_pass = hash('sha256', $pass);
      $stmt->bind_param("ssssi", $master, $child_email, $child_email, $hashed_pass, $plan_id);

      if ($stmt->execute()) {
          return 'created';
      } else {
          throw new Exception("Erro ao inserir usuário: " . $stmt->error);
      }
  } catch (Exception $e) {
      error_log("Erro na função register_new_user: " . $e->getMessage());
      return $e->getMessage();
  }
}




function send_invite_email($child_email, $link, $pass){
  $title = "Welcome to your plan";
  $name = $child_email;
  $master_name = getMasterName();
  $subtitle = "You have been invited by ". $master_name .", to protect your digital life with us";
  $content = "This invitation will not generate any costs for you at any time, you are just joining the current plan of ". $master_name.", 
              to accept the invitation and start using the most advanced protection for your data just click on the link below and activate your account
              <br>
              USERNAME:<br>
              <div style='background-color: #dddddd'><p style='font-size:20px;color:#000'>".$child_email."</p></div><br>
              PASSPHRASE:
              <div style='background-color: #dddddd'><p style='font-size:20px;color:#000'>".$pass."</p></div><br>
              <br> <a style='color:#fff; padding-bottom: 50px' href=".$link."><strong>Login</strong></a>";
  $html_content_email = new_user_email_template($title, $name, $subtitle, $content);

  $mail = new PHPMailer(true);
  $mail->SMTPDebug = 0;
  $mail->isSMTP();
  $mail->Host = '172.31.255.82';
  $mail->SMTPAuth = false;
  $mail->Username = 'jcosta@prosecure.com';
  $mail->Port = 25;
  $mail->SMTPAutoTLS = false;
  $mail->setFrom('no-reply@prosecure.com', 'ProsecureLSP');
  $mail->addAddress($child_email);
  $mail->isHTML(true);
  $mail->Subject = 'Welcome to your plan :)';
  $mail->Body = $html_content_email;
  if ($mail->Send()) {
      return true;
  } else {
      return false;
  }

}




if(isset($_POST['action']) && isset($_POST['issoai']) && isset($_POST['email']) && isset($_POST['pass']) && $_POST['action'] == 'add_child_account'){
  $plan_id = intval(decrypt_lsp($_POST['issoai']));
  $email = $_POST['email'];
  $master = $_SESSION['reference'];
  if(verify_if_child_is_not_master_to_add($email)){
    echo "This email is already linked to another master account";
    exit();
  }
  
  if(verify_if_account_not_exist($email)){
    echo "This email is already linked to another account";
    exit();
  }

  if(!verify_if_is_valid_email($email)){
    echo "Please use a valid e-mail";
    exit();
  }
  

  $ssid_tmp = generateUniqueRandomCode();
  $ssid = encrypt_lsp($ssid_tmp);

  $encoded_ssid = urlencode($ssid);
  $link='https://prosecurelsp.com/users/newuser/update_infos.php?ssid=' . $encoded_ssid;

  if( register_invite($ssid, $master, $email, $link) !== 'created'){
    echo "Service unavailable LSP043  ";
    exit();
  }


  if(update_available_plans($master, $email, $plan_id) !== 'created'){
    echo "Service unavailable LSP044";
    exit();
  }

  $pass = $_POST['pass'];
  if(register_new_user($master, $email, $plan_id, $pass) !== "created"){
    echo "Service unavailable LSP045";
    exit();
  }

  if(!send_invite_email($email, $link, $pass)){
    rollback_available_plans($email,$plan_id, $master);
    rollback_user($email);
    echo "It was not possible to send the invitation at the moment, please try again.
    LSP046";
    exit();
  }

  echo "Invitation sent, as soon as this invitation is accepted you will be notified by email";
  exit();
}


if(isset($_POST['action']) && isset($_POST['issoai']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['repass']) && $_POST['action'] == 'add_child_account_kids'){
  $plan_id = intval(decrypt_lsp($_POST['issoai']));
  $email = $_POST['email'];
  $master = $_SESSION['reference'];
  if(verify_if_child_is_not_master_to_add($email)){
    echo "This email is already linked to another master account";
    exit();
  }
  
  if(verify_if_account_not_exist($email)){
    echo "This email is already linked to another account";
    exit();
  }


  if(update_available_plans($master, $email, $plan_id) !== 'created'){
    echo "Service unavailable LSP044";
    exit();
  }

  $pass = $_POST['pass'];
  $repass = $_POST['repass'];
  if( $pass !== $repass){
    echo "Password doenst match";
    exit();    
  }
  if(register_new_user($master, $email, $plan_id, $pass) !== "created"){
    rollback_available_plans($email,$plan_id, $master);
    rollback_user($email);
    echo "Service unavailable LSP045";
    exit();
  }

  echo "User created, just login on your kids device";
  exit();
}




function verify_if_plan_is_blank($plan_id){
  $plans_json_unserialized = getPurchasedPlans();
  foreach($plans_json_unserialized as &$item){
    if($item['plan_id'] === $plan_id && $item['is_master'] === 0 && $item['email'] === 'none' && $item['username'] === 'none'){
      return true;
      break;
    }
  }
  return false;
}

function turn_current_admin_plan_blank($plan_id, $master_reference, $master_email, $master_username){
  $plans_json_unserialized = getPurchasedPlans();

  foreach($plans_json_unserialized as &$item){
    if($item['is_master'] === 1 && $item['email'] === $master_email && $item['username'] === $master_username){
      $item['is_master'] = 0;
      $item['email'] = 'none';
      $item['username'] = 'none';
      break;
    }
  }
  $plans_json_with_master_deassociated = json_encode($plans_json_unserialized);

  $plans_json_with_new_master_plan = associate_admin_new_plan($plans_json_with_master_deassociated,$plan_id, $master_reference, $master_email, $master_username);  

  return $plans_json_with_new_master_plan;
}

function associate_admin_new_plan($plans_json_with_master_deassociated,$plan_id, $master_reference, $master_email, $master_username){
  $plans_json_unserialized = json_decode($plans_json_with_master_deassociated, true);
  foreach($plans_json_unserialized as &$item){
    if($item['plan_id'] === $plan_id && $item['is_master'] === 0 && $item['email'] === 'none' && $item['username'] === 'none'){
      $item['is_master'] = 1;
      $item['email'] = $master_email;
      $item['username'] = $master_username;
      break;
    }
  }
  $new_json_plans_with_new_master_plan = json_encode($plans_json_unserialized);
  return $new_json_plans_with_new_master_plan;
}

function rewrite_purchased_plans($new_json_plans, $master_reference){
  try {
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->getConnection();
    $sql = "UPDATE master_accounts SET purchased_plans = ? WHERE reference_uuid = ? ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing query: " . $conn->error);
    }

    $pass = generateUniqueRandomCode();
    $stmt->bind_param("ss", $new_json_plans, $master_reference);

    if ($stmt->execute()) {
        return 'rewrite';
    } else {
        throw new Exception("Error inserting query: " . $stmt->error);
    }
} catch (Exception $e) {
    error_log("Error function rewrite_purchased_plans LSP051: " . $e->getMessage());
    return $e->getMessage();
}
}


if(isset($_POST['action']) && isset($_POST['issoai']) && $_POST['action'] == 'turn_blank_into_master_account'){
  $plan_id = intval(decrypt_lsp($_POST['issoai']));
  $master_reference = $_SESSION['reference'];
  $master_email = $_SESSION['email'];
  $master_username = $_SESSION['username'];   
  
  if(!verify_if_plan_is_blank($plan_id)){
    echo 'This plan is already linked to another account LSP050';
    exit();
  }

  $new_json_plans_with_new_master_plan = turn_current_admin_plan_blank($plan_id, $master_reference, $master_email, $master_username);

  if($new_json_plans_with_new_master_plan !== NULL){
    if(rewrite_purchased_plans($new_json_plans_with_new_master_plan, $master_reference) !== 'rewrite'){
      echo 'Service unavailable LSP052';
      exit();
    }
    echo 'Plan successfully updated';
  }

}

function attribute_plan_to_master($child_plan_id, $child_email, $master_email, $master_username){
  $plans_json_unserialized = getPurchasedPlans();
  foreach($plans_json_unserialized as &$item){
    if($item['plan_id'] === $child_plan_id && $item['is_master'] === 0 && $item['email'] === $child_email){
      $item['is_master'] = 1;
      $item['email'] = $master_email;
      $item['username'] = $master_username;
      break;
    }
  }
  $new_json_plans_multiple = json_encode($plans_json_unserialized);
  
  $new_json_plans_switched = switch_accounts($new_json_plans_multiple, $child_email, $master_email, $master_username, $child_plan_id);
  return $new_json_plans_switched;
}

function switch_accounts($new_json_plans_multiple, $child_email, $master_email, $master_username, $child_plan_id){
  $plans_json_unserialized = json_decode($new_json_plans_multiple, true);
  foreach($plans_json_unserialized as &$item){
    if($item['plan_id'] !== $child_plan_id && $item['is_master'] === 1 && $item['email'] === $master_email){
      $item['is_master'] = 0;
      $item['email'] = $child_email;
      $item['username'] = $child_email;
      break;
    }
  }
  $new_json_plans_switched = json_encode($plans_json_unserialized);
  return $new_json_plans_switched;
}

function send_email_to_child($new_json_plans, $child_email){
  $plans_json_unserialized = json_decode($new_json_plans, true);
  $new_child_plan_name = '';
  foreach($plans_json_unserialized as &$item){
    if($item['is_master'] === 0 && $item['email'] === $child_email){
      $new_child_plan_name = $item['plan_name'];
      break;
    }
  }
  $title = "NOTICE";
  $name = $child_email;
  $master_name = getMasterName();
  $subtitle = "Your plan administrator ". $master_name ." has changed your plan to ". $new_child_plan_name;
  $content = "if you think there has been a mistake please contact your administrator";
  $html_content_email = switch_accounts_email_template($title, $name, $subtitle, $content);

  $mail = new PHPMailer(true);
  $mail->SMTPDebug = 0;
  $mail->isSMTP();
  $mail->Host = '172.31.255.82';
  $mail->SMTPAuth = false;
  $mail->Username = 'jcosta@prosecure.com';
  $mail->Port = 25;
  $mail->SMTPAutoTLS = false;
  $mail->setFrom('no-reply@prosecure.com', 'ProsecureLSP');
  $mail->addAddress($child_email);
  $mail->isHTML(true);
  $mail->Subject = 'Notice';
  $mail->Body = $html_content_email;
  if ($mail->Send()) {
      return true;
  } else {
      return false;
  }
}

function switch_accounts_on_db($new_json_plans, $master_reference){
  try {
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->getConnection();
    $sql = "UPDATE master_accounts SET purchased_plans = ? WHERE reference_uuid = ? ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing query: " . $conn->error);
    }

    $pass = generateUniqueRandomCode();
    $stmt->bind_param("ss", $new_json_plans, $master_reference);

    if ($stmt->execute()) {
        return 'rewrite';
    } else {
        throw new Exception("Error inserting query: " . $stmt->error);
    }
} catch (Exception $e) {
    error_log("Error function rewrite_purchased_plans LSP065: " . $e->getMessage());
    return $e->getMessage();
}
}

if(isset($_POST['action']) && isset($_POST['dataOld']) && isset($_POST['issoai']) && $_POST['action'] == 'switch_child_and_master'){
  
  $master_email = $_SESSION['email'];
  $master_reference = $_SESSION['reference'];
  $master_username = $_SESSION['username'];

  $child_email = decrypt_lsp($_POST['dataOld']);
  $plan_id = intval(decrypt_lsp($_POST['issoai']));

  if(verify_if_child_is_not_master_to_add($child_email)){
    echo 'This plan already belongs to a master account LSP060';
    exit();
  }

  if(!verify_if_child_exist($child_email)){
    echo 'This child account does not exist LSP061';
    exit();
  }
  $new_json_plans = attribute_plan_to_master($plan_id, $child_email, $master_email, $master_username);
  if($new_json_plans !== NULL){
    if(!send_email_to_child($new_json_plans, $child_email)){
      echo 'Service unavailable LSP062';
      exit();
    }
    if(switch_accounts_on_db($new_json_plans,$master_reference) !== 'rewrite'){
      echo 'Service unavailable LSP063';
      exit();
    }
    echo 'Plans successfully switched. An email will be sent to '. $child_email;
  }
}
?>
