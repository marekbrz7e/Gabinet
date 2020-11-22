<!DOCTYPE HTML>

<html lang="pl-PL">
<?php
require_once "config.php";
$password=$npassword="";
$passwordError=$npasswordError=$dod="";
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
    else
    {
        $npassword=trim($_POST["password"]);
    }

    if(empty($usernameError)&&empty($passwordError))
    {
        $hpassword=password_hash($password,PASSWORD_DEFAULT);
        $b="SELECT password FROM users WHERE username LIKE'".$username."'";
        $result=mysqli_query($connect,$b);
        $r=mysqli_fetch_row($result);
        if(password_verify($password,$r[0]))
        {
            session_start();
            $_SESSION["loggedin"]=true;
            $_SESSION["username"]=$username;
            header("location: doktor.php");
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
        <div id="main">

            <a href="index.html" ><p id="banner">Gabinet lekarski</p></a>
            <div id="lewy3">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label>Hasło:</label> <br>
                    <input type="password" id="password" name="password"> <br><span class="error"><?php echo $passwordError; ?></span><br><br>
                    <label>Nowe hasło:</label> <br>
                    <input type="password" id="npassword" name="npassword"> <br><span class="error"><?php echo $npasswordError; ?></span><br><br>
                    <input type="submit" id="send" value="Zmień"><span id="dodano"><br>
                </form>

            </div>
        </div>
        <div id="stop">
            <p id="cr">© Medica2020</p>
        </div>
        
        
    </body>
</html>
