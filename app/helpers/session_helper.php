<?php
session_start();

// Flash message helper
function flash($name = '', $message = '', $class = 'alert alert-success'){
  if(!empty($name)){
    // Create flash message
    if(!empty($message) && empty($_SESSION[$name])){
      $_SESSION[$name] = $message;
      $_SESSION[$name.'_class'] = $class;
    } elseif(empty($message) && !empty($_SESSION[$name])){
      // Display flash message if exists in session
      $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : '';
      echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
      unset($_SESSION[$name]);
      unset($_SESSION[$name.'_class']);
    }
  }
}

// Check if user is logged in
function isLoggedIn(){
  if(isset($_SESSION['user_id'])){
    return true;
  } else {
    return false;
  }
}

// Redirect helper
function redirect($page){
  header('location: ' . URLROOT . '/' . $page);
  exit;
} 