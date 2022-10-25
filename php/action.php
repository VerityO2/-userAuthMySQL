<?php
include "userauth.php";
include_once "../config.php";



switch (true) {

    case isset($_POST['register']):
        //extract the $_POST array values for name, password and email

        $fullnames = $_POST['fullnames'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $country = $_POST['country'];
        $password = $_POST['password'];

        registerUser($fullnames, $email, $password, $gender, $country);
        break;



    case isset($_POST['login']):

        $email =  trim($_POST['email']);
        $password = trim($_POST['password']);

        loginUser($email, $password);
        break;



    case isset($_POST["reset"]):
        $email = trim($_POST['email']);
        $passwordii = trim($_POST['password']);

        resetPassword($email, $passwordii);
        break;



    case isset($_POST["delete"]):
        $id = $_POST['delete'];

        deleteaccount($id);
        break;



    case isset($_GET["all"]):

        getusers();
        break;
}
