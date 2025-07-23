<?php
include "../connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
date_default_timezone_set("Asia/Jakarta");

// ========================= Show Navigator ============================
if(isset($_GET['showNavigator'])){
    $token = isset($_POST['token']) ? $_POST['token'] : "";
    $myUserData=extracMyToken($token);
    // writeDebugLog("Data Token : ".json_encode($myUserData));

    $message="Token doesn't valid";
    $response = array(
        "message"=>$message,
        "response_status"=>"false"
    );
        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
        $where="all";
        $myUserData=extracMyToken($token);
        $jenisUser=$myUserData['jenis'];

        $query="SELECT * FROM tb_navigator WHERE 1=1 ";
        if($jenisUser=="ADMIN")
            $query.=" AND `class` like ('% adminMenu%') ";
        if($jenisUser=="SUPERADMIN")
            $query.=" AND `class` like ('% superAdminMenu%') ";
        if($jenisUser=="DEVELOPER")
            $query.=" AND `class` like ('% developerMenu%') ";

        $query.=" ORDER BY id ASC";
        $dataNavigator = customQuerySelect($connect,$query);    

        // get role data
        $dataUser=showDb($connect,"tb_admin",array("id"=>$myUserData['id']));
        writeDebugLog("role -> ".$dataUser[0]['role']);
        $allowedRole=$dataUser[0]['role'];
        $response = array(
            "message"=>$message,
            "data"=>$dataNavigator,
            "additional"=>array(
                "allowed_role"=>$allowedRole,
            ),
            "response_status"=>"true"
        );
    }
    echo json_encode($response);
}
// ========================= Show Navigator ============================



?>