<?php
include "../connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// 0 : Ditolak
// 1 : Waiting Approval
// 2 : Approve

// ========================= Show DokumenIPP ============================
if(isset($_GET['showDokumenIPP'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    
    $message="Token valid";
    $query = "SELECT * FROM tb_ipp_dokumen WHERE 1=1 ";
    
    if(isset($_POST['idDokumenIPP']))
        $query.=" AND tb_ipp_dokumen.id='".$_POST['idDokumenIPP']."' ";
    
    $query.=" ORDER BY tahun DESC";
    $dataResponse = customQuerySelect($connect,$query);

    $response = array(
        "message"=>$message,
        "data"=>$dataResponse,
        "response_status"=>"true"
    );

    echo json_encode($response);
}
// ========================= Show DokumenIPP ============================


// ========================= Save DokumenIPP ============================
else if(isset($_GET['saveDokumenIPP'])){
    $token = isset($_POST['token']) ? $_POST['token'] : "";
    $message="Token is not valid";
    writeDebugLog("Masuk Save Dokumen IPP");
        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        
        if(isset($_POST['nama'])) $myValue['nama']=mysqli_real_escape_string($connect, htmlentities(strip_tags(trim($_POST['nama']))));
        if(isset($_POST['tahun'])) $myValue['tahun']=mysqli_real_escape_string($connect, htmlentities(strip_tags(trim($_POST['tahun']))));
        if(isset($_POST['jenis'])) $myValue['jenis']=mysqli_real_escape_string($connect, $_POST['jenis']);
                       
        
        $myUserData=extracMyToken($token);
        writeDebugLog("Data Token : ".json_encode($myUserData));

        $where=array();
        $message="Token valid";
            
        $saveStatus = 0;       
        if(isset($_FILES["pathFile"]['error'])){
            $jenisDocument=$_POST['jenis'];
            $file_dir="";
            $ext = pathinfo($_FILES['pathFile']['name'], PATHINFO_EXTENSION);
            $file = $_FILES['pathFile']['tmp_name']; 
            $fileNewName = $jenisDocument."_".date("dmYHis").".".$ext;
            $folderPath = "../imagesAPI/fileDokumenIPP/";
            
            $tempFilePath=$folderPath.$fileNewName;
            $tmp_file_dir=explode("../",$folderPath.$fileNewName);
            $file_dir=$tmp_file_dir[1];
            $myValue['pathFile'] = $file_dir; 

            $allowedFile=array("pdf", "docx", "xlsx");
            if(in_array(strtolower($ext),$allowedFile)){
                if (move_uploaded_file($_FILES["pathFile"]["tmp_name"], $tempFilePath)) {
                    $message.= "The file ". htmlspecialchars( basename( $_FILES["pathFile"]["name"])). " berhasil diupload.";
                    $myValue['pathFile'] = $file_dir; 
                } else {
                    $message.= "<span class='red-text'> Maaf, system sedang mengalami kendala, file tidak terupload.</span>";
                }
            }
            else {
                $message.= "<span class='red-text'> Maaf, File yang boleh di upload hanya pdf, docx, xlsx</span>";
            }
            
        }       
        

        // =============== Edit ====================
        if($_POST['idDokumenIPP']!="0"){
           
            $where['id'] =  $_POST['idDokumenIPP'];
            if(updateDb($connect,"tb_ipp_dokumen",$where,$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_ipp_dokumen",$where);
                $saveStatus = 1;
                $response = array(
                    "message"=>$message,
                    "data"=>end($dataResp),
                    "response_status"=>"true"
                );

                // $messagHistory="Merubah Data DokumenIPP dengan ID : ".$_POST['idDokumenIPP'];
                // writeHistory($connect,$myUserData['id'],$messagHistory);
            }

            else{
                $message .= ", Perbaruan data gagal";
                $response = array(
                    "message"=>$message,
                    "response_status"=>"false"
                );
            }
        }
        // =================== Add New =====================
        else{
            $myValue['upload_date']=date("d M Y, H:i");
            if(addToDb($connect,"tb_ipp_dokumen",$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_ipp_dokumen",$myValue);
                $response = array(
                    "message"=>$message,
                    "data"=>end($dataResp),
                    "response_status"=>"true"
                );

            }
    
            else{
                $message .= ", Perbaruan data gagal";
                $response = array(
                    "message"=>$message,
                    "response_status"=>"false"
                );
            }
        }
    }
    else{
        $message = "Token doesn't valid";
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );
    }

    echo json_encode($response);
}
// ========================= Save DokumenIPP ============================


// ========================= Delete DokumenIPP ============================
else if(isset($_GET['deleteDokumenIPP'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idDokumenIPP = $_POST['idDokumenIPP'] != "" ? htmlentities(strip_tags(trim($_POST['idDokumenIPP']))) : "";
    
    $message="Token doesn't valid";       
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
        $dataToken = extracMyToken($token);
        
        $message .= ", Access Found";
        $where=array(
            "id"=>$idDokumenIPP
        );

        if(deleteDb($connect,"tb_ipp_dokumen",$where)){
            $message="Delete Success";
            $response = array(
                "message"=>$message,
                "response_status"=>"true"
            );
            // $messagHistory="Menghapus Data DokumenIPP dengan ID : ".$idDokumenIPP;
            // writeHistory($connect,$dataToken['id'],$messagHistory);
        }

        else{
            $message = "Delete Failed";
            $response = array(
                "message"=>$message,
                "response_status"=>"false"
            );
        }
    
    }
    else 
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );

    echo json_encode($response);
}
// ========================= Delete DokumenIPP ============================


// ========================= Load DokumenIPP ============================
else if(isset($_GET['loadDokumenIPP'])){
    
    $message="Token valid";
    $query = "SELECT * FROM tb_ipp_dokumen WHERE 1=1 ";
    
    
    if(isset($_POST['idDokumenIPP'])){
        $query.=" AND tb_ipp_dokumen.id='".$_POST['idDokumenIPP']."' ";
    }
    
    $query.=" ORDER BY tahun DESC";
    $dataResponse = customQuerySelect($connect,$query);
    if (sizeof($dataResponse) > 0) {
        $thisTahun = $dataResponse[0]['tahun'];
        $responseArray = array();
        $tmpArray = array();
        for ($a = 0; $a < sizeof($dataResponse); $a++) {
            if ($thisTahun != $dataResponse[$a]['tahun']) {
                array_push($responseArray, array(
                    "tahun" => $thisTahun,
                    "dataList" => $tmpArray
                ));
                $thisTahun = $dataResponse[$a]['tahun'];
                $tmpArray = array();
            }
            array_push($tmpArray, $dataResponse[$a]);
        }
        // ✅ Tambahkan ini agar tahun terakhir tetap masuk
        array_push($responseArray, array(
            "tahun" => $thisTahun,
            "dataList" => $tmpArray
        ));
        $dataResponse = $responseArray;
    }
    $response = array(
        "message"=>$message,
        "data"=>$dataResponse,
        "response_status"=>"true"
    );
       

    echo json_encode($response);
}
// ========================= Load DokumenIPP ============================


?>