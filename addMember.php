<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "classnotice");
if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["pwd1"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pwd = mysqli_real_escape_string($conn, $_POST["pwd1"]);
    $passwordhash = password_hash($pwd, PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    $token = bin2hex(random_bytes(10));
    $checkNameQuery = "SELECT (NAME) FROM classmember WHERE NAME = '$username'";
    $checkNameSql = mysqli_query($conn, $checkNameQuery);
    //check if the user already exists IN the database
    // $checkExistQuery = "SELECT (EMAIL) FROM classmember WHERE  EMAIL = '$email";
    // $checkExistSql = mysqli_query($conn, $checkExistQuery);
    $row = mysqli_fetch_row($checkNameSql);
    // $rowExist = mysqli_fetch_row($checkExistSql);
    if ($row > 0) {
        echo "usernameError";
        // echo " the username is already in use";
        // } else if ($rowExist > 0) {
        //     echo " the email is already in use";
    } else {
        $insertSql = "INSERT INTO classmember(NAME,EMAIL,PASSWORD,ROLE,TOKEN) VALUES ('$username','$email','$passwordhash','$role','$token')";
        $insertQuery = mysqli_query($conn, $insertSql);
        if ($insertQuery) {
            echo "memberAdded";
            // echo " member details has been added to database";
        } else {
            echo "AddmemberError";
            // echo " error occurred while adding the member please try again" . mysqli_error($conn);
        }
    }
} else {
    echo "default";
}
mysqli_close($conn);
