<?php
include "./dbcon.php";

// ----funstion to get user id
session_start();

function getUserId(){
    $conn = dbconnect();
    $email= $_SESSION['email'];
    $sql = "SELECT id FROM users WHERE email = '$email';";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];
    return $user_id;
}



// Tocheck if entered exists in the databbase
function isValidEmail($email) {
    $conn = dbconnect();
    $sql = "SELECT email FROM users WHERE email='$email'";
    $queryResult = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($queryResult);
    if($count>0) {
        return true; 
        
    }
    else {
        return false;
    }
}


// -------- Check If login credentials are correct
function checkLoginCred($email,$password) {
    // Wont be needing this function when i am done.
    $conn = dbconnect();
    $sql = "SELECT password FROM users WHERE email='$email' ";
    $queryResult = mysqli_query($conn,$sql);
    $hashPass = mysqli_fetch_column($queryResult);
    $count = mysqli_num_rows($queryResult);
    return password_verify($password,$hashPass);
}

// ---------- Create a new user
function createUser($email,$password) {
    $conn = dbconnect();

    $securePass = encryptPassword($password);

    $sql = "INSERT INTO users (email,password) VALUES ('$email','$securePass')";
    $queryResult = mysqli_query($conn,$sql);
    return $queryResult;
}

// Create function to encrpt password
function encryptPassword($password) 
{
    return password_hash($password, PASSWORD_BCRYPT);
     
}
?>