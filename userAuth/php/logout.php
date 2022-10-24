<?php

function logout()
{
    if (!isset($_SESSION['username'])) {
        header('Location: ..\dashboard.php?still?loggedin');
        exit();
    } else {
        session_destroy();
        header('Location: ..\forms\login.html?loggedout');
    }
}

logout();
?>