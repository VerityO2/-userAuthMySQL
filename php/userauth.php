<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country)
{
    //check if user with this email already exist in the database
    if (isset($_POST['register'])) {

        //create a connection variable using the db function in config.php
        $conn = db();

        trim($_POST['fullnames']);
        trim($_POST['email']);
        trim($_POST['gender']);
        trim($_POST['country']);
        trim($_POST['password']);

        $sqlq = "SELECT email FROM students WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        $id = " ";

        if (!mysqli_stmt_prepare($stmt, $sqlq)) {
            echo "<script> alert('Database/Query error.') </script>";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $qresult = mysqli_stmt_num_rows($stmt);

            if ($qresult > 0) {
                echo "<script> alert('Email address taken') </script>";
                exit();
            } else {
                $confirmedinpt = "INSERT INTO students (fullnames, country, email, gender, passwords) VALUES (?, ?, ?, ?, ?)";

                if (!mysqli_stmt_prepare($stmt, $confirmedinpt)) {
                    echo "<script> alert('Database/Query error..') </script>";
                    exit();
                } else {
                    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sssss", $fullnames, $country, $email, $gender, $hashedPass);
                    mysqli_stmt_execute($stmt);
                    header("Location: ..\dashboard.php");
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
            }
        }
    } else {
        header('Location: ..\userAuthMySQL\forms\register.html');
    }
}



//login users
function loginUser($email, $password)
{
    if (isset($_POST['login'])) {
        //create a connection variable using the db function in config.php
        $conn = db();

        $sqlq = "SELECT * FROM students WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sqlq)) {
            echo "<script> alert('Database/Query error..') </script>";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $getrslt = mysqli_stmt_get_result($stmt);
        }
        if ($rslt = mysqli_fetch_assoc($getrslt)) {
            $validate = password_verify($password, $rslt['passwords']);
            if ($validate == false) {
                echo "<script> alert('Password Mis-match') </script>";
                exit();
            } elseif ($validate == true) {
                session_start();
                $_SESSION['username'] = "Student" . $rslt['id'];
                header("Location: ..\dashboard.php");
                exit();
            } else {
                header("Location: ../forms/login.html?usererror");
                exit();
            }
        }
    } else {
        header("Location: ../forms/login.html?loginfirst");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
}


function resetPassword($email, $password)
{
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
}


function getusers()
{
    $conn = db();
    $sql = "SELECT * FROM students";
    $qryresult = mysqli_query($conn, $sql);
    echo "<html><head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1>
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'>   <th>ID</th>  <th>Full Names</th>   <th>Email</th>   <th>Gender</th>   <th>Country</th>  <th>Action</th>
    </tr></center>";

    if (mysqli_num_rows($qryresult) > 0) {
        while ($data = mysqli_fetch_assoc($qryresult)) {

            //show data
            echo "<tr style='height: 30px; text-align: center'> " . "
            <td style='width: 50px; background: blue'>" . $data['id'] . "</td>
            <td style='width: 160px'>" . $data['fullnames'] .  "</td>
            <td style='width: 160px'>" . $data['email'] . "</td>
            <td style='width: 160px'>" . $data['gender'] .  "</td>
            <td style='width: 160px'>" . $data['country'] . "</td>
            
            <form action='action.php' method='post'><td> <button type='submit' name='delete'
            value=" . $data['id'] . "> DELETE </button>" . "</tr>";
        }
        echo "</table></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}


function deleteaccount($id)
{

    if (isset($_POST['delete'])) {
        //delete user with the given id from the database  
        $conn = db();
        $sqli = "DELETE FROM students WHERE id= $id";
        $qryresulti = mysqli_query($conn, $sqli);
        echo "<script> alert('Student Deleted Successfully') </script>";
    }
}



function logout()
{
    //logout user
    session_start();
    if (isset($_SESSION['username'])) {
        session_destroy();
        header("Location: ../forms/login.html?loggedout");
    } else {
        header("Location: ../dashboard.php");
    }
}
