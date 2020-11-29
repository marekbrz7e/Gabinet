    <!DOCTYPE HTML>

<html lang="pl-PL">
    <?php
    require_once "config.php";
    require_once "session.php"; 
    $un=$_SESSION["username"];
    $password=$npassword="";
    $passwordError=$npasswordError=$inf="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(empty($_POST["password"]))
        {
            $passwordError= "Proszę podać hasło";
        }
        else
        {
            $password=trim($_POST["password"]);
        }

        if(empty($_POST["npassword"]))
        {
            $npasswordError= "Proszę podać hasło";
        }
        else if(strlen(trim($_POST["npassword"]))<6)
        {
            $npasswordError="hasło musi zawierać 6 znaków";
        }
        else
        {
            $npassword=trim($_POST["npassword"]);
        }

        if(empty($usernameError)&&empty($passwordError))
        {
            $b="SELECT password FROM users WHERE username LIKE'".$_SESSION["username"]."'";
            $result=mysqli_query($connect,$b);
            $r=mysqli_fetch_row($result);
            $npassword=password_hash($npassword,PASSWORD_DEFAULT);
            if(password_verify($password,$r[0]))
            {
                $c="UPDATE users SET password =\"".$npassword."\" WHERE users.username LIKE\"".$_SESSION["username"]."\"";
                mysqli_query($connect,$c);
                $inf="Zmieniono hasło";
            }
            else
            {
                $passwordError="Podano błędne hasło";
            }
        }

    }
    ?>
        
        <head>
            <title>gabinet lekarski</title>
            <link rel="stylesheet" href="styl.css">
            <meta charset="UTF-8">
        </head>
        <body>
            <div id="pasek">
                <p id="napis">Zalogowano jako: <a href="changePwd.php"><?php echo $un; ?></a></p>
                <a href="logout.php" id="wyl">Wyloguj</a>
            </div>
            <div id="main">

                <a href="index.html" ><p id="banner">Gabinet lekarski</p></a>
                <div id="lewy3">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <label>Hasło:</label> <br>
                        <input type="password" id="password" name="password"> <br><span class="error"><?php echo $passwordError; ?></span><br><br>
                        <label>Nowe hasło:</label> <br>
                        <input type="password" id="password" name="npassword"> <br><span class="error"><?php echo $npasswordError; ?></span><br><br>
                        <input type="submit" id="send" value="Zmień"><span id="dodano"><br><span><?php echo $inf; ?></span>
                    </form>

                </div>
            </div>
            <div id="stop">
                <p id="cr">© Medica2020</p>
            </div>
            
            
        </body>
</html>
