<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log in </title>
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
    }

    .header h1 {
        color: white;
        text-align: center;
        padding: 2px;
        margin-bottom: 10px;
    }

    .container {
        margin: 0 auto;
        max-width: 300px;
        padding: 16px;
        background-color: white;
        border-radius: 10px;
    }

    /* Full-width input fields */
    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 20px 0;
        border: none;
        background: #f1f1f1;
        border-radius: 20px;
    }

    input[type=text]:focus,
    input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Set a style for the submit button */
    .btn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
        border-radius: 20px;
    }

    .btn:hover {
        opacity: 1;
    }

    #error {
        color: red;
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


    <div class="bg-img">
        <form class="container" method="POST" id="form">
            <h4 style="text-align:center;">LOGIN</h4><br />
            <hr />

            <label for="email"><b>Username:</b></label>
            <input type="text" id="uName" placeholder="Enter username" name="Username" required>

            <label for="psw"><b>Password:</b></label>
            <input type="password" id="uPassword" placeholder="Enter Password" name="password" required>
            <p id="error"></p>
            <button type="submit" class="btn" name="Formbtn" id="formBtn">Login</button><br /><br />

        </form>

    </div>
    <script>
    document.getElementById("form").addEventListener("submit", loginMember);

    function loginMember(e) {
        e.preventDefault();
        var errorCheck = false;
        let uName = document.getElementById("uName").value;
        let uPassword = document.getElementById("uPassword").value;
        let url = `username=${uName}&password=${uPassword}`;
        if (errorCheck) {
            document.getElementById("error").innerHTML = " ";
        }

        let xhr = new XMLHttpRequest();
        xhr.open('POST', "login.php", true);
        xhr.onload = function() {
            if (this.status == 200) {
                let respone = this.responseText;
                switch (respone) {
                    case "admin.php":
                        location.href = respone;
                        break;
                    case "memberindex.php":
                        location.href = respone;
                        break;
                    default:
                        document.getElementById("error").innerHTML = respone;
                        errorCheck = true;
                }

            }
        }
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(url);

    }
    </script>

</body>

</html>