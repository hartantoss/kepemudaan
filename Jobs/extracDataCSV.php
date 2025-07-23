<?php
include "../connect.php";
date_default_timezone_set("Asia/Jakarta");
/**
 * Tipe :
 * BEKERJA
 * MENCARI
 * WIRAUSAHA
 * STUDY
 */

function rewriteHash($string){
    $string=str_replace("/","S",$string);
    $string=str_replace("?","Q",$string);
    $string=str_replace(".","D",$string);
    $string=str_replace("=","E",$string);
    $string=str_replace("$","M",$string);
    return $string;
}

// ========================= Upload Students ============================

    $dataCSV=showDb($connect,"tb_upload",array("status"=>"0"));
    
    for($ccCSV=0;$ccCSV<sizeof($dataCSV);$ccCSV++){
        $thisCSVid = $dataCSV[$ccCSV]['id'];
        $thisCSVFiles = $dataCSV[$ccCSV]['path'];
        $ccCSVFiles = $dataCSV[$ccCSV]['count_start']+1;
        $maxCSV = $dataCSV[$ccCSV]['count_end'];
        $dataStudents=array();
        $file = file_get_contents($thisCSVFiles);
        $dataStudents=explode("\n",$file);
        

        
        $saveStatus = 0;
        for($a=$ccCSVFiles; $a<sizeof($dataStudents)-1;$a++){
            $myValue['last_update']=date("Y-m-d h:i:sa");                
            $myValue['hashcode']=rewriteHash(password_hash(date("Y-m-d h:i:sa"), PASSWORD_DEFAULT));
            $myValue['tipe']="";                   
            $myValue['nim']=str_getcsv($dataStudents[$a])[0];    
            $myValue['nama']=Encript(str_getcsv($dataStudents[$a])[1]);
            $myValue['kota_lahir']=str_getcsv($dataStudents[$a])[2];    
            $myValue['tanggal_lahir']=str_getcsv($dataStudents[$a])[3]; 
            $myValue['jenis_kelamin']=str_getcsv($dataStudents[$a])[4];
            $myValue['telp']=Encript(str_getcsv($dataStudents[$a])[5]);   
            $myValue['email']=str_getcsv($dataStudents[$a])[6];    
            $myValue['program_studi']=str_getcsv($dataStudents[$a])[7];    
            $myValue['fakultas']=str_getcsv($dataStudents[$a])[8];    
            $myValue['no_ijazah']=str_getcsv($dataStudents[$a])[9];    
            $myValue['tanggal_yudisium']=str_getcsv($dataStudents[$a])[10];    
            $myValue['ipk']=str_getcsv($dataStudents[$a])[11];
            $myValue['lama_studi']=str_getcsv($dataStudents[$a])[12];    
            $myValue['predikat']=str_getcsv($dataStudents[$a])[13];    
            $myValue['judul_skripsi']=str_getcsv($dataStudents[$a])[14];
            $myValue['nip_dosen1']=str_getcsv($dataStudents[$a])[15];
            $myValue['nama_dosen1']=str_getcsv($dataStudents[$a])[16];
            $myValue['nip_dosen2']=str_getcsv($dataStudents[$a])[17];    
            $myValue['nama_dosen2']=str_getcsv($dataStudents[$a])[18];   
            $myValue['nip_dosen3']=str_getcsv($dataStudents[$a])[19];
            $myValue['nama_dosen3']=str_getcsv($dataStudents[$a])[20];    
            $myValue['nip_dosen4']=str_getcsv($dataStudents[$a])[21];   
            $myValue['nama_dosen4']=str_getcsv($dataStudents[$a])[22];    
            $myValue['nip_dosen5']=str_getcsv($dataStudents[$a])[23];    
            $myValue['nama_dosen5']=str_getcsv($dataStudents[$a])[24];   
            $myValue['nip_dosen6']=str_getcsv($dataStudents[$a])[25];    
            $myValue['nama_dosen6']=str_getcsv($dataStudents[$a])[26];  
            $myValue['batch_id']=$thisCSVid;
            if(addToDb($connect,"tb_students",$myValue)){
                $valueCsv=array(
                    "count_start"=>$a
                );
                if($a==$maxCSV)
                    $valueCsv['status']=1;
                
                updateDb($connect,"tb_upload",array("id"=>$thisCSVid),$valueCsv);
            }

        }
        echo  $thisCSVFiles." processed";
    }
// ========================= Upload Students ============================

?>