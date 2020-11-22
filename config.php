



<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME',"root");
    define('DB_PASSWORD',"");
    define('DB_TABLE',"gabinet_lekarski");

    $connect=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_TABLE);
    mysqli_set_charset($connect,"utf8");
    if($connect===false)
    {
        die("error:can't connect to database ".mysqli_connect_error());
    }

?>


