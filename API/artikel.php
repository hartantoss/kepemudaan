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

function normalize_text($text) {
    // Replace karakter kutip melengkung & lainnya
    $unwanted_chars = array(
        '‘' => "'", '’' => "'", 
        '“' => '"', '”' => '"',
        '–' => '-', '—' => '-', 
        '…' => '...', '•' => '-', 
        "\xC2\xA0" => ' ', // non-breaking space
    );

    $text = strtr($text, $unwanted_chars);

    // Optional: Hapus karakter non-ASCII sama sekali
    $text = preg_replace('/[^\x20-\x7E]/u', '', $text); 

    return $text;
}


// ========================= Show Artikel ============================
if(isset($_GET['showArtikel'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    
    $where="all";
    
    $message="Tipe is not valid";
    $response = array(
        "message"=>$message,
        "response_status"=>"false"
    );
        
    // if(isTokenValid($connect,$token,array("tb_admin"))){
        

        if(isset($_POST['tipe'])){
            $tipeArtikel=$_POST['tipe'];
            $query = "SELECT * FROM tb_artikel WHERE tipe='$tipeArtikel' ";

            if(!isTokenValid($connect,$token,array("tb_admin")))
                $query.=" AND visibility = '1' ";

            if(isset($_POST['idArtikel']))
                $query.=" AND tb_artikel.id='".$_POST['idArtikel']."' ";
            
            if(isset($_POST['judul']))
                $query.=" AND ( tb_artikel.judul_id='".$_POST['judul']."' OR tb_artikel.judul_en='".$_POST['judul']."' )";

            $query.=" ORDER BY tb_artikel.id DESC";
            
            $dataResponse = customQuerySelect($connect,$query);

            $response = array(
                "message"=>$message,
                "data"=>$dataResponse,
                "response_status"=>"true"
            );
        }

    echo json_encode($response);
}
// ========================= Show Artikel ============================


// ========================= Save Artikel ============================
else if(isset($_GET['saveArtikel'])){
    $token = isset($_POST['token']) ? $_POST['token'] : "";
    $message="Token is not valid";

        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        
        if(isset($_POST['judul_id'])) $myValue['judul_id']=mysqli_real_escape_string($connect, normalize_text(htmlentities(strip_tags(trim($_POST['judul_id'])))));
        if(isset($_POST['judul_en'])) $myValue['judul_en']=mysqli_real_escape_string($connect, normalize_text(htmlentities(strip_tags(trim($_POST['judul_en'])))));
        if(isset($_POST['deskripsi_id'])) $myValue['deskripsi_id']=mysqli_real_escape_string($connect, normalize_text($_POST['deskripsi_id']));
        if(isset($_POST['deskripsi_en'])) $myValue['deskripsi_en']=mysqli_real_escape_string($connect, normalize_text($_POST['deskripsi_en']));
        if(isset($_POST['tag'])) $myValue['tag']=mysqli_real_escape_string($connect, $_POST['tag']);
        if(isset($_POST['kategori'])) $myValue['kategori']=mysqli_real_escape_string($connect, $_POST['kategori']);
        if(isset($_POST['tipe'])) $myValue['tipe']=htmlentities(strip_tags(trim($_POST['tipe'])));
        if(isset($_POST['visibility'])) $myValue['visibility']=htmlentities(strip_tags(trim($_POST['visibility'])));
        if(isset($_POST['priority'])) $myValue['priority']=htmlentities(strip_tags(trim($_POST['priority'])));
                
        
        $myUserData=extracMyToken($token);
        writeDebugLog("Data Token : ".json_encode($myUserData));

        $where=array();
        $message="Token valid";
            
        $saveStatus = 0;       
        if(isset($_FILES["foto"]['error'])){
            
            $file_dir="";
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $file = $_FILES['foto']['tmp_name']; 
            $fileNewName = "artikel_".date("dmYHis").".".$ext;
            $folderPath = "../imagesAPI/fileArtikel/";
            
            $tempFilePath=$folderPath.$fileNewName;
            $tmp_file_dir=explode("../",$folderPath.$fileNewName);
            $file_dir=$tmp_file_dir[1];
            $myValue['foto'] = $file_dir; 

            $allowedFile=array("jpg", "png", "jpeg");
            if(in_array(strtolower($ext),$allowedFile)){
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $tempFilePath)) {
                    $message.= "The file ". htmlspecialchars( basename( $_FILES["foto"]["name"])). " berhasil diupload.";
                    $myValue['foto'] = $file_dir; 
                } else {
                    $message.= "<span class='red-text'> Maaf, system sedang mengalami kendala, file tidak terupload.</span>";
                }
            }
            else {
                $message.= "<span class='red-text'> Maaf, File yang boleh di upload hanya jpg, png, jpeg</span>";
            }
            
        }       
        

        // =============== Edit ====================
        if(isset($_POST['idArtikel'])){
           
            $where['id'] =  $_POST['idArtikel'];
            if(updateDb($connect,"tb_artikel",$where,$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_artikel",$where);
                $saveStatus = 1;
                $response = array(
                    "message"=>$message,
                    "data"=>end($dataResp),
                    "response_status"=>"true"
                );

                // $messagHistory="Merubah Data Artikel dengan ID : ".$_POST['idArtikel'];
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
            $myValue['created_date']=date("d M Y, H:i");
            $myValue['created_by']=$myUserData['id'];
            if(addToDb($connect,"tb_artikel",$myValue)){
                $message.=", Perbaruan data berhasil";
                $dataResp = showDb($connect,"tb_artikel",$myValue);
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
// ========================= Save Artikel ============================


// ========================= Delete Artikel ============================
else if(isset($_GET['deleteArtikel'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idArtikel = $_POST['idArtikel'] != "" ? htmlentities(strip_tags(trim($_POST['idArtikel']))) : "";
    
    $message="Token doesn't valid";       
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
        $dataToken = extracMyToken($token);
        
        $message .= ", Access Found";
        $where=array(
            "id"=>$idArtikel
        );

        if(deleteDb($connect,"tb_artikel",$where)){
            $message="Delete Success";
            $response = array(
                "message"=>$message,
                "response_status"=>"true"
            );
            // $messagHistory="Menghapus Data Artikel dengan ID : ".$idArtikel;
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
// ========================= Delete Artikel ============================


// ========================= Load Artikel ============================
else if(isset($_GET['loadArtikel'])){
    
    
    $message="Token doesn't valid";
        
    if(isset($_POST['tipe'])&&isset($_POST['numPage'])&&isset($_POST['tags'])&&isset($_POST['kategori'])&&isset($_POST['search'])){
        $sizePage=6;
        $numPage = (int)$_POST['numPage'];
        $tags = $_POST['tags'];
        $kategori = $_POST['kategori'];
        $search = $_POST['search'];
        $tipeArtikel=$_POST['tipe'];

        $dataStart=(($numPage-1)*$sizePage);
        
        $where="all";
        $message="Token valid";
        $query = "SELECT * FROM tb_artikel WHERE visibility='1'";
        $queryAllContent="SELECT count(*) AS jumlah FROM tb_artikel WHERE visibility='1' ";

        if(isset($_POST['tipe'])){
            $query .= " AND tipe='$tipeArtikel' ";
            $queryAllContent .= " AND tipe='$tipeArtikel' ";
        }
        
        if(isset($_POST['idArtikel'])){
            $query.=" AND tb_artikel.id='".$_POST['idArtikel']."' ";
            $queryAllContent.=" AND tb_artikel.id='".$_POST['idArtikel']."' ";
        }
        
        if($tags!="all"){
            $query.=" AND tb_artikel.tag='$tags' ";
            $queryAllContent.=" AND tb_artikel.tag='$tags' ";
        }
        
        if($kategori!="all"){
            $query.=" AND tb_artikel.kategori='$kategori' ";
            $queryAllContent.=" AND tb_artikel.kategori='$kategori' ";
        }

        if(isset($_POST['judul'])){
            $query.=" AND ( tb_artikel.judul_id='".$_POST['judul']."' OR tb_artikel.judul_en='".$_POST['judul']."' ) ";
            $queryAllContent.=" AND ( tb_artikel.judul_id='".$_POST['judul']."' OR tb_artikel.judul_en='".$_POST['judul']."' ) ";
        }

        if($search!=""){
            $query.=" AND (tb_artikel.judul_id like '%$search%' OR tb_artikel.judul_en like '%$search%')";
            $queryAllContent.=" AND (tb_artikel.judul_id like '%$search%' OR tb_artikel.judul_en like '%$search%')";
        }
        
        $query.=" ORDER BY tb_artikel.id DESC, tb_artikel.priority ASC LIMIT $sizePage OFFSET $dataStart";
        $queryAllContent.=" ORDER BY tb_artikel.id DESC, tb_artikel.priority ASC";
        
        $dataResponse = customQuerySelect($connect,$query);

        $queryRecent="SELECT * FROM tb_artikel WHERE visibility='1' AND tipe='$tipeArtikel' ORDER BY tb_artikel.priority ASC LIMIT 6";
        $dataRecent = customQuerySelect($connect,$queryRecent);

        $dataAllContent = customQuerySelect($connect,$queryAllContent);
        $listPageNum = range(1, ceil(((int)$dataAllContent[0]['jumlah'])/$sizePage));

        $response = array(
            "message"=>$message,
            "data"=>$dataResponse,
            "page_now"=>$numPage,
            "list_page"=>$listPageNum,
            "list_recent"=>$dataRecent ,
            "response_status"=>"true"
        );
       
        
    }
    else {
        $message="Data is not valid";
        
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );
    }

    echo json_encode($response);
}
// ========================= Load Artikel ============================


// ========================= Show Tag ============================
else if(isset($_GET['showTag'])){
    $whereTag='';
    if(isset($_POST['tipe']))
        $whereTag=" AND tipe='".$_POST['tipe']."'";
    
    $queryBrowser = "SELECT distinct tag FROM tb_artikel WHERE tag!='' $whereTag ORDER BY tag";

    $dataBrowser = customQuerySelect($connect, $queryBrowser);

    $tagList=array();
    for($a=0; $a<sizeof($dataBrowser); $a++)
        array_push($tagList,array($dataBrowser[$a]['tag']=>''));
    

    $response = array(
        "message"=>"token valid",
        "data"=>$tagList,
        "response_status"=>"true"
    );

    echo json_encode($response);
}
// ========================= Show Tag ============================

// ========================= Show Kategori ============================
else if(isset($_GET['showKategori'])){
    $whereKategori='';
    if(isset($_POST['tipe']))
        $whereKategori=" AND tipe='".$_POST['tipe']."'";
    
    $queryBrowser = "SELECT distinct kategori FROM tb_artikel WHERE kategori!=''  $whereKategori ORDER BY kategori";

    $dataBrowser = customQuerySelect($connect, $queryBrowser);

    $kategoriList=array();
    for($a=0; $a<sizeof($dataBrowser); $a++)
        array_push($kategoriList,array($dataBrowser[$a]['kategori']=>''));
    

    $response = array(
        "message"=>"token valid",
        "data"=>$kategoriList,
        "response_status"=>"true"
    );

    echo json_encode($response);
}
// ========================= Show Kategori ============================
?>