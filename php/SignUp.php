<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../index.css">
    <link rel="stylesheet" href="../../styles/signupStyle.css">
    <title>sign up</title>
</head>
<body>
    <div id="contents">
        <header>
            <h1 class="title">SIGN UP</h1>
        </header>
        <form action="signUpSubmit.php" method="post"><section class="input">
            <div class="inputBox">
                <p class="inputTxt">USER NAME</p>
                <input type="text" name="name_input" id="id_input" spellcheck="false"> 
            </div>
            <div class="inputBox">
                <p class="inputTxt">ID</p>
                <input type="text" name="id_input" id="id_input" spellcheck="false"> 
            </div>
            <div class="inputBox">
                <p class="inputTxt">PASSWORD</p>
                <input type="text" name="pw_input" id="pw_input" spellcheck="false">
            </div>
            <div class="inputBox">
                <p class="inputTxt">PASSWORD CONFIRM</p>
                <input type="text" name="pw_confirm" id="pw_confirm" spellcheck="false">
            </div>
        </section>
        <section class="buttons">
            <input type="submit" class="btn" value="SUBMIT">
        </section></form>
    </div>
    <script src="signUp.js" charset="utf-8"></script>
</body>
</html>