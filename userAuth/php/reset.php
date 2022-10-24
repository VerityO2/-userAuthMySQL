<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $newpassword = $_POST['password'];

    resetPassword($email, $newpassword);
}

function resetPassword($email, $newpassword)
{
    $dir = "..\storage\users.csv";
    $contents = file($dir);
    $yy = end($contents);

    foreach ($contents as $values => $value) {
        if (stristr($value, $yy)) {
            $value === $yy;
            $diropen = fopen($dir, "a+");
            unset($yy);
            fwrite($diropen, $newpassword);
            fclose($diropen);
        } else {
            echo "User does not exist";
            exit();
        }
    }
}
