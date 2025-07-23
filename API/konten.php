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

// ========================= Show Konten ============================
if(isset($_GET['showKonten'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    
    $where="all";
    
    $message="Token doesn't valid";
        
    // if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";


        $query = "SELECT * FROM tb_konten WHERE 1=1 ";

            
        if(isset($_POST['idKonten']))
            $query.=" AND tb_konten.id='".$_POST['idKonten']."' ";
        if(isset($_POST['tipeKonten']))
            $query.=" AND tb_konten.tipe_konten='".$_POST['tipeKonten']."' ";
    
        
        $query.=" ORDER BY tb_konten.id DESC";
        
        $dataResponse = customQuerySelect($connect,$query);

        $response = array(
            "message"=>$message,
            "data"=>$dataResponse,
            "response_status"=>"true"
        );
        
    // }
    // else {
    //     $message="Token does not valid";
        
    //     $response = array(
    //         "message"=>$message,
    //         "response_status"=>"false"
    //     );
    // }

    echo json_encode($response);
}
// ========================= Show Konten ============================


// ========================= Save Konten ============================
else if(isset($_GET['saveKonten'])){
    $token = isset($_POST['token']) ? $_POST['token'] : "";
    $message="Token is not valid";

        
    if(isTokenValid($connect,$token,array("tb_admin"))){

        
        if(isset($_POST['judul_id'])) $myValue['judul_id']=htmlentities(strip_tags(trim($_POST['judul_id'])));
        if(isset($_POST['judul_en'])) $myValue['judul_en']=htmlentities(strip_tags(trim($_POST['judul_en'])));
        if(isset($_POST['deskripsi_id'])) $myValue['deskripsi_id']=htmlentities(strip_tags(trim($_POST['deskripsi_id'])));
        if(isset($_POST['deskripsi_en'])) $myValue['deskripsi_en']=htmlentities(strip_tags(trim($_POST['deskripsi_en'])));            
        if(isset($_POST['tipe_konten'])) $myValue['tipe_konten']=htmlentities(strip_tags(trim($_POST['tipe_konten'])));            
        
        $myUserData=extracMyToken($token);
        writeDebugLog("Data Token : ".json_encode($myUserData));

        $where=array();
        $message="Token valid";
            
        $saveStatus = 0;       
        if(isset($_FILES["icon"]['error'])){
            
            $file_dir="";
            $ext = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
            $file = $_FILES['icon']['tmp_name']; 
            $fileNewName = "konten_".date("dmYHis").".".$ext;
            $folderPath = "../imagesAPI/fileKonten/";
            
            $tempFilePath=$folderPath.$fileNewName;
            $tmp_file_dir=explode("../",$folderPath.$fileNewName);
            $file_dir=$tmp_file_dir[1];
            $myValue['icon'] = $file_dir; 

            $allowedFile=array("jpg", "png", "jpeg");
            if(in_array(strtolower($ext),$allowedFile)){
                if (move_uploaded_file($_FILES["icon"]["tmp_name"], $tempFilePath)) {
                    $message.= "The file ". htmlspecialchars( basename( $_FILES["icon"]["name"])). " berhasil diupload.";
                    $myValue['icon'] = $file_dir; 
                } else {
                    $message.= "<span class='red-text'> Maaf, system sedang mengalami kendala, file tidak terupload.</span>";
                }
            }
            else {
                $message.= "<span class='red-text'> Maaf, File yang boleh di upload hanya jpg, png, jpeg</span>";
            }
            
        }   

        // =============== Edit ====================
        if(isset($_POST['idKonten'])){
           
            $where['id'] =  $_POST['idKonten'];
            if(updateDb($connect,"tb_konten",$where,$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_konten",$where);
                $saveStatus = 1;
                $response = array(
                    "message"=>$message,
                    "data"=>end($dataResp),
                    "response_status"=>"true"
                );

                // $messagHistory="Merubah Data Konten dengan ID : ".$_POST['idKonten'];
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
            // $myValue['created_date']=date("d M Y, H:i");
            // $myValue['created_by']=$myUserData['id'];
            if(addToDb($connect,"tb_konten",$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_konten",$myValue);
                $response = array(
                    "message"=>$message,
                    "data"=>end($dataResp),
                    "response_status"=>"true"
                );

                // $messagHistory="Menambahkan Data Unit Kerja baru";
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
// ========================= Save Konten ============================


// ========================= Delete Konten ============================
else if(isset($_GET['deleteKonten'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idKonten = $_POST['idKonten'] != "" ? htmlentities(strip_tags(trim($_POST['idKonten']))) : "";
    
    $message="Token doesn't valid";       
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
        $dataToken = extracMyToken($token);
        
        $message .= ", Access Found";
        $where=array(
            "id"=>$idKonten
        );

        if(deleteDb($connect,"tb_konten",$where)){
            $message="Delete Success";
            $response = array(
                "message"=>$message,
                "response_status"=>"true"
            );
            // $messagHistory="Menghapus Data Konten dengan ID : ".$idKonten;
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
// ========================= Delete Konten ============================


?>