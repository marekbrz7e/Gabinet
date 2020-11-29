<!DOCTYPE HTML>

<html lang="pl-PL">
    <?php   require_once "session.php";
            $un=$_SESSION["username"];?>
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
            <div id="lewy2">
               <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST"&&isset($_POST["find"]))
                    {
                        $pesel=$_POST["pesel"];
                        $connect=mysqli_connect("localhost","root","","gabinet_lekarski");
                        mysqli_set_charset($connect,"utf8");
                        $i="SELECT pacjenci.imie,pacjenci.nazwisko,pacjenci.pesel,pacjenci.adres,pacjenci.tel FROM pacjenci WHERE pacjenci.pesel LIKE'".$pesel."'" ;
                        $result=mysqli_query($connect,$i);
                        $count=mysqli_num_rows($result);
                        if($count==0)
                        {
                            echo "<br> nie znaleziono pacjenta";
                        }
                        else
                        {
                            echo "<table>";
                            echo "<tr>
                                <th>	
                                    Imię
                                </th>
                                <th>	
                                    Nazwisko
                                </th>
                                <th>	
                                    Pesel  
                                </th>
                                <th>	
                                    Adres
                                </th>
                                <th>	
                                    Telefon
                                </th>
                                
                            </tr>";

                            for($j=0;$j<$count;$j++)
                            {
                            echo "<tr>";
                            $r=mysqli_fetch_row($result);
                                for($i=0;$i<5;$i++)
                                {
                                    echo "<td>";
                                    echo $r[$i];
                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                            echo"</table>";

                        }
                        mysqli_close($connect);
                    }
                      
                ?>
                
            </div>
            <div id="prawy2">
                <a href="doktor3.php" id="dod">DODAJ PACJENTA</a>
                <br>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label>PESEL:</label> <br>
                    <input type="text" id="pesel" name="pesel"><br><br><input type="submit" id="find" name="find" value="znajdź pacjenta"><br><br>
                    <label>IMIĘ:</label> <br>
                    <input type="text" id="imie" name="imie"> <br>
                    <label>NAZWISKO:</label> <br>
                    <input type="text" id="nazwisko" name="nazwisko"> <br>
                    <label>ADRES:</label> <br>
                    <input type="text" id="adres" name="adres"> <br>
                    <label>TELEFON:</label> <br>
                    <input type="text" id="telefon" name="telefon"> <br>
                    
                    <input type="submit" id="send" name="send" value="edytuj dane pacjenta">
                </form>

                <?php
                
                if ($_SERVER["REQUEST_METHOD"] == "POST"&&isset($_POST["send"]))
                {
                    $connect2=mysqli_connect("localhost","root","","gabinet_lekarski");
                    mysqli_set_charset($connect2,"utf8");

                    $pesel=$_POST["pesel"];
                    $imie=$_POST["imie"];
                    $nazwisko=$_POST["nazwisko"];
                    $adres=$_POST["adres"];
                    $telefon=$_POST["telefon"];

                    if(preg_match("(\b\d{11})",$pesel))
                    {
                        $p="(SELECT id_pac FROM pacjenci WHERE pesel LIKE '".$pesel."')";
                        $result2=mysqli_query($connect2,$p);
                        $count2=mysqli_num_rows($result2);
                        $r2=mysqli_fetch_row($result2);
                        if($count2!=0)
                        {
                            if($imie!="")
                            {
                                $a="UPDATE pacjenci SET imie=\"".$imie."\" WHERE pesel LIKE ".$pesel;
                                if(mysqli_query($connect2,$a))
                                {
                                    echo "<p>Zmieniono imię</p>";
                                }
                                else
                                {
                                    echo "error: ".$a."<br>".mysqli_error($connect2)."<br>";
                                } 
                            }

                            if($nazwisko!="")
                            { $a="UPDATE pacjenci SET nazwisko=\"".$nazwisko."\" WHERE pesel LIKE ".$pesel;
                                if(mysqli_query($connect2,$a))
                                {
                                    echo "<p>Zmieniono nazwisko</p>";
                                }
                                else
                                {
                                    echo "error: ".$a."<br>".mysqli_error($connect2)."<br>";
                                } 
                            }

                            if($adres!="")
                            {
                                $a="UPDATE pacjenci SET adres=\"".$adres."\" WHERE pesel LIKE ".$pesel;
                                if(mysqli_query($connect2,$a))
                                {
                                    echo "<p>Zmieniono adres</p>";
                                }
                                else
                                {
                                    echo "error: ".$a."<br>".mysqli_error($connect2)."<br>";
                                } 
                            }

                            if($telefon!="")
                            {
                                $a="UPDATE pacjenci SET tel=\"".$telefon."\" WHERE pesel LIKE ".$pesel;
                                if(mysqli_query($connect2,$a))
                                {
                                    echo "<p>Zmieniono numer telefonu</p>";
                                }
                                else
                                {
                                    echo "error: ".$a."<br>".mysqli_error($connect2)."<br>";
                                } 
                            }
                            //header("Refresh:0");
                        }
                        else
                        {
                            echo "Pacjent o podanym peselu nie istnieje w bazie danych";
                        }
                    }
                    else echo "Nieprawidlowy pesel <br>";
                    mysqli_close($connect2);
                }
                ?>
            </div>
            
        </div>    
        <div id="stop">
            <p id="cr">© Medica2020</p>
        </div>
        
        
    </body>
</html>

