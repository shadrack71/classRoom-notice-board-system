<?php
// session start
session_start();
$conn = mysqli_connect("localhost", "root", "", "classnotice");
// filter out the method that is not in use
switch ($_GET["method"]) {
    case "postnotice":
        postnotice($conn);
        break;
    case "getnotice":
        getnotice($conn);
        break;
    case "memberpostnotice":
        memberpostnotice($conn);
        break;
    case "getmemberrequests":
        getmemberrequests($conn);
        break;
}

function postnotice($conn)
{
    if (isset($_GET["notice"]) && isset($_GET["dataValue"])) {
        $notice = mysqli_real_escape_string($conn, $_GET["notice"]);
        $dataValue = mysqli_real_escape_string($conn, $_GET["dataValue"]);
        $status = "valid";
        $noticeSql = "INSERT INTO noticemsg(noticemsg,validDate,status) VALUES ('$notice','$dataValue','$status')";
        $noticeQuery = mysqli_query($conn, $noticeSql);
        if ($noticeQuery) {
            echo "noticeAdded";
        } else {
            echo "error occurred please try again";
        }
    }
}
function memberpostnotice($conn)
{
    if (isset($_GET["shortnoteMsg"]) && isset($_GET["username"])) {
        $shortnoteMsg = mysqli_real_escape_string($conn, $_GET["shortnoteMsg"]);
        $username = mysqli_real_escape_string($conn, $_GET["username"]);
        $token = bin2hex(random_bytes(10));
        $noticeSql = "INSERT INTO  memberrequest(FromMember,msg,token) VALUES ('$username','$shortnoteMsg','$token')";
        $noticeQuery = mysqli_query($conn, $noticeSql);
        if ($noticeQuery) {
            echo "noticeAdded";
        } else {
            echo "error occurred please try again";
        }
    }
}
function getmemberrequests($conn)
{
    $query = "SELECT* FROM memberrequest";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (count($row_data) > 0) {
            echo json_encode($row_data);
        } else {
            echo json_encode("no results found");
        }
    } else {
        echo json_encode("error occurred please try again");
    }
}

function getnotice($conn)
{
    $query = "SELECT id,noticemsg,postedDate,validDate,status FROM noticemsg";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (count($row_data) > 0) {
            echo json_encode($row_data);
        } else {
            echo json_encode("no results found");
        }
    } else {
        echo json_encode("error occurred please try again");
    }
}
mysqli_close($conn);
