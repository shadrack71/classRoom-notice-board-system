<?php
session_start();

if ($_SESSION["name"] && $_SESSION["status"] == "logged in") {
    $user = $_SESSION["name"];
} else {
    header("index.php");
}
