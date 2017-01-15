<?php
require_once('../../includes/initialize.php');
global $session;
$session->logout();
redirect_to('login.php');

?>