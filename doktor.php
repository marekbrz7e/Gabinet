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
            <p id="napis">Zalogowano jako: <?php echo $un; ?></p>
            <a href="logout.php" id="wyl">Wyloguj</a>
        </div>

        <div id="main">
            <a href="index.html" id="banner">Gabinet lekarski</a>
            <div id="lewy2">
               
               <?php
                    $strDate=(string)date('Y-m-d');
                    $stop_date =(string)date('Y-m-d');
                    $stop_date=date('Y-m-d', strtotime($stop_date . ' +1 day'));

                    echo "Dzisiejsza data: ".$strDate;     

                    $connect=mysqli_connect("localhost","root","","gabinet_lekarski");
                    mysqli_set_charset($connect,"utf8");

                    $i="SELECT pacjenci.imie,pacjenci.nazwisko,pacjenci.pesel,wizyty.data,wizyty.uwagi FROM pacjenci, wizyty WHERE pacjenci.id_pac=wizyty.id_pac AND data>='".$strDate."' AND data<'".$stop_date."'" ;
                    $result=mysqli_query($connect,$i);
                    $count=mysqli_num_rows($result);
                    if($count==0)
                    {
                        echo "<br> nie zaplanowano dziś żadnych wizyt";
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
                                Data
                            </th>
                            <th>	
                                Uwagi
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
                ?>
                
            </div>
            <div id="prawy2">
                <a href="doktor2.php" id="dod">USUŃ WIZYTĘ</a>
                <br><br>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label>PESEL:</label> <br>
                    <input type="text" id="pesel" name="pesel"> <br>
                    <label>DATA:</label> <br>
                    <input type="datetime-local" id="data" name="data"> <br>
                    <label>UWAGI:</label> <br>
                    <input type="text" id="UWAGI" name="uwagi"> <br><br><br>
                    <input type="submit" id="send" value="dodaj wizytę">
                </form>
                <a href="doktor3.php"><img src="pacjent2.png" id="dp"></a>
                <?php
                
                
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $connect2=mysqli_connect("localhost","root","","gabinet_lekarski");
                    mysqli_set_charset($connect2,"utf8");

                    $pesel=$_POST["pesel"];
                    $data=$_POST["data"];
                    $data[10]=' ';
                    $uwagi=$_POST["uwagi"];

                    if(preg_match("(\b\d{11})",$pesel))
                    {
                        $p="(SELECT id_pac FROM pacjenci WHERE pesel LIKE '".$pesel."')";
                        $result2=mysqli_query($connect2,$p);
                        $count2=mysqli_num_rows($result2);
                        $r2=mysqli_fetch_row($result2);
                        if($count2!=0)
                        {
                            $a="INSERT INTO `wizyty` (`id_pac`, `data`, `uwagi`) VALUES ($r2[0],'".$data."','".$uwagi."')";
                            echo $a."<br>";
                            if(mysqli_query($connect2,$a))
                            {
                                echo "dodano rekord";
                                header("Refresh:0");
                            }
                            else
                            {
                                echo "error: ".$a."<br>".mysqli_error($connect2)."<br>";
                            } 
                        }
                        else
                        {
                            echo "pacjent o podanym peselu nie istnieje w bazie danych";
                        }
                    }
                    else echo "nieprawidlowy pesel <br>";
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

