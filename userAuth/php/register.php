<?php
if (isset($_POST['submit'])) {
    $username = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    registerUser($username, $email, $password);
}

/*since user.csv is not a database there's no need for database connection, prepared statement and hashing of password*/

function registerUser($username, $email, $password)
{
    $array = [$username, $email, $password];
    $savedata = fopen("..\storage\users.csv", "a");
    fputcsv($savedata, $array);
    fclose($savedata);
    echo "User Successfully registered " . ('<a href="..\forms\login.html">Login</a>');
}
