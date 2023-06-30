<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "classnotice");
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $name = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $sql = "SELECT * FROM classmember WHERE NAME = '$name' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $result = mysqli_fetch_assoc($query);
        if ($result) {
            $upassword = $result["PASSWORD"];
            if (password_verify($password, $upassword)) {
                $uname = $result["NAME"];
                $urole = $result["ROLE"];
                if ($urole == "admin") {
                    $_SESSION["status"] = "logged in";
                    $_SESSION["name"] = $uname;
                    $_SESSION["role"] = $urole;
                    echo "admin.php";
                } else {
                    $_SESSION["status"] = "logged in";
                    $_SESSION["name"] = $uname;
                    $_SESSION["role"] = $urole;
                    echo "memberindex.php";
                }
            } else {
                echo "wrong password!";
            }
        } else {
            echo "the username is not found  in the database";
        }
    } else {
        echo "error occurred,please try again";
    }
} else {
    echo "please enter your name and correct password";
}
