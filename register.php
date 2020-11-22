<!DOCTYPE HTML>

<html lang="pl-PL">
<?php
require_once "config.php";
$username=$password=$confirmPassword="";
$passwordError=$usernameError=$confirmPasswordError=$dod="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty($_POST["username"]))
    {
        $usernameError= "Proszę podać nazwę użytkownika";
    }
    else
    {
        $username=$_POST["username"];
        $a="SELECT id FROM users WHERE username LIKE '".$username."'";
        $result=mysqli_query($connect,$a);
        $count=mysqli_num_rows($result);
        if($count!=0)
        {
            $usernameError="Podana nazwa użytkownika jest zajęta";
        }

    }

    if(empty($_POST["password"]))
    {
        $passwordError= "Proszę podać hasło";
    }
    elseif(strlen(trim($_POST["password"]))<6)
    {
        $passwordError="Hasło musi zawierać przynajmniej 6 znaków";
    }
    else
    {
        $password=trim($_POST["password"]);
    }

    if(empty($_POST["cpassword"]))
    {
        $passwordError= "Proszę potwierdzić hasło";
    }
    else
    {
        $cpassword=trim($_POST["cpassword"]);
        if(empty($passwordError)&&$password!=$cpassword)
        {
            $confirmPasswordError="Hasła się różnią";
        }
    }

    if(empty($usernameError)&&empty($passwordError)&&empty($confirmPasswordError))
    {
        $hpassword=password_hash($password,PASSWORD_DEFAULT);
        $b="INSERT INTO users (username,password) VALUES ('".$username."','".$hpassword."')";
        if(mysqli_query($connect,$b))
        {
            $dod= "Dodano użytkownika";
        }
        else
        {
            $dod= "Wystąpił błąd";
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
                    <label>USERNAME:</label> <br>
                    <input type="text" id="username" name="username"> <br><span class="error"><?php echo $usernameError; ?></span><br><br>
                    <label>PASSWORD:</label> <br>
                    <input type="password" id="password" name="password"> <br><span class="error"><?php echo $passwordError; ?></span><br><br>
                    <label>CONFIRM PASSWORD:</label> <br>
                    <input type="password" id="cpassword" name="cpassword"><br><span class="error"><?php echo $confirmPasswordError; ?></span><br><br>
                    <input type="submit" id="send" value="Utwórz"><span id="dodano"><br><?php echo $dod; ?></span>
                </form>
                <p>Masz już konto?<a href="login.php" id="zaloguj"> Zaloguj</a></p>

            </div>
        </div>
        <div id="stop">
            <p id="cr">© Medica2020</p>
        </div>
        
        
    </body>
</html>
