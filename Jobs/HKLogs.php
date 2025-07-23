<?php

include "../connect.php";
date_default_timezone_set("Asia/Jakarta");


// ========================= cornJob House Keeping Log Query ============================

    $path = array(
        '../Logs/QueryLogs/',
        '../Logs/ServerLogs/',
        '../Excel/',
        '../CSVFiles/',
    );
    for($a=0;$a<sizeof($path);$a++){
        if ($handle = opendir($path[$a])) {

            while (false !== ($file = readdir($handle))) { 
                $filelastmodified = filemtime($path[$a] . $file);
                //24 hours in a day * 3600 seconds per hour
                if((time() - $filelastmodified) > 24*3600)
                {
                    unlink($path[$a] . $file);
                }

            }

            closedir($handle); 
        }
    }

// ========================= cornJob insert peta ============================


?>