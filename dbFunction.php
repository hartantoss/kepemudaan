<?php
// ini_set('display_errors', false);
date_default_timezone_set("Asia/Jakarta");
$myfile = fopen(dirname(__FILE__)."/Logs/QueryLogs/query".date("Ymdh").".txt", "a") or die("Unable to open file!");
ini_set('error_log', dirname(__FILE__).'/Logs/ServerLogs/error'.date("Ymdh").'.txt');

function addToDb($connect,$dbName, $myvalue){
  $queri= 'INSERT INTO '.$dbName.' (';


  $par=array_keys($myvalue);

    
    for($a=0; $a<(sizeof($myvalue)-1);$a++){
        $queri = $queri." ".$par[$a].",";
    }

    $queri = $queri." ".$par[$a].") VALUES (";

    for($a=0; $a<(sizeof($myvalue)-1);$a++){
        $queri = $queri." '".$myvalue[$par[$a]]."',";
    }

    $queri = $queri." '".$myvalue[$par[$a]]."')";

  $process=mysqli_query ($connect,$queri);
  writeDBLog($queri);
    //   echo $queri;
  if($process)
     return true;

  return false;
}

function showDb($connect,$dbName,$where,$order="DESC",$column="ALL",$limit="ALL"){
    $queri= 'SELECT * FROM '.$dbName.' ';
    if($column!="ALL"){
        $queri= 'SELECT ';
        for($a=0; $a<(sizeof($column)-1);$a++){
            $queri.=$column[$a].", ";
        }
        $queri.=$column[$a];
        $queri.=' FROM '.$dbName.' ';
    }    

    if($where!="all"){
        $queri .= " Where ";
        $par=array_keys($where);
        for($a=0; $a<(sizeof($where)-1);$a++){
            $queri = $queri." ".$par[$a]."='".$where[$par[$a]]."' and";
        }
        $queri = $queri." ".$par[$a]."='".$where[$par[$a]]."'";
    }

    $queri .= " ORDER BY id $order";

    if($limit!="ALL")
        $queri .= " LIMIT $limit";
        
    $info = array();
    $a=0;
    // echo $queri;
    $process=mysqli_query ($connect,$queri);
    writeDBLog($queri);
    while($data=mysqli_fetch_array($process)){
        
        $info [$a]=$data;
        $a++;
    }
    
  
    return $info;
}

function countDb($connect,$dbName,$where){
    $queri= 'SELECT count(*) as jml FROM '.$dbName.' ';
    if($where!="all"){
        $queri .= " Where ";
        $par=array_keys($where);
        for($a=0; $a<(sizeof($where)-1);$a++){
            $queri = $queri." ".$par[$a]."='".$where[$par[$a]]."' and";
        }
        $queri = $queri." ".$par[$a]."='".$where[$par[$a]]."'";
    }
    $queri .= " ORDER BY id DESC";
    
    // echo $queri;
    $process=mysqli_query ($connect,$queri);
    $data=mysqli_fetch_array($process);
    writeDBLog($queri);

    return $data['jml'];
}

function deleteDb($connect,$dbName,$where){
    
    $queri="";

    if($where =="all")
        $queri= 'DELETE FROM '.$dbName.' WHERE 1';
    else {
        $queri= 'DELETE FROM '.$dbName.' where ';

        $par=array_keys($where);


        for($a=0; $a<(sizeof($where)-1);$a++){
            $queri = $queri." ".$par[$a]."= '".$where[$par[$a]]."' and ";
        }

        $queri = $queri." ".$par[$a]."= '".$where[$par[$a]]."' ";
    }
    // echo $queri;
    $process=mysqli_query ($connect,$queri);
    writeDBLog($queri);
    if($process)
     return true;

    return false;
}

function customExecQuery($connect,$queri){
    writeDBLog($queri);
    return(mysqli_query ($connect,$queri));
}
function customQuerySelect($connect, $queri) {
    $info = array();
    $a = 0;

    writeDBLog($queri); // logging query

    $process = mysqli_query($connect, $queri);

    if (!$process) {
        die("Query failed: " . mysqli_error($connect)); // debug
    }

    while ($data = mysqli_fetch_array($process, MYSQLI_ASSOC)) {
        $info[$a] = $data;
        $a++;
    }
    return $info;
}

function customQuerySelectAssoc($connect,$queri){
    $info = array();
    $a=0;
    // echo $queri;
    $process=mysqli_query ($connect,$queri);
    writeDBLog($queri);
    while($data=mysqli_fetch_assoc($process)){
        
        $info [$a]=$data;
        $a++;
    }
    
  
    return $info;
}


function updateDb($connect,$dbName,$where,$myvalue){
    $queri =' UPDATE '.$dbName.' SET';

    $par=array_keys($myvalue);

    
    for($a=0; $a<(sizeof($myvalue)-1);$a++){
        $queri = $queri." ".$par[$a]."= '".$myvalue[$par[$a]]."',";
    }

    $queri = $queri." ".$par[$a]."= '".$myvalue[$par[$a]]."' WHERE ";

    $par=array_keys($where);

    
    for($a=0; $a<(sizeof($where)-1);$a++){
        $queri = $queri." ".$par[$a]."= '".$where[$par[$a]]."' and ";
    }

    $queri = $queri." ".$par[$a]."= '".$where[$par[$a]]."' ";
    
    // echo $queri;
    $process=mysqli_query ($connect,$queri);
    writeDBLog($queri);
    if($process)
     return true;

    return false;
}
function distinctDb($connect,$dbName,$where,$columnName){
    $queri= 'SELECT DISTINCT ';
    for($a=0; $a<(sizeof($columnName)-1);$a++){
        $queri .= " ".$columnName[$a].", ";
    }
    $queri .= " ".$columnName[$a];
    $queri .= ' FROM '.$dbName.' ';
    if($where!="all"){
        $queri .= " Where ";
        $par=array_keys($where);
        for($a=0; $a<(sizeof($where)-1);$a++){
            $queri = $queri." ".$par[$a]."='".$where[$par[$a]]."' and";
        }
        $queri = $queri." ".$par[$a]."='".$where[$par[$a]]."'";
    }
    $queri .= " ORDER BY id DESC";
    $info = array();
    $a=0;
    // echo $queri;
    $process=mysqli_query ($connect,$queri);
    writeDBLog($queri);
    while($data=mysqli_fetch_array($process)){
        
        $info [$a]=$data;
        $a++;
    }
    
  
    return $info;
}
function isEmailExist($connect,$dbName,$email){
    $queri= "SELECT username FROM `".$dbName."` where username="."'".$email."'";
    $process=mysqli_query ($connect,$queri);
    // echo $queri;
    writeDBLog($queri);
    $row = mysqli_num_rows($process);
    if($row==0)
        return false;
    else
        return true;
}

function filterData($data,$column,$myvalue){
    $b=0;
    $info = array();
    for($a=0;$a<sizeof($data);$a++){
        $found=0;
        for($aa=0; $aa<sizeof($myvalue);$aa++){
            for($bb=0; $bb<sizeof($column);$bb++){
                // echo strtolower($myvalue[$aa])." ".strtolower($data[$a][$column[$bb]])."<br/>";
                if(preg_match('/'.strtolower($myvalue[$aa]).'/',strtolower($data[$a][$column[$bb]]))){       
                    $found++;
                    // echo strtolower($myvalue[$aa])."  ".strtolower($data[$a][$column[$bb]])."<br/>";
                }
            }
        }
        if($found>0){
            $info [$b]=$data[$a];
            $b++;
        }
    }
    return $info;
}

function searchData($data,$column,$myvalue){
    $b=0;
    $info = array();
    for($a=0;$a<sizeof($data);$a++){
        $found=0;
        for($aa=0; $aa<sizeof($myvalue);$aa++){
            for($bb=0; $bb<sizeof($column);$bb++){
                // echo strtolower($myvalue[$aa])." ".strtolower($data[$a][$column[$bb]])."<br/>";
                if( strtolower($myvalue[$aa])==strtolower($data[$a][$column[$bb]]) ){       
                    $found++;
                    // echo strtolower($myvalue[$aa])." ".strtolower($data[$a][$column[$bb]])."<br/>";
                }
            }
        }
        if($found>0){
            $info [$b]=$data[$a];
            $b++;
        }
    }
    return $info;
}

function showUnicDataOnColumn($data,$columnName){

    $info = array();
    for($a=0;$a<sizeof($data);$a++){
        if(in_array($data[$a][$columnName], $info))
            continue;
        else
            array_push($info, $data[$a][$columnName]);
    }
    return $info;
}

function extracMyToken($token){
    $str=Decript($token);
    $myArray= json_decode($str,true);
    return $myArray;
}

function isTokenRegValid($connect,$dbName,$token){
   
    // echo $token;
    $dataToken=json_decode(htmlDecode($token),true);
    // print_r($dataToken);

    $username=$dataToken['username'];
    $found = 0;
    $id=$dataToken['id'];
    $nama=$dataToken['nama'];
    // echo $username." ".$id;
    
    $queri= "SELECT * FROM $dbName where username = '$username' and id = '$id' and nama='$nama'";
    $process=mysqli_query ($connect,$queri);
    writeDBLog($queri);
    $row = mysqli_num_rows($process);
    if($row)
        $found = 1;

    // echo $queri;
    if($found==0)
        return false;
    else
        return true;

}

function isTokenValid($connect,$token,$dbName){
    if($token == "Assalamu'alaikum")
        return true;
    else{
        // echo $token;
        $dataToken=extracMyToken($token);
        // print_r($dataToken);
        $found = 0;

        if (is_array($dataToken)){
            if(array_key_exists("username",$dataToken)){
                $username=$dataToken['username'];
                
                $id=$dataToken['id'];
                $nama=$dataToken['nama'];

                for($a=0;$a<sizeof($dbName);$a++){
                    $queri= "SELECT * FROM $dbName[$a] where username = '$username' and id = '$id' and nama = '$nama'";
                    $process=mysqli_query ($connect,$queri);
                    $row = mysqli_num_rows($process);
                    if($row){
                        $found = 1;
                        break;
                    }
                }
            }
        }


        if($found==0)
            return false;
        else
            return true;

    }
}


function imageResize($imageResourceId,$width,$height) {

    // echo $width." ";
    // echo $height;
    if($width>300||$height>500){
        $targetWidth =$width/3;
        $targetHeight =$height/3;
    }
    else{
        $targetWidth =$width;
        $targetHeight =$height;
    }

    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;
}

function imageAddAdress($imageResourceId,$width,$height,$text) {



    // (B) WRITE TEXT
    $white = imagecolorallocate($imageResourceId, 255, 255, 255);
    // $text = "Hello World";
    $font = dirname(__FILE__) . "/fonts/tommy/MADE TOMMY Bold_PERSONAL USE.otf"; 
    // echo $font;
    // THE IMAGE SIZE
    $width = imagesx($imageResourceId);
    $height = imagesy($imageResourceId);

    // THE TEXT SIZE
    $text_size = imagettfbbox(8, 0, $font, $text);
    // print_r($text_size);
    $text_width = max([$text_size[2], $text_size[4]]) - min([$text_size[0], $text_size[6]]);
    $text_height = max([$text_size[5], $text_size[7]]) - min([$text_size[1], $text_size[3]]);

    // CENTERING THE TEXT BLOCK
    $centerX = 10;
    $centerX = $centerX<0 ? 0 : $centerX;
    $centerY = CEIL(($height - $text_height)*10/11);
    $centerY = $centerY<0 ? 0 : $centerY;

    $textLength = strlen($text);
    $txtStart=0;
    $newCenterY = $centerY;
    while($txtStart<$textLength){
        $newText = substr($text,$txtStart,35);
        
        imagettftext($imageResourceId, 20, 0, $centerX, $newCenterY, $white, $font, $newText);
        $newCenterY += 35;
        $txtStart += 30;
    }
    
    // imagettftext($imageResourceId, 14, 0, $centerX, $centerY, $white, $font, $text);
    // imagettftext($imageResourceId, 14, 0, $centerX, $centerY+30, $white, $font, $text);

    $targetWidth =$width/2;
    $targetHeight =$height/2;


    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;
    // // (C) OUTPUT IMAGE
    // header('Content-type: image/jpeg');
    // imagejpeg($imageResourceId);
    // imagedestroy($imageResourceId);

}


function sendEmail($to,$from,$subject,$message){
    // ini_set( 'display_errors', 1 );   
    // error_reporting( E_ALL );    
    // $from = "nelbi@common-id.com";    
    // $to = "dandiwibowo9@gmail.com";    
    // $subject = "Checking PHP mail";    
    // $message = "PHP mail berjalan dengan baik";
    writeDebugLog("Email From : $from");
    writeDebugLog("Email To : $to");
    writeDebugLog("Email subject : $subject");
    writeDebugLog("Email Message : $message");

    $headers = "From: $from" . "\n";
    $headers .= "MIME-Version: 1.0," . "\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";  
    $headers = [
        "MIME-Version: 1.0",
        "Content-type: text/html; charset=UTF-8",
        "From: $from"
    ];

    // $headers = "From:" . $from;    
    if(mail($to,$subject,$message, implode("\r\n", $headers))){
        writeDebugLog("Sending email to $to success");
        return true;
    }
    else {
        writeDebugLog("Sending email to $to failed");
        return false;
    }
}

function htmlEncode($string){

     // Store the cipher method 
     $ciphering = "AES-128-CTR"; 

     // Use OpenSSl Encryption method 
     $iv_length = openssl_cipher_iv_length($ciphering); 
     $options = 0; 
 
     // Non-NULL Initialization Vector for encryption 
     $encryption_iv = '2609199721022021'; 
 
     // Store the encryption key 
     $encryption_key = "StatsmeApp"; 
 
     // Use openssl_encrypt() function to encrypt the data 
     $encryption = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv); 

     $encryption= preg_replace("/\//",'_sl',$encryption);
     $encryption= preg_replace("/[+]/",'_pl',$encryption);
     $encryption= preg_replace("/=/",'_eq',$encryption);
    return $encryption;
}

function htmlDecode($string){
    $string= preg_replace("/_sl/",'/',$string);
    $string= preg_replace("/_pl/",'+',$string);
    $string= preg_replace("/_eq/",'=',$string);

    // Store the cipher method 
     $ciphering = "AES-128-CTR"; 

     // Use OpenSSl Encryption method 
     $iv_length = openssl_cipher_iv_length($ciphering); 
     $options = 0; 

    // Non-NULL Initialization Vector for decryption 
    $decryption_iv = '2609199721022021'; 

    // Store the decryption key 
    $decryption_key = "StatsmeApp"; 

    // Use openssl_decrypt() function to decrypt the data 
    $decryption=openssl_decrypt ($string, $ciphering, $decryption_key, $options, $decryption_iv); 

    
   
    // $string= preg_replace("/gt/",'>',$string);
    return $decryption;
}

function curlGet($url,$data){
    $url .= "?";
    $par=array_keys($data);
    for($a=0; $a<(sizeof($data)-1);$a++){
        $url = $url."".$par[$a]."=".$data[$par[$a]]."&";
    }
    $url = $url."".$par[$a]."=".$data[$par[$a]]."";
    // echo $url;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function curlPost($url,$data){
    
    $ch = curl_init();
    // $skipper = "luxury assault recreational vehicle";
    // $fields = array( 'penguins'=>$skipper, 'bestpony'=>'rainbowdash');
    $postvars = '';
    foreach($data as $key=>$value) {
        $postvars .= $key . "=" . $value . "&";
    }
    // $url = "http://www.google.com";
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
    curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt($ch,CURLOPT_TIMEOUT, 20);
    $response = curl_exec($ch);
    // print "curl response is:" . $response;
    curl_close ($ch);

    return $response;
}

function writeDBLog($query){
    date_default_timezone_set("Asia/Jakarta");
    $myfile = fopen(dirname(__FILE__)."/Logs/QueryLogs/query".date("Ymdh").".txt", "a") or die("Unable to open file!");
    fwrite($myfile, "[ ".date("Y m d, h i s")." ] ".$query."\n");
    fclose($myfile);
}

function writeDebugLog($message){
    date_default_timezone_set("Asia/Jakarta");
    $myfile = fopen(dirname(__FILE__)."/Logs/QueryLogs/query".date("Ymdh").".txt", "a") or die("Unable to open file!");
    fwrite($myfile, "[ ".date("Y m d, h i s")." ] [DEBUG] ".$message."\n");
    fclose($myfile);
}

function removeDir($target)
    {
    $directory = new RecursiveDirectoryIterator($target,  FilesystemIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
        if (is_dir($file)) {
            rmdir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($target);
}


function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function writeHistory($connect,$actor,$message){
    $arrayMessage=array(
        "jam"=>date("d-m-y H:i:s"),
        "action"=>$message,
        "user"=>$actor
    );
    if(addToDb($connect,"tb_history",$arrayMessage))
        return true;
    else 
        return false;
}


function createPDFTable($arrayData){
    $resultText="Maaf Tidak ada data yang dapat ditampilkan";
    if(sizeof($arrayData)>0){
        $myStyle="<style>
                    table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    }
                    
                    td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                    }
                    
                    tr:nth-child(even) {
                    background-color: #dddddd;
                    }
                </style>
        ";
        $myJs="
            <script>
                window.print();
            </script>
        ";
        
        $myTable="<table>";

        $firstArray=array_keys($arrayData[0]);
        $myTable.="<thead><tr>";
        for ($a = 0; $a < sizeof($firstArray); $a++) {
            // Add the string of keys to the table header
            $myTable .= "<th>{$firstArray[$a]}</th>";
        }
        $myTable.="</tr></thead>";

        $myTable.="<tbody>";
        for($a=0; $a<sizeof($arrayData);$a++){
            $thisRow=$arrayData[$a];
            writeDebugLog(json_encode($thisRow));
            $myTable.="<tr>";
            for($b=0; $b<sizeof($firstArray);$b++){
                $myTable.="<td>".$thisRow[$firstArray[$b]]."</td>";
            }
            $myTable.="</tr>";
        }
        $myTable.="</tbody>";

        $resultText="<html><body>".$myStyle.$myTable.$myJs."</body></html>";
    }

    return $resultText;
}

function createExcelTable($arrayData,$judul){
    require_once __DIR__.'/SimpleXLSXGen.php';

    if(sizeof($arrayData)>0){
        $allData=array();
        $firstArray=array_keys($arrayData[0]);    
        array_push($allData,$firstArray);
 
        for($a=0; $a<sizeof($arrayData);$a++){
            array_push($allData,$arrayData[$a]);
        }
        $xlsx = Shuchkin\SimpleXLSXGen::fromArray( $allData );
        // $xlsx->saveAs('books.xlsx');
        $xlsx->downloadAs($judul.'.xlsx');
        return "Data Downloaded";
    }
    else{
        return "Sorry Something went wrong";
    }
}

function readExcel($filePath){
    require_once('SimpleXLSX.php');
    // use Shuchkin\SimpleXLSX;
    $allArray=array();
    if ( $xlsx = Shuchkin\SimpleXLSX::parse($filePath) ) {
        $sheets=$xlsx->sheetNames(); 
        // return $sheets;
        foreach($sheets as $index => $name){
            $myArrayInSheet=array();
        //     echo "Reading sheet :".$name."<br>";
            foreach ( $xlsx->rows($index) as $r => $row ) {
                array_push($myArrayInSheet,$row);
                // print_r($row);
                // echo "<br>";
            }
            $allArray[$name]=$myArrayInSheet;
            // array_push($allArray,array($name=>$myArrayInSheet));
        //     echo "<hr>";
        }
        
    } else {
        writeDBLog(Shuchkin\SimpleXLSX::parseError());
    }
    return $allArray;
}

function generateRandomString($length = 10, $contains=array("NUMBER","ALPHABET","SPECIAL_CHARACTER")) {
    writeDebugLog("Generate random string contains : ".json_encode($contains));
    // Set karakter yang akan digunakan dalam string acak
    $numbers = '0123456789';
    $alphabets = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $specialCharacters = '!@#$%^&*()';
    
    // Set semua karakter untuk memilih karakter acak tambahan
    $allCharacters = '';
    
    
    // Pastikan setidaknya satu karakter dari setiap kategori
    $randomString = '';
    if (in_array("NUMBER", $contains)){
        $allCharacters .= $numbers;
    }
    if (in_array("ALPHABET", $contains)){
        $allCharacters .= $alphabets;
    }
    if (in_array("SPECIAL_CHARACTER", $contains)){
        $allCharacters .= $specialCharacters;
    }
    
    $charactersLength = strlen($allCharacters);

    // Tambahkan karakter acak tambahan hingga panjang yang diinginkan tercapai
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $allCharacters[rand(0, $charactersLength - 1)];
    }
    
    // Acak urutan karakter dalam string
    $randomString = str_shuffle($randomString);

    return $randomString;
}


function checkFileSize($myFile,$maxSize){
    if ($myFile["size"] > $maxSize) { //Max 200KB
        return false;
    }
    return true;
}
?>