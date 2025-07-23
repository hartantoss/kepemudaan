<?php
include "../connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ========================= Show Survei ============================
if(isset($_GET['showSurvei'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    
    $u10 = [
        "",
        "Standart Pelayanan Tidak dipublikasikan", 
        "Standar pelayanan dipublikasikan sebagian", 
        "Standar pelayanan dipublikasikan seluruhnya", 
        "Standar pelayanan dipublikasikan seluruhnya dan jelas"
    ];
    
    $u11 = [
        "",
        "Petugas pelayanan memberikan pelayanan yang tidak sesuai dengan standar pelayanan yang telah ditetapkan", 
        "Petugas pelayanan memberikan pelayanan dengan cepat, namun disertai dengan permintaan imbalan yang tidak sesuai dengan etika dan integritas profesi", 
        "Petugas pelayanan memberikan pelayanan yang sesuai dengan standart pelayanan yang telah ditetapkan, menunjukan kepatuhan terhadap prosedur dan prinsip integritas", 
        "Petugas pelayanan membrikan pelayanan yang sesuai dengan standart pelayanan, serta melaksanakannya dengan cepat dan efisien, tanpa melangal integritas dan etika kerja"
    ];
    
    $message="Token doesn't valid";
        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";


        $query = "SELECT * FROM tb_survei WHERE created_date  BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' ORDER BY created_date DESC";
        
        $dataResponse = customQuerySelect($connect,$query);
        foreach ($dataResponse as &$item) {
            $item['u10'] = $u10[(int)$item['u10']] ?? "Unknown";
            $item['u11'] = $u11[(int)$item['u11']] ?? "Unknown";
        }
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

    echo json_encode($response);
}
// ========================= Show Survei ============================


// ========================= Save Survei ============================
else if(isset($_GET['saveSurvei'])&& isset($_POST['answers'])){
    $answers = json_decode($_POST['answers'],true);
    $message="Token valid";

    $myValue=array(
        "nama"=>$answers[0]['nama'],
        "usia"=>$answers[0]['umur'],
        "jenis_kelamin"=>$answers[0]['gender'],
        "telp"=>$answers[0]['hp'],
        "u1"=>$answers[1],
        "u2"=>$answers[2],
        "u3"=>$answers[3],
        "u4"=>$answers[4],
        "u5"=>$answers[5],
        "u6"=>$answers[6],
        "u7"=>$answers[7],
        "u8"=>$answers[8],
        "u9"=>$answers[9],
        "u10"=>$answers[10],
        "u11"=>$answers[11],
        // "kekurangan"=>$answers[12],
        // "kelebihan"=>$answers[13],
        "saran"=>$answers[12],
        // "created_date"=>date("Y-m-d H:i:s")
    );
    if(addToDb($connect,"tb_survei",$myValue)){
        $message.=", Perbaruan data berhasil";
        $dataResp = showDb($connect,"tb_survei",$myValue);
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
   
    echo json_encode($response);
}
// ========================= Save Survei ============================


// ========================= Delete Survei ============================
else if(isset($_GET['deleteSurvei'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idSurvei = $_POST['idSurvei'] != "" ? htmlentities(strip_tags(trim($_POST['idSurvei']))) : "";
    
    $message="Token doesn't valid";       
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
        $dataToken = extracMyToken($token);
        
        $message .= ", Access Found";
        $where=array(
            "id"=>$idSurvei
        );

        if(deleteDb($connect,"tb_survei",$where)){
            $message="Delete Success";
            $response = array(
                "message"=>$message,
                "response_status"=>"true"
            );
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
// ========================= Delete Survei ============================


?>