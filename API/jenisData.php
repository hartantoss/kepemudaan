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

// ========================= Show JenisData ============================
if(isset($_GET['showJenisData'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    
    $where="all";
    
    $message="Token doesn't valid";
        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";


        $query = "SELECT * FROM tb_jenis_data WHERE 1=1 ";

            
        if(isset($_POST['idJenisData']))
            $query.=" AND tb_jenis_data.id='".$_POST['idJenisData']."' ";
    
        
        $query.=" ORDER BY tb_jenis_data.id ASC";
        
        $dataResponse = customQuerySelect($connect,$query);
        writeDebugLog("count data : ".sizeof($dataResponse));
        writeDebugLog(json_encode($dataResponse));
        $response = array(
            "message"=>$message,
            "data"=>$dataResponse,
            "response_status"=>"true"
        );
        
    }
    else {
        $message="Token does not valid";
        
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );
    }

    // echo json_encode(array("nama"=>"dandi"));
    echo json_encode($response);
}
// ========================= Show JenisData ============================


// ========================= Save JenisData ============================
else if(isset($_GET['saveJenisData'])){
    $token = isset($_POST['token']) ? $_POST['token'] : "";
    $message="Token is not valid";

        
    if(isTokenValid($connect,$token,array("tb_admin"))){

        
        if(isset($_POST['judul'])) $myValue['judul']=htmlentities(strip_tags(trim($_POST['judul'])));
        if(isset($_POST['deskripsi'])) $myValue['deskripsi']=htmlentities(strip_tags(trim($_POST['deskripsi'])));
        if(isset($_POST['icon'])) $myValue['icon']=htmlentities(strip_tags(trim($_POST['icon'])));
        if(isset($_POST['css'])) $myValue['css']=htmlentities(strip_tags(trim($_POST['css'])));            
        if(isset($_POST['json_url'])) $myValue['json_url']=htmlentities(strip_tags(trim($_POST['json_url'])));            
        if(isset($_POST['json_column'])) $myValue['json_column']=htmlentities(strip_tags(trim($_POST['json_column'])));            
        
        
        $myUserData=extracMyToken($token);
        writeDebugLog("Data Token : ".json_encode($myUserData));

        $where=array();
        $message="Token valid";
            
        $saveStatus = 0;       
        

        // =============== Edit ====================
        if(isset($_POST['idJenisData'])){
           
            $where['id'] =  $_POST['idJenisData'];
            if(updateDb($connect,"tb_jenis_data",$where,$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_jenis_data",$where);
                $saveStatus = 1;
                $response = array(
                    "message"=>$message,
                    "data"=>end($dataResp),
                    "response_status"=>"true"
                );

                // $messagHistory="Merubah Data JenisData dengan ID : ".$_POST['idJenisData'];
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
            if(addToDb($connect,"tb_jenis_data",$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_jenis_data",$myValue);
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
// ========================= Save JenisData ============================


// ========================= Delete JenisData ============================
else if(isset($_GET['deleteJenisData'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idJenisData = $_POST['idJenisData'] != "" ? htmlentities(strip_tags(trim($_POST['idJenisData']))) : "";
    
    $message="Token doesn't valid";       
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
        $dataToken = extracMyToken($token);
        
        $message .= ", Access Found";
        $where=array(
            "id"=>$idJenisData
        );

        if(deleteDb($connect,"tb_jenis_data",$where)){
            $message="Delete Success";
            $response = array(
                "message"=>$message,
                "response_status"=>"true"
            );
            // $messagHistory="Menghapus Data JenisData dengan ID : ".$idJenisData;
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
// ========================= Delete JenisData ============================


?>