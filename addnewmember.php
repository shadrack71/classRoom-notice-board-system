<?php


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add member</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: rgb(212, 218, 220);
        }

        .header {
            width: 100%;
            background-color: rgb(36, 42, 51);
            margin-bottom: 5px;
        }

        .header h1 {
            color: white;
            text-align: center;
            padding: 2px;
        }


        /* Add padding to containers */
        .container {
            margin: 0 auto;
            max-width: 300px;
            padding: 16px;
            background-color: white;
            border-radius: 10px;
            padding: 16px;
        }

        .container>h1 {
            margin: 5px;
        }

        /* Full-width input fields */
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
            border-radius: 20px;
        }

        input[type=text]:focus,
        input[type=password]:focus {
            background-color: #ddd;
            outline: none;

        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 0px;
        }

        /* Set a style for the submit/register button */
        .registerbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 90%;
            opacity: 0.9;
            border-radius: 20px;
        }

        .registerbtn:hover {
            opacity: 1;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: Black;
            text-align: center;
            border-radius: 10px;
        }

        #error {
            color: red;
            margin: 1px;
            font-size: small;
            font-weight: bold;
            text-align: center;
        }

        #Smsg {
            color: rgb(23, 252, 34);
            margin: 1px;
            font-size: small;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="header">
        <h1>CLASSROM NOTICEBOARD</h1>
    </header>
    <form method="POST" action="" name="addmemberForm" id="addmemberForm">
        <div class="container">
            <h1>Signup</h1>
            <hr>
            <label for="uName"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uName" id="uName" required minlength="4">
            <label for="uEmail"><b>Email</b></label>
            <input type="text" placeholder="Enter Valid Email" name="uEmail" id="uEmail" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="uPassword_1" id="uPassword_1" required>

            <label for="psw-repeat"><b>Confirm Password</b></label>
            <input type="password" placeholder="Repeat Password" name="uPassword_2" id="uPassword_2" required>
            <input type="hidden" value="classMember" name="role" id="role">
            <p id="error"></p>
            <p id="Smsg"></p>
            <hr>
            <button type="submit" class="registerbtn" id="submitBtn">Signup</button>
            <p style="font-size: small;">Already have an account <a href="index.php">log in</a></p>
        </div>
    </form>
</body>
<script>
    document.getElementById("addmemberForm").addEventListener("submit", addMember);
    var errorCounter;

    function addMember(e) {
        e.preventDefault();
        let uName = document.getElementById("uName").value;
        let uEmail = document.getElementById("uEmail").value;
        let uPassword_1 = document.getElementById("uPassword_1").value;
        let uPassword_2 = document.getElementById("uPassword_2").value;
        let uRole = document.getElementById("role").value;
        let passCheck = passwordValidate(uPassword_1, uPassword_2);
        var errorCheck = false;
        if (passCheck) {
            const url = `username=${uName}&email=${uEmail}&pwd1=${uPassword_1}&role=${uRole}`;
            errorCounter = " ";
            if (errorCounter.length > 0) {
                document.getElementById("error").innerHTML = " ";

            }
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "addMember.php", true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    let respone = this.responseText;
                    switch (respone) {
                        case "usernameError":
                            document.getElementById("error").innerHTML = "the username is already in use";
                            errorCounter = "the username is already in use";
                            errorCheck = true;
                            break;
                        case "memberAdded":

                            document.getElementById("Smsg").innerHTML = "member details has been added to database";
                            errorCounter = "member details has been added to database";
                            setTimeout(function() {
                                document.getElementById("Smsg").innerHTML = "";
                            }, 10000)
                            break;
                        case "AddmemberError":
                            document.getElementById("error").innerHTML = "An Error occurred while adding the member please try again";
                            errorCounter = "  An Error occurred while adding the member please try again";
                            errorCheck = true;
                            break;
                        default:
                            document.getElementById("error").innerHTML = "fill the empty form to proceed";
                            errorCounter = "fill the empty form to proceed";
                            errorCheck = true;
                    }


                }

            }
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            errorCounter = " ";
            xhr.send(url);

        } else {
            document.getElementById("error").innerHTML = errorCounter;

        }
    }

    function passwordValidate(pws1, pws2) {
        if (pws1.length < 6) {
            document.getElementById("error").innerHTML = "password must be at least 6 characters";
            errorCounter = "password must be at least 6 characters";
        } else if (pws1.search(/[0-9]/) == -1) {
            document.getElementById("error").innerHTML = "must contain at least a number";
            errorCounter = "must contain at least a number";
        } else if (pws1 !== pws2) {
            document.getElementById("error").innerHTML = "password does not match";
            errorCounter = "password does not match";

        } else {
            return true;

        }


    }
</script>

</html>