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
  foreach ($plans_json_unserialized as $index => $plan) {
    $email = has_email_associated($plan['email']);

    if($email === true &&  $plan['is_master'] == 0){
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $hash_email = encrypt_lsp($plan['email']);
      $html_element .= '
                           <tr>
                              <td>'.$plan['plan_name'].'</td>
                              <td>'.$plan['email'].'</td>
                              <td>
                                <button class="button-error" data-psp='.$hash_plan_id.' data-psr='.$hash_email.' class="button-error">Cancel</button>
                              </td>
                          </tr>                
                      ';
    }
    if($email === false &&  $plan['is_master'] == 0){
      $hash_plan_id = encrypt_lsp($plan['plan_id']);
      $hash_email = encrypt_lsp('null');
      $html_element .= '
                           <tr>
                              <td>'.$plan['plan_name'].'</td>
                              <td> Not associated</td>
                              <td>
                                <button class="button-error" data-psp='.$hash_plan_id.' data-psr='.$hash_email.' class="button-error">Cancel</button>
                              </td>
                          </tr>                
                      ';
    }
  }
  return $html_element;
}
function get_plans(){
  $plans_json_unserialized = getPurchasedPlans();
  $accounts_partial = create_html_element($plans_json_unserialized);
  echo $accounts_partial;
}
?>