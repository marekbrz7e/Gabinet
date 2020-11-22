<!DOCTYPE HTML>

<html lang="pl-PL">
    <head>
        <title>gabinet lekarski</title>
        <link rel="stylesheet" href="styl.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <div id="main">
            <a href="index.html" ><p id="banner">Gabinet lekarski</p></a>
            <div id="lewy2">
               
               <?php
                        
                $connect=mysqli_connect("localhost","root","","gabinet_lekarski");
                mysqli_set_charset($connect,"utf8");

                
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    if (empty($_POST["pesel"]))
                    {
                        echo "blednie wypelniony formularz";
                    }
                    else
                    {
                        if(preg_match("(\b\d{11})",$_POST["pesel"]))
                        {
                            $i="SELECT pacjenci.pesel,wizyty.data FROM pacjenci, wizyty WHERE pacjenci.id_pac=wizyty.id_pac AND pesel LIKE ".$_POST["pesel"]." ORDER BY wizyty.data DESC";
                            $result=mysqli_query($connect,$i);
                            $count=mysqli_num_rows($result);
                            echo "<table>";
                            echo "<tr>
                                <th>	
                                    Pesel
                                </th>
                                <th>	
                                    Data
                                </th>
                                
                            </tr>";

                            for($j=0;$j<$count;$j++)
                            {
                            echo "<tr>";
                            $r=mysqli_fetch_row($result);
                                for($i=0;$i<2;$i++)
                                {
                                    echo "<td>";
                                    echo $r[$i];
                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                            echo"</table>";
                        }                   
                        else
                        {
                            echo "niepoprawny pesel";
                        }
                        mysqli_close($connect);
                    }           
                }
                ?>
                
            </div>
            <div id="prawy2">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label>PESEL:</label> <br>
                    <input type="text" id="pesel" name="pesel"> <br> <br>
                    <input type="submit" id="send" value="wyślij"> <br>
                </form>
                
            </div>
            
        </div>    
        <div id="stop">
            <p id="cr">© Medica2020</p>
        </div>
        
        
    </body>
</html>

