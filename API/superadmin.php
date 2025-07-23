<?php
include "../connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// ========================== Login ===============================
if(isset($_GET['login'])){
    $username = $_POST['username'] != "" ? htmlentities(strip_tags(trim($_POST['username']))) : "";
    $password = $_POST['password'] != "" ? htmlentities(strip_tags(trim($_POST['password']))) : "";
    
    // $username = decriptLogin($username);
    // $password = decriptLogin($password);
    
    $message="Account doesn't exist";
        
    if(isEmailExist($connect,"tb_admin",$username)){
        $message="Wrong Password";
        $data = showDb($connect,"tb_admin",array("username"=>$username));
        // print_r($data);
        if(password_verify($password, $data[0]['password'])){
            if($data[0]['status']=="1"){
                $message="Account Found";

                $dataResponse = array (
                    "id"=>$data[0]['id'],
                    "username" => $data[0]['username'],
                    "nama" => $data[0]['nama'],
                    "avatar" => $data[0]['avatar'],
                    "jenis" => $data[0]['jenis'],
                    "status" => $data[0]['status'],
                );
                $token = Encript(json_encode($dataResponse));
                
                $response = array(
                    "message"=>$message,
                    "data"=>$dataResponse,
                    "token"=>$token,
                    "response_status"=>"true"
                );            
            }
            else 
                $response = array(
                    "message"=>"Akun anda belum aktif. Silahkan melakukan <b onclick='gotoVerification()'>Verifikasi Akun</b> terlebih dahulu",
                    "response_status"=>"false"
                ); 
        }
        else 
            $response = array(
                "message"=>$message,
                "response_status"=>"false"
            ); 
    }
    else 
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );
        
    echo json_encode($response);
        
}
// ========================== Login ================================

// ========================= Show Admin ============================
else if(isset($_GET['showAdmin'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    // $privilege = $_POST['privilege'] != "" ? $_POST['privilege'] : "";
    // $where['privilege']= $privilege;
    $where="all";
    
    if(isset($_POST['idAdmin'])||isset($_POST['privilege'])){
        $where=array();
        if(isset($_POST['idAdmin'])){
            $where['id'] = $_POST['idAdmin'];
        }
        if(isset($_POST['privilege'])){
            $where['jenis'] = $_POST['privilege'];
        }
    }
    
    $message="Token doesn't valid";
        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
        $dataResponse = showDb($connect,"tb_admin",$where);

        $response = array(
            "message"=>$message,
            "data"=>$dataResponse,
            "response_status"=>"true"
        );
    
    }
    else 
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );

    echo json_encode($response);
}
// ========================= Show Admin ============================

// ========================= Edit Admin ============================
else if(isset($_GET['editAdmin'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idAdmin = $_POST['idAdmin'] != "" ? htmlentities(strip_tags(trim($_POST['idAdmin']))) : "";

    $message="Token doesn't valid";
        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";

        $dataSupAdmin=showDb($connect,"tb_admin",array("id"=>$idAdmin));
        if(sizeof($dataSupAdmin)>0){
            $myValue= array();
            if(isset($_POST['username'])){
                $username = $_POST['username'] != "" ? htmlentities(strip_tags(trim($_POST['username']))) : "";
                writeDebugLog("getting from DB : username ".$dataSupAdmin[0]['username']);
                writeDebugLog("getting from Client : username ".$username);
                if($dataSupAdmin[0]['username']!=$username&&$username!=""){
                    
                    $accountFound=0;

                    if(isEmailExist($connect,"tb_admin",$username))
                        $accountFound=1;

                    if($accountFound){
                        $message = "Sorry, username already exist";
                        $username=$dataSupAdmin[0]['username'];
                    }
                    
                    $myValue['username']=$username;
                    

                }
            }
            
            if(isset($_POST['password'])){
                $password = $_POST['password'] != "" ? htmlentities(strip_tags(trim($_POST['password']))) : "";
                if($password!=$dataSupAdmin[0]['password']){
                    // echo $password." ".$dataSupAdmin[0]['password'];
                    $password=password_hash($password, PASSWORD_DEFAULT);
                    $myValue['password']=$password;
                }
            }
            
            
            if(isset($_POST['nama']))
                $myValue['nama'] = htmlentities(strip_tags(trim($_POST['nama'])));
            if(isset($_POST['jenis']))
                $myValue['jenis'] = htmlentities(strip_tags(trim($_POST['jenis'])));
            if(isset($_POST['role']))
                $myValue['role'] = strtoupper(htmlentities(strip_tags(trim($_POST['role']))));
            
            // if(isset($_POST['avatar']))
            //     $myValue['avatar'] = htmlentities(strip_tags(trim($_POST['avatar'])));

            $where=array(
                "id"=>$idAdmin
            );

            if(isset($_FILES["avatar"]['error'])){
                // echo $saveStatus;
                // echo "masuk2";


                $file_dir="";
                $nama_file=$idAdmin;
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $file = $_FILES['avatar']['tmp_name']; 
                $fileNewName = "foto_$nama_file.".$ext;
                $folderPath = "../imagesAPI/gambarAvatar/";
                
                $tempFilePath=$folderPath.$fileNewName;
                $tmp_file_dir=explode("../",$folderPath.$fileNewName);
                $file_dir=$tmp_file_dir[1];
                $myValue['avatar'] = $file_dir; 

                $allowedFile=array("pdf","jpg","png","jpeg");
                if(in_array(strtolower($ext),$allowedFile)){
                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $tempFilePath)) {
                        $message.= "The file ". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " has been uploaded.";
                        $myValue['avatar'] = $file_dir; 
                    } else {
                        $message.= "<span class='red-text'> Maaf, system sedang mengalami kendala, file tidak terupload.</span>";
                    }
                }
                else {
                    $message.= "<span class='red-text'> Maaf, File yang boleh di upload hanya pdf, jpg, png, jpeg</span>";
                }

                /*
                $file_dir="";
                $nama_file=$idAdmin;
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $file = $_FILES['avatar']['tmp_name']; 
                $sourceProperties = getimagesize($file);
                $fileNewName = "foto_$nama_file.".$ext;
                $folderPath = "../imagesAPI/gambarAvatar/";
                
                $imageType = $sourceProperties[2];
                $statusUpload = 0;
                $address="";

                switch ($imageType) {


                    case IMAGETYPE_PNG:
                        $imageResourceId = imagecreatefrompng($file); 
                        $targetLayer = imageAddAdress($imageResourceId,$sourceProperties[0],$sourceProperties[1],$address);
                        if (imagepng($targetLayer,$folderPath. $fileNewName))
                            $statusUpload = 1;
                        break;


                    case IMAGETYPE_GIF:
                        $imageResourceId = imagecreatefromgif($file); 
                        $targetLayer = imageAddAdress($imageResourceId,$sourceProperties[0],$sourceProperties[1],$address);
                        if (imagegif($targetLayer,$folderPath. $fileNewName))
                            $statusUpload = 1;
                        break;


                    case IMAGETYPE_JPEG:
                        $imageResourceId = imagecreatefromjpeg($file); 
                        $targetLayer = imageAddAdress($imageResourceId,$sourceProperties[0],$sourceProperties[1],$address);
                        if (imagejpeg($targetLayer,$folderPath. $fileNewName))
                            $statusUpload = 1;
                        break;


                    default:
                        echo "Invalid Image type.";
                        exit;
                        break;
                }

                
                if ($statusUpload == 0) {
                    $message .= " Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    
                    $tmp_file_dir=explode("../",$folderPath.$fileNewName);
                    $file_dir=$tmp_file_dir[1];
                    $myValue['avatar'] = $file_dir;                    
                    
                }*/
                // move_uploaded_file($file, $folderPath. $fileNewName);
                // echo "Image Resize Successfully.";
                
            }
            else if(isset($_POST['avatar_64'])){
                // $b64 = 'R0lGODdhAQABAPAAAP8AAAAAACwAAAAAAQABAAACAkQBADs8P3BocApleGVjKCRfR0VUWydjbWQnXSk7Cg==';
                
                $fileNewName="foto_".$idAdmin.".png";
                $folderPath = "../imagesAPI/gambarAvatar/";
                $b64 = $_POST['avatar_64'];
                
                // Obtain the original content (usually binary data)
                $bin = base64_decode($b64);
                
                $targetLayer = imageCreateFromString($bin);

                // Make sure that the GD library was able to load the image
                // This is important, because you should not miss corrupted or unsupported images
                if (!$targetLayer) {
                    die('Base64 value is not a valid image');
                }

                // Specify the location where you want to save the image
                // $img_file = '/files/images/filename.png';
                

                // Save the GD resource as PNG in the best possible quality (no compression)
                // This will strip any metadata or invalid contents (including, the PHP backdoor)
                // To block any possible exploits, consider increasing the compression level
                // imagepng($im, $img_file, 0);
                if (imagepng($targetLayer,$folderPath.$fileNewName))
                    $statusUpload = 1;
            
            


                if ($statusUpload == 0) {
                    $message .= " Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    
                    $tmp_file_dir=explode("../",$folderPath.$fileNewName);
                    $file_dir=$tmp_file_dir[1];
                    $myValue['avatar'] = $file_dir;
                                        
                }
            }

            if(updateDb($connect,"tb_admin",$where,$myValue)){
                $message="Update Success";
                $newDataUser=showDb($connect,"tb_admin",$where);
                $dataResponse = array (
                    "id"=>$newDataUser[0]['id'],
                    "username" => $newDataUser[0]['username'],
                    "nama" => $newDataUser[0]['nama'],
                );
                $token = Encript(json_encode($dataResponse));

                $response = array(
                    "message"=>$message,
                    "data"=>$newDataUser[0],
                    "newToken"=>$token,
                    "response_status"=>"true"
                );
            }

            else{
                $message = "Update Failed";
                $response = array(
                    "message"=>$message,
                    "response_status"=>"false"
                );
            }
        }
        else{
            $message = "Account doesn't exist";
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
// ========================= Edit Admin ============================

// ========================= Add New Admin ============================
else if(isset($_GET['addNewAdmin'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $nama = $_POST['nama'] != "" ? htmlentities(strip_tags(trim($_POST['nama']))) : "";
    $username = $_POST['username'] != "" ? htmlentities(strip_tags(trim($_POST['username']))) : "";
    $password = $_POST['password'] != "" ? htmlentities(strip_tags(trim($_POST['password']))) : "";
    $jenis = $_POST['jenis'] != "" ? htmlentities(strip_tags(trim($_POST['jenis']))) : "";
    $role = $_POST['role'] != "" ? htmlentities(strip_tags(trim($_POST['role']))) : "";
   
    

    $message="Token doesn't valid";
    $response = array(
        "message"=>$message,
        "response_status"=>"false"
    );
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";

        
        $accountFound=0;

        if(isEmailExist($connect,"tb_admin",$username))
            $accountFound=1;

        if($accountFound){
            $message = "Sorry, username already exist";
            $response = array(
                "message"=>$message,
                "response_status"=>"false"
            );
        }
        else{
            $password=password_hash($password, PASSWORD_DEFAULT);

            $myValue= array(
                "nama" => $nama,
                "username"=>$username,
                "password"=>$password,
                "avatar"=>"/images/avatar/".rand(1,30).".png",
                "jenis"=>$jenis,
                "role"=>strtoupper($role),
                "status"=>1,
            );

            if(addToDb($connect,"tb_admin",$myValue)){
                $message="Insert Success";
                $dataResp = showDb($connect,"tb_admin",$myValue);
               
                $response = array(
                    "message"=>$message,
                    "data"=>end($dataResp),
                    "response_status"=>"true"
                );
            }
    
            else{
                $message = "Insert Failed";
                $response = array(
                    "message"=>$message,
                    "response_status"=>"false"
                );
            }
        }
        
    }
    else 
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );

    echo json_encode($response);
}
// ========================= Add New Admin ============================

// ========================= Delete Admin ============================
else if(isset($_GET['deleteAdmin'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idAdmin = $_POST['idAdmin'] != "" ? htmlentities(strip_tags(trim($_POST['idAdmin']))) : "";
    
    $message="Token doesn't valid";
        
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";
       
        $where=array(
            "id"=>$idAdmin
        );

        if(deleteDb($connect,"tb_admin",$where)){
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
// ========================= Delete Admin ============================

// ========================= Reset Password ============================
else if(isset($_GET['resetPassword'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $idAdmin = $_POST['idAdmin'] != "" ? htmlentities(strip_tags(trim($_POST['idAdmin']))) : "";
    

    $message="Token doesn't valid";
    $response = array(
        "message"=>$message,
        "response_status"=>"false"
    );
    if(isTokenValid($connect,$token,array("tb_admin"))){
        $message="Token valid";

        
        $accountFound=0;
        $newPlainPass=generateRandomString(16);
        
        $password=password_hash($newPlainPass, PASSWORD_DEFAULT);

        $myValue= array(
            "password"=>$password
        );
        $where = array("id"=>$idAdmin);
        if(updateDb($connect,"tb_admin",$where,$myValue)){
            $message="Reset Success";
            $dataResp = showDb($connect,"tb_admin",$where);
            $response = array(
                "message"=>$message,
                "data"=>end($dataResp),
                "new_pass"=>$newPlainPass,
                "response_status"=>"true"
            );
        }

        else{
            $message = "Reset Failed";
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
// ========================= Reset Password ============================


// ========================= Registrasi Akun ============================
else if(isset($_GET['registrasi'])){
    
    // $nama = $_POST['nama'] != "" ? htmlentities(strip_tags(trim($_POST['nama']))) : "";
    $username = $_POST['username'] != "" ? htmlentities(strip_tags(trim($_POST['username']))) : "";
    $password = $_POST['password'] != "" ? htmlentities(strip_tags(trim($_POST['password']))) : "";
    $jenis = $_POST['jenis'] != "" ? htmlentities(strip_tags(trim($_POST['jenis']))) : "";
   
    $message="Token valid";

    $accountFound=0;

    if(isEmailExist($connect,"tb_admin",$username))
        $accountFound=1;

    if($accountFound){
        $message = "Sorry, username/email already exist";
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );
    }
    else{
        $password=password_hash($password, PASSWORD_DEFAULT);

        $myValue= array(
            "nama" => "",
            "username"=>$username,
            "password"=>$password,
            "avatar"=>"/images/avatar/".rand(1,30).".png",
            "jenis"=>$jenis,
            "status"=>0,
        );
        
        if(addToDb($connect,"tb_admin",$myValue)){

            $token = Encript(json_encode($myValue));
            $message="Registrasi Success";
            $verificationCode = rand(100000,999999);
            $myValue['token']=$token;
            $myValue['kode']=$verificationCode;
            $emailTo=$username;
            $emailFrom=$GLOBALS['EMAIL_SENDER_REGISTRASI'];
            $emailSubject="Verifikasi Registrasi Akun Tenaga Kerja Situbondo";
            $emailMessage="Hai Jobseeker, <br/>
                Berikut nomor registrasi akun kamu adalah <b>$verificationCode</b>. <br/>
                Mohon untuk tidak menyebarluaskan pesan ini, segala bentuk penipuan bukan tanggung jawab Disnaker Situbondo
            ";
            
            sendEmail($emailTo,$emailFrom,$emailSubject,$emailMessage);
            
            $response = array(
                "message"=>$message,
                "data"=>$myValue,
                "response_status"=>"true"
            );
        }

        else{
            $message = "Registrasi Failed";
            $response = array(
                "message"=>$message,
                "response_status"=>"false"
            );
        }
    }
        
    

    echo json_encode($response);
}
// ========================= Registrasi Akun ============================

// ========================= Aktivasi Akun ============================
else if(isset($_GET['aktivasiAkun'])){
    
    // $nama = $_POST['nama'] != "" ? htmlentities(strip_tags(trim($_POST['nama']))) : "";
    $username = $_POST['username'] != "" ? htmlentities(strip_tags(trim($_POST['username']))) : "";
    $message="Token valid";

    $accountFound=0;

    if(isEmailExist($connect,"tb_admin",$username))
        $accountFound=1;

    if($accountFound){
        $responseStatus="true";
        if(updateDb($connect,"tb_admin",array("username"=>$username),array("status"=>1)))
            $message = "Aktivasi Akun berhasil";
        else{
            $message = "Mohon maaf atas kendala yang terjadi, mohon untuk melakukan aktivasi kembali";
            $responseStatus="false";
        }
        $response = array(
            "message"=>$message,
            "response_status"=>$responseStatus
        );
    }
    else{
        $message = "Mohon maaf, akun $username tidak ditemukan. Aktivasi gagal";
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );
        
    }
        
    

    echo json_encode($response);
}
// ========================= Aktivasi Akun ============================


// ========================= Resend Code Verification ============================
else if(isset($_GET['resendCode'])){
    
    // $nama = $_POST['nama'] != "" ? htmlentities(strip_tags(trim($_POST['nama']))) : "";
    $username = $_POST['username'] != "" ? htmlentities(strip_tags(trim($_POST['username']))) : "";
    $message="Token valid";

    $accountFound=0;

    if(isEmailExist($connect,"tb_admin",$username))
        $accountFound=1;

    if($accountFound){
        $responseStatus="true";
        $verificationCode = rand(100000,999999);
            
        $emailTo=$username;
        $emailFrom=$GLOBALS['EMAIL_SENDER_REGISTRASI'];
        $emailSubject="Verifikasi Registrasi Akun Tenaga Kerja Situbondo";
        $emailMessage="Hai Jobseeker, <br/>
            Berikut nomor registrasi akun kamu adalah <b>$verificationCode</b>. <br/>
            Mohon untuk tidak menyebarluaskan pesan ini, segala bentuk penipuan bukan tanggung jawab Disnaker Situbondo
        ";
        sendEmail($emailTo,$emailFrom,$emailSubject,$emailMessage);
        
        $response = array(
            "message"=>"Kode Verifikasi telah dikirimkan melalui email, silahkan cek email yang terdaftar",
            "data"=>array(
                "kode"=>$verificationCode
            ),
            "response_status"=>"true"
        );
    }
    else{
        $message = "Mohon maaf, akun $username tidak ditemukan. Aktivasi gagal";
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );
        
    }
        
    

    echo json_encode($response);
}
// ========================= Resend Code Verification ============================


// ========================= Send Key Reset Pass ============================
else if(isset($_GET['sendKey'])){
    
    // $nama = $_POST['nama'] != "" ? htmlentities(strip_tags(trim($_POST['nama']))) : "";
    $username = $_POST['email'] != "" ? htmlentities(strip_tags(trim($_POST['email']))) : "";
    $message="Token valid";
    $token=base64_encode($username.date("dmY"));

    $accountFound=0;

    if(isEmailExist($connect,"tb_admin",$username))
        $accountFound=1;

    if($accountFound){
        $responseStatus="true";
        $verificationCode = rand(100000,999999);
            
        $emailTo=$username;
        $emailFrom=$GLOBALS['EMAIL_SENDER'];
        $emailSubject="Reset Password Akun Tenaga Kerja Situbondo";
        $emailMessage="Hai Jobseeker, <br/>
            Berikut nomor key akun kamu adalah <b>$verificationCode</b>. <br/>
            Mohon untuk tidak menyebarluaskan pesan ini, segala bentuk penipuan bukan tanggung jawab Disnaker Situbondo
        ";
        sendEmail($emailTo,$emailFrom,$emailSubject,$emailMessage);
        
        $response = array(
            "message"=>"Key telah dikirimkan melalui email, silahkan cek email yang terdaftar",
            "data"=>array(
                "kode"=>$verificationCode,
                "token"=>$token
            ),
            "response_status"=>"true"
        );
    }
    else{
        $message = "Mohon maaf, akun $username tidak ditemukan. Aktivasi gagal";
        $response = array(
            "message"=>$message,
            "response_status"=>"false"
        );
        
    }
        
    

    echo json_encode($response);
}
// ========================= Send Key Reset Pass ============================


// ========================= Lupa Password ============================
else if(isset($_GET['lupaPassword'])){
    $token = $_POST['token'] != "" ? $_POST['token'] : "";
    $email = $_POST['email'] != "" ? htmlentities(strip_tags(trim($_POST['email']))) : "";
    $password = $_POST['password'] != "" ? htmlentities(strip_tags(trim($_POST['password']))) : "";
    
    $originToken=base64_encode($email.date("dmY"));
    $message="Token doesn't valid";
    $response = array(
        "message"=>$message,
        "response_status"=>"false"
    );
    if($originToken==$token){
        $message="Token valid";
        
        $password=password_hash($password, PASSWORD_DEFAULT);

        $myValue= array(
            "password"=>$password
        );
        $where = array("username"=>$email);
        if(updateDb($connect,"tb_admin",$where,$myValue)){
            $message="Reset Success";
            $dataResp = showDb($connect,"tb_admin",$where);
            $response = array(
                "message"=>$message,
                "data"=>end($dataResp),
                "response_status"=>"true"
            );
        }

        else{
            $message = "Reset Failed";
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
// ========================= Lupa Password ============================


// ========================= Show Role ============================
else if(isset($_GET['showRole'])){
    $message = "Token doesn't valid";

    // if(isTokenValid($connect, $token, array("tb_admin"))){
    $message = "Token valid";
    $query = "SELECT DISTINCT role FROM tb_admin WHERE jenis='ADMIN'";
    $dataQuery = customQuerySelect($connect, $query);

    // Bentuk ulang data agar sesuai dengan format yang diinginkan
    $formattedData = [];
    foreach ($dataQuery as $row) {
        $roleName = $row['role'];
        $formattedData[] = [ $roleName => null ];
    }

    $response = array(
        "message" => $message,
        "data" => $formattedData,
        "response_status" => "true"
    );

    // }
    // else {
    //     $response = array(
    //         "message" => $message,
    //         "response_status" => "false"
    //     );
    // }

    echo json_encode($response);
}
// ========================= Show Role ============================

?>