<?php
include "../connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


function utf8ize($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = utf8ize($value);
        }
    } else if (is_string($data)) {
        return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    } else if (is_null($data)) {
        return null;
    }
    return $data;
}

/*function hitungIPP($dataBare) {
    $domainIndeks = [];
    $domainTransformasi = [];

    foreach ($dataBare as $item) {
        $domain = $item['domain'];
        $min = (float) $item['min_value'];
        $max = (float) $item['max_value'];
        $data = (float) $item['data'];

        // Hindari pembagian nol
        if ($max - $min == 0) {
            $transformasi = 0;
        } else {
            $transformasi = 100 * ($data - $min) / ($max - $min);
        }

        // Clamp nilai antara 0-100
        $transformasi = max(0, min(100, $transformasi));

        // Kelompokkan berdasarkan domain
        $domainTransformasi[$domain][] = $transformasi;
    }

    // Hitung rata-rata transformasi untuk tiap domain (Indeks Domain)
    foreach ($domainTransformasi as $domain => $nilaiTransformasi) {
        $rata = array_sum($nilaiTransformasi) / count($nilaiTransformasi);
        $domainIndeks[$domain] = round($rata, 2);
    }

    // Hitung IPP (rata-rata dari semua indeks domain)
    $nilaiIPP = round(array_sum($domainIndeks) / count($domainIndeks), 2);

    return [
        'transformasi_per_indikator' => $domainTransformasi,
        'indeks_per_domain' => $domainIndeks,
        'nilai_ipp' => $nilaiIPP
    ];
}*/

function hitungIPP($dataBare) {
    $domainTransformasi = [];
    $domainIndeks = [];
    
    // Bobot per indikator di tiap domain
    $bobotIndikator = [
        'Pendidikan dan Pelatihan' => [0.33, 0.34, 0.33],
        'Kesehatan' => [0.26, 0.23, 0.26, 0.25],
        'Ketenagakerjaan Layak' => [0.35, 0.32, 0.33],
        'Partisipasi dan Kepemimpinan' => [0.34, 0.33, 0.33],
        'Inklusivitas dan Kesetaraan Gender' => [0.33, 0.35, 0.32]
    ];

    // Bobot untuk per domain terhadap nilai IPP
    $bobotDomain = [
        'Pendidikan dan Pelatihan' => 0.21,
        'Kesehatan' => 0.20,
        'Ketenagakerjaan Layak' => 0.20,
        'Partisipasi dan Kepemimpinan' => 0.20,
        'Inklusivitas dan Kesetaraan Gender' => 0.19
    ];

    // Penampung transformasi per indikator
    $transformasiPerIndikator = [];

    // Menampung urutan indikator sesuai kemunculan (penting agar bobot cocok)
    foreach ($dataBare as $item) {
        $domain = $item['domain'];
        $min = (float) $item['min_value'];
        $max = (float) $item['max_value'];
        $data = (float) $item['data'];

        // Default transformasi
        $transformasi = 0;

        // Terapkan rumus transformasi sesuai domain
        if ($max - $min != 0) {
            switch ($domain) {
                case 'Kesehatan':
                case 'Ketenagakerjaan Layak':
                    $transformasi = (1 - (($data - $min) / ($max - $min))) * 100;
                    break;
                default:
                    $transformasi = (($data - $min) / ($max - $min)) * 100;
                    break;
            }
        }

        // Clamp 0–100
        $transformasi = max(0, min(100, $transformasi));
        $transformasiPerIndikator[$domain][] = $transformasi;
    }

    // Hitung indeks per domain dengan bobot
    foreach ($transformasiPerIndikator as $domain => $nilaiTransformasi) {
        $bobot = $bobotIndikator[$domain];
        $total = 0;

        foreach ($nilaiTransformasi as $i => $nilai) {
            $total += $nilai * $bobot[$i];
        }

        $domainIndeks[$domain] = round($total, 2);
    }

    // Hitung nilai IPP dengan bobot domain
    $nilaiIPP = 0;
    foreach ($domainIndeks as $domain => $indeks) {
        $nilaiIPP += $indeks * $bobotDomain[$domain];
    }

    $nilaiIPP = round($nilaiIPP, 2);

    return [
        'transformasi_per_indikator' => $transformasiPerIndikator,
        'indeks_per_domain' => $domainIndeks,
        'nilai_ipp' => $nilaiIPP
    ];
}


function getDataIPP($connect, $tahun){
    $query = "WITH master_indikator AS (
                SELECT 
                    id,
                    domain,
                    indikator,
                    definisi,
                    min_value,
                    max_value
                FROM tb_ipp
                WHERE id BETWEEN 1 AND 16 
            )

            SELECT 
                m.id,
                m.domain,
                m.indikator,
                m.definisi,
                m.min_value,
                m.max_value,
                nvl(d.data, 0) AS data,
                '$tahun' AS tahun
            FROM master_indikator m
            LEFT JOIN tb_ipp d
                ON m.domain = d.domain AND m.indikator = d.indikator       
                AND d.tahun = '$tahun'  
            ORDER BY m.id
    ";
    return customQuerySelect($connect,$query);
}
// ========================= Show IPP ============================
if(isset($_GET['showIPP'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    
    $where="all";
    
    $message="Token doesn't valid";
        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";


        $query = "SELECT * FROM tb_ipp";

            
        if(isset($_POST['idIPP']))
            $query.=" AND tb_ipp.id='".$_POST['idIPP']."' ";
    
        
        $query.=" ORDER BY tb_ipp.id DESC";
        
        $dataResponse = customQuerySelect($connect,$query);

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
// ========================= Show IPP ============================
// ========================= Show IPP ============================
else if(isset($_GET['loadIPP'])){
    $tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
    
    $message="Token valid";


    // $query = "WITH master_indikator AS (
    //                 SELECT DISTINCT
    //                     domain,
    //                     indikator,
    //                     definisi,
    //                     min_value,
    //                     max_value
    //                 FROM tb_ipp
    //             )

    //             SELECT 
    //                 m.domain,
    //                 m.indikator,
    //                 m.definisi,
    //                 m.min_value,
    //                 m.max_value,
    //                 COALESCE(d.data, 0) AS data,
    //                 '$tahun' AS tahun
    //             FROM master_indikator m
    //             LEFT JOIN tb_ipp d
    //             ON m.domain = d.domain
    //             AND m.indikator = d.indikator
    //             AND d.tahun = '$tahun'
    //             ORDER BY m.domain, m.indikator
    // ";
    
    // $dataResponse = customQuerySelect($connect,$query);
    $dataResponse = getDataIPP($connect,$tahun);

    $response = array(
        "message"=>$message,
        "data"=>$dataResponse,
        "response_status"=>"true"
    );
    foreach ($dataResponse as $row) {
        foreach ($row as $key => $value) {
            if (!mb_check_encoding($value, 'UTF-8')) {
                echo "Field $key is not UTF-8: " . $value;
            }
        }
    }
    $json = json_encode($response);
    if ($json === false) {
       
        $response = array(
            "message"=>"json_encode error: " . json_last_error_msg(),
            "data"=>$dataResponse,
            "response_status"=>"false"
        );
        echo json_encode(utf8ize($response));
        exit;
    }
    
    // echo "masuk ".($response['data'][0]['indikator']);
    echo json_encode(utf8ize($response));
}
// ========================= Show IPP ============================


// ========================= Save IPP ============================
else if(isset($_GET['saveIPP'])){
    $token = isset($_POST['token']) ? $_POST['token'] : "";
    $message="Token is not valid";

        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        
        
        $domain=htmlentities(strip_tags(trim($_POST['domain'])));
        $indikator=htmlentities(strip_tags(trim($_POST['indikator'])));
        $definisi=htmlentities(strip_tags(trim($_POST['definisi'])));
        $tahun=htmlentities(strip_tags(trim($_POST['tahun'])));
        $min_value=htmlentities(strip_tags(trim($_POST['min_value'])));
        $max_value=htmlentities(strip_tags(trim($_POST['max_value'])));
        $data=htmlentities(strip_tags(trim($_POST['data'])));       
        $last_update=date("d M Y, H:i");
        $myUserData=extracMyToken($token);
        writeDebugLog("Data Token : ".json_encode($myUserData));

        $myValue=array(
            "domain"=>$domain,
            "indikator"=>$indikator,
            "definisi"=>$definisi,
            "tahun"=>$tahun,
            "min_value"=>$min_value,
            "max_value"=>$max_value,
            "data"=>$data,
            "last_update"=>$last_update,
        );
        
        $where=array();
        $message="Token valid";
        $querySelect="SELECT * FROM tb_ipp WHERE domain='$domain' AND indikator='$indikator' AND definisi='$definisi' AND tahun='$tahun'";
        writeDbLog("Query ".$querySelect);
        $dataIPP=customQuerySelect($connect,$querySelect);
        writeDbLog("Count ".sizeof($dataIPP));
        // =============== Edit ====================
        if(sizeof($dataIPP)>0){
            writeDbLog("masuk edit ");
            $where['id'] =  $dataIPP[0]['id'];
            if(updateDb($connect,"tb_ipp",$where,$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_ipp",$where);
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
        // =================== Add New =====================
        else{
            writeDbLog("masuk add ");
            if(addToDb($connect,"tb_ipp",$myValue)){
                $message.=", Insert data berhasil";
                $dataResp = showDb($connect,"tb_ipp",$myValue);
                $response = array(
                    "message"=>$message,
                    "data"=>end($dataResp),
                    "response_status"=>"true"
                );
            }
    
            else{
                $message .= ", Insert data gagal";
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
// ========================= Save IPP ============================


// ========================= Delete IPP ============================
else if(isset($_GET['deleteIPP'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idIPP = $_POST['idIPP'] != "" ? htmlentities(strip_tags(trim($_POST['idIPP']))) : "";
    
    $message="Token doesn't valid";       
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
        $dataToken = extracMyToken($token);
        
        $message .= ", Access Found";
        $where=array(
            "id"=>$idIPP
        );

        if(deleteDb($connect,"IPP",$where)){
            $message="Delete Success";
            $response = array(
                "message"=>$message,
                "response_status"=>"true"
            );
            // $messagHistory="Menghapus Data IPP dengan ID : ".$idIPP;
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
// ========================= Delete IPP ============================

// ========================= Show IPP ============================
else if(isset($_GET['loadGraphIPP'])){
    $tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
    // $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date("Y");
    writeDbLog("masuk");
    $message="Token valid";

    $dataBareTh = getDataIPP($connect,$tahun);
    $dataBareThM1 = getDataIPP($connect,$tahun-1);
    $dataBareThM2 = getDataIPP($connect,$tahun-2);
    $dataBareThM3 = getDataIPP($connect,$tahun-3);
    $dataBareThM4 = getDataIPP($connect,$tahun-4);
    $dataBareThM5 = getDataIPP($connect,$tahun-5);
    $dataBareThM6 = getDataIPP($connect,$tahun-6);
    $dataBareThM7 = getDataIPP($connect,$tahun-7);
    $dataBareThM8 = getDataIPP($connect,$tahun-8);

    $ippTh=hitungIPP($dataBareTh);
    $ippThM1=hitungIPP($dataBareThM1);
    $ippThM2=hitungIPP($dataBareThM2);
    $ippThM3=hitungIPP($dataBareThM3);
    $ippThM4=hitungIPP($dataBareThM4);
    $ippThM5=hitungIPP($dataBareThM5);
    $ippThM6=hitungIPP($dataBareThM6);
    $ippThM7=hitungIPP($dataBareThM7);
    $ippThM8=hitungIPP($dataBareThM8);

    $dataHistory=array(
        $tahun => $ippTh['nilai_ipp'],
        $tahun-1 => $ippThM1['nilai_ipp'],
        $tahun-2 => $ippThM2['nilai_ipp'],
        $tahun-3 => $ippThM3['nilai_ipp'],
        $tahun-4 => $ippThM4['nilai_ipp'],
        $tahun-5 => $ippThM5['nilai_ipp'],
        $tahun-6 => $ippThM6['nilai_ipp'],
        $tahun-7 => $ippThM7['nilai_ipp'],
        $tahun-8 => $ippThM8['nilai_ipp'],
    );
    
    $response = array(
        "message"=>$message,
        "data"=>array(
            $tahun=>$ippTh,
            ($tahun-1)=>$ippThM1
        ),
        "data_hist"=>$dataHistory,
        "response_status"=>"true"
    );
   
    $json = json_encode($response);
    echo $json;
}
// ========================= Show IPP ============================

?>