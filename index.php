<?php

session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: app/view/dashboard.php');
    exit();
} else {
    header('Location: app/view/login.php');
    exit();
}
