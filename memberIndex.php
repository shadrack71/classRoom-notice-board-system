<?php
session_start();
if (isset($_SESSION["status"]) && $_SESSION["name"]) {
    $user = $_SESSION["name"];
    $urole = $_SESSION["role"];
} else {
    header("location:index.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>classRoom NoticeBoard</title>
    <link rel="stylesheet" type="text/css" href="style01.css">
</head>

<body>
    <header class="header">
        <h1>CLASSROM NOTICEBOARD</h1>
    </header>
    <div id="infoHeader">
        <button id="notificationBtn">notification</button>
        <p id="nameInfo">
            <?php echo $user; ?>
        </p>
        <button id="logout">logout</button>
    </div>
    <div id="notificationModel" style="background-color: rgb(23, 143, 247);
    width: 20%;
    height: auto;
    padding: 5px; display:none; position:absolute;">

    </div>
    <div class="title">
        <h3>Post shortnote</h3>
    </div>
    <div class="noticeContainer">
        <form id="noticeForm" method="get" name="notice">

            <input type="text" placeholder="write the shortnote here...." id="shortnoteMsg" name="shortnoteMsg" maxlength="50">

            <button type="submit" id="publishBtn">post</button>
        </form>
        <p class="saved" style="color: green;
    text-align:  center;
    font-weight: bold;  display:none;">short notice is saved </p>
        <hr class="line">
        <button id="viewNotice">view notices</button>

        <div id="postNotices">
            <!-- <div class="noticecontainer">
                <p class="noticeDetails">tommorrow we have class at clb room 104 at 10am</p>
                <span class="datePosted"><b>datePosted:</b> 20:35 9/2/2023</span><br>
                <span class="validDate"><b>validDate:</b>00:00 13/2/2023</span>
                <br>
                <p style=" margin: 2px;
        padding: 5px;
        width: 70px;
        border: 1px solid rgb(248, 245, 245);
        border-radius: 5px;">passed</p>

            </div> -->
        </div>


    </div>
    <script>
        document.getElementById("logout").addEventListener("click", function() {
            location.href = "logout.php";
        });


        document.getElementById("viewNotice").addEventListener("click", function() {
            let method = "getnotice";
            const url = `method=${method}`;
            let xhr = new XMLHttpRequest();
            var html = " ";
            var postContainer = document.getElementById("postNotices");
            var trackIndex;
            xhr.open("GET", "addnotice.php?" + url, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    let responejson = JSON.parse(this.responseText);
                    // add the response if ther is an error
                    if (typeof responejson === 'object') {

                        // let temp = responejson[1];
                        // console.log(temp);
                        responejson.forEach(function(val, index, array) {
                            // console.log(val);
                            // console.log(index);
                            html += "<div class='noticecontainer'>";
                            html += "<p class='noticeDetails'>" + val.noticemsg + "</p>";
                            html += "<span class='datePosted'>date posted: " + val.postedDate + "</span>";
                            html += "<span class='           validDate'>valid date: " + val.validDate + "</span>";
                            html += "<span class='status'>status: " + val.status + "</span>";
                            // html += "<p style ='margin:2px;padding:5px;width:70px;border:1px solid rgb(248,245,245);border-radius:5px;'>passed</p>";
                            html += "<input type ='hidden'" + "value =" + val.id + " >";
                            html += "</br>";
                            html += "<hr>";
                            html += "</div>";
                            postContainer.innerHTML = html;

                        })


                    } else {
                        postContainer.innerHTML = `<p> ${responejson}</p>`;
                    }
                    // let actionOptions = document.getElementsByClassName("actionOption")[index];
                    // actionOptions.addEventListener("change", function() {
                    //     console.log(actionOptions.value);
                    // });


                }
            }
            xhr.send();
        })
        document.getElementById("noticeForm").addEventListener("submit", addnotice);

        function addnotice(e) {
            e.preventDefault();
            let shortnoteMsg = document.getElementById("shortnoteMsg").value;
            let method = "memberpostnotice";
            let username = document.getElementById("nameInfo").innerText;
            const url = `shortnoteMsg=${shortnoteMsg}&method=${method}&username=${username}`;
            console.log(url);
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "addnotice.php?" + url, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    let respone = xhr.responseText;
                    document.getElementsByClassName("saved")[0].style.display = "block";
                    setTimeout(function() {
                        document.getElementsByClassName("saved")[0].style.display = "none";
                    }, 4000)
                    // console.log(respone);

                }



            }
            xhr.send();
            // setTimeout(function() {
            //     document.location.reload(true);
            // }, 10000);

        }
        let notificationBtn = document.getElementById("notificationBtn");
        let notificationModel = document.getElementById("notificationModel");
        var display = false
        notificationBtn.addEventListener("click", function() {
            getmemberrequests();
            if (display) {
                notificationModel.style.display = "none";
                display = false;
            } else {
                notificationModel.style.display = "block"
                display = true;
            }




        })

        function getmemberrequests() {
            let method = "getmemberrequests";
            const url = `method=${method}`;
            let xhr = new XMLHttpRequest();
            var html = " ";
            var notificationModelContainer = document.getElementById("notificationModel");
            xhr.open("GET", "addnotice.php?" + url, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    let responejson = JSON.parse(this.responseText);
                    // add the response if ther is an error
                    if (typeof responejson === 'object') {

                        // let temp = responejson[1];
                        // console.log(temp);
                        responejson.forEach(function(val, index, array) {
                            // console.log(val);
                            // console.log(index);
                            html += "<div class='upcomingNotify'>";
                            html += "<span class='from'>" + val.FromMember + "</span>";
                            html += "<p class='userMsg'>" + val.msg + "</p>";
                            html += "<span class='time'>" + val.date + "</span>";
                            html += "</br>";
                            html += "<hr>";
                            html += "</div>";
                            notificationModelContainer.innerHTML = html;

                        })


                    } else {

                        notificationModelContainer.innerHTML = `<p> ${responejson}</p>`;

                    }



                }
            }
            xhr.send();
        }
    </script>

</body>

</html>