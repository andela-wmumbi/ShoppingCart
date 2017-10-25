<?php
session_start();

function loggedIn()
{
    if(isset($_SESSION['currentUserId'])) {
      return true;
    }
      return false;
}

function logIn($userId)
{
   $_SESSION['currentUserId'] = $userId;
}
function logOut()
{
  session_destroy();
}
