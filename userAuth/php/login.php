<?php
if (isset($_POST['submit'])) {
    $username = trim($_POST['email']);
    $password = trim($_POST['password']);

    loginUser($username, $password);
}

function loginUser($username, $password)
{
    $dir = "..\storage\users.csv";
    $inn = array($username, $password);
    $getcont = file($dir);

    if (in_array($inn, $getcont)) {
        session_start();
        $_SESSION['username'] = $_POST['email'];
        header('Location: ..\dashboard.php?success');
    } else {
        header('Location: ..\forms\login.html?error');
    }
}
