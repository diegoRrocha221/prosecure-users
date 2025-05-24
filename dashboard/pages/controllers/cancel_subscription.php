<?php
require_once '/var/www/html/controllers/inc.sessions.php';
session_start(); 
include("database_connection.php");
require_once '/var/www/html/users/dashboard/pages/controllers/maillers/_cancell_email_master.php';
require "../../../../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function deactive_master($conn, $master_reference, $master_email){
  try {
    $sql = "UPDATE users SET is_active = ? WHERE master_reference = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing query: " . $conn->error);
    }
    $status = 2;
    $stmt->bind_param("iss", $status, $master_reference, $master_email);

    if ($stmt->execute()) {
        return true;
    } else {
        throw new Exception("Error executing query: " . $stmt->error);
    }
  } catch (Exception $e) {
    error_log("Error in deactive_master: " . $e->getMessage());
    return false;
  }
}

function get_master_childs($conn, $master_reference) {
  $username = $conn->real_escape_string($master_reference);
  $sql = "SELECT email, plan_id FROM users WHERE master_reference = '$master_reference'";
  $result = $conn->query($sql);

  $childs = array();

  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $childs[] = array(
              'email' => $row['email'],
              'plan_id' => $row['plan_id']
          );
      }
  }

  return json_encode($childs);
}

function insert_log($conn, $master_username, $master_email, $childs){
  try {
    $sql = "INSERT INTO cancel_logs(master_username, master_email, master_childs) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing query: " . $conn->error);
    }
    $stmt->bind_param("sss", $master_username, $master_email, $childs);

    if ($stmt->execute()) {
        return true;
    } else {
        throw new Exception("Error executing query: " . $stmt->error);
    }
  } catch (Exception $e) {
    error_log("Error in insert_log: " . $e->getMessage());
    return false;
  }
}

function deactive_childs($conn, $master_reference){
  try {
    $sql = "DELETE FROM users WHERE master_reference = ? AND is_master = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing query: " . $conn->error);
    }
    $is_master = 0;
    $stmt->bind_param("si", $master_reference, $is_master);

    if ($stmt->execute()) {
        return true;
    } else {
        throw new Exception("Error executing query: " . $stmt->error);
    }
  } catch (Exception $e) {
    error_log("Error in deactive_childs: " . $e->getMessage());
    return false;
  }
}

function send_notification($master_email){
  $title = "Subscription Cancelled";
  $name = $master_email;
  $subtitle = "We're sorry you left our service";
  $content = "We'll always be here when you need us, and you can reactivate your subscription at any time";
  $mail_content = cancel_master_subscription_email($title, $name, $subtitle, $content);

  $mail = new PHPMailer(true);
  $mail->SMTPDebug = 0;
  $mail->isSMTP();
  $mail->Host = '172.31.255.82';
  $mail->SMTPAuth = false;
  $mail->Username = 'jcosta@prosecure.com';
  $mail->Port = 25;
  $mail->SMTPAutoTLS = false;
  $mail->setFrom('no-reply@prosecure.com', 'ProsecureLSP');
  $mail->addAddress($master_email);
  $mail->isHTML(true);
  $mail->Subject = 'Subscription Cancelled :(';
  $mail->Body = $mail_content;
  if ($mail->Send()) {
      return true;
  } else {
      error_log("Error sending email: " . $mail->ErrorInfo);
      return false;
  }
}

function destroy_current_session(){
  session_unset();
  session_destroy();
}

function rollback($conn) {
  $conn->rollback();
}

if(isset($_POST['action']) && $_POST['action'] === 'cancel'){
  $dbConnection = new DatabaseConnection();
  $conn = $dbConnection->getConnection();
  $conn->begin_transaction();

  $master_email = $_SESSION['email'];
  $master_username = $_SESSION['username'];
  $master_reference = $_SESSION['reference'];

  try {
    if(!deactive_master($conn, $master_reference, $master_email)){
      rollback($conn);
      echo 'Service Unavailable';
      exit();
    }

    $childs = get_master_childs($conn, $master_reference);

    if(!insert_log($conn, $master_username, $master_email, $childs)){
      rollback($conn);
      echo 'Service Unavailable';
      exit();
    }

    if(!deactive_childs($conn, $master_reference)){
      rollback($conn);
      echo 'Service Unavailable';
      exit();
    }

    if(!send_notification($master_email)){
      rollback($conn);
      echo 'Service Unavailable';
      exit();
    }

    $conn->commit();
    destroy_current_session();
    echo "Subscription Cancelled";

  } catch (Exception $e) {
    rollback($conn);
    error_log("Error in cancellation process: " . $e->getMessage());
    echo 'Service Unavailable';
  }
}
?>
