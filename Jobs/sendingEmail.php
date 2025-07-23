<?php

include "../connect.php";
date_default_timezone_set("Asia/Jakarta");
$myStyleCSS="
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700');

        * {
            box-sizing: border-box;
        }

        body {
            --h: 212deg;
            --l: 43%;
            --brandColor: hsl(var(--h), 71%, var(--l));
            font-family: Montserrat, sans-serif;
            margin: 0;
            background-color: whitesmoke;
        }

        p {
            margin: 0;
            line-height: 1.6;
        }

        ol {
            list-style: none;
            counter-reset: list;
            padding: 0 1rem;
        }

        li {
            --stop: calc(100% / var(--length) * var(--i));
            --l: 62%;
            --l2: 88%;
            --h: calc((var(--i) - 1) * (180 / var(--length)));
            --c1: hsl(var(--h), 71%, var(--l));
            --c2: hsl(var(--h), 71%, var(--l2));
            
            position: relative;
            counter-increment: list;
            max-width: 45rem;
            margin: 2rem auto;
            padding: 2rem 1rem 1rem;
            box-shadow: 0.1rem 0.1rem 1.5rem rgba(0, 0, 0, 0.3);
            border-radius: 0.25rem;
            overflow: hidden;
            background-color: white;
        }

        li::before {
            content: '';
            display: block;
            width: 100%;
            height: 1rem;
            position: absolute;
            top: 0;
            left: 0;
            background: linear-gradient(to right, var(--c1) var(--stop), var(--c2) var(--stop));
        }

        h3 {
            display: flex;
            align-items: baseline;
            margin: 0 0 1rem;
            color: rgb(70 70 70);
        }

        h3::before {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 0 0 auto;
            margin-right: 1rem;
            width: 3rem;
            height: 3rem;
            content: counter(list);
            padding: 1rem;
            border-radius: 50%;
            background-color: var(--c1);
            color: white;
        }

        @media (min-width: 40em) {
            li {
                margin: 3rem auto;
                padding: 3rem 2rem 2rem;
            }
            
            h3 {
                font-size: 2.25rem;
                margin: 0 0 2rem;
            }
            
            h3::before {
                margin-right: 1.5rem;
            }
        }
    </style>
";

// ========================= cornJob Sending Email ============================

$subjectEmail="Disnaker - Training Baru";
$countList=0;
$startIdRegistered="";
$startIdAdditional="";
$lastIdRegistered="0";
$lastIdAdditional="0";
$endRegisteredList=false;
$endAdditionalList=false;

// get new Pelatihan / Training
$whereListEmail=array("sent_status"=>"0", "tipe"=>"PELATIHAN");
$dataListSendEmail=showDb($connect,"tb_must_send_email",$whereListEmail);

// compose email Body
$bodyText="
<html>
    <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title></title>
    </head>
    <body>
        $myStyleCSS

        <div style='width:100%; padding:auto;'>
            <div style='width:80%; padding:10% 10% 5% 10%; margin:auto; text-align:justify;'>
                <h2>Hai %nama%,</h2>
                <p style='font-size:20px;'>Kami punya kabar gembira! Daftar pelatihan terbaru kami sudah siap dan pastinya sayang banget kalau kamu lewatkan. Yuk, tingkatkan skill dan pengetahuan kamu dengan mengikuti pelatihan-pelatihan keren ini: </p>
            </div>
        </div>
    </body>
</html>
";

$bodyText.="<ol style='--length: ".sizeof($dataListSendEmail)."' role='list'>";
for($a=0;$a<sizeof($dataListSendEmail);$a++){
    $wherePelatihan=array(
        "id"=>$dataListSendEmail[$a]['id_item']
    );
    $dataThisPelatihan=showDB($connect,"tb_pelatihan",$wherePelatihan);
    if(sizeof($dataThisPelatihan)>0){
        $countList++;
        $bodyText.="
            <li style='--i: $countList'>
                <h3>".$dataThisPelatihan[0]['judul']."</h3>
                <p>
                    Lokasi : ".$dataThisPelatihan[0]['lokasi']."<br>
                    Tanggal : ".$dataThisPelatihan[0]['tanggal'].", ".$dataThisPelatihan[0]['waktu']."<br>
                    Biaya : ".$dataThisPelatihan[0]['biaya']."<br>
                </p>
                <a href='$URL/detailTraining/".$dataThisPelatihan[0]['id']."'>Lihat lebih bayak</a>
            </li>
            
        ";
        $startIdRegistered=$dataListSendEmail[$a]['last_user_register'];
        $startIdAdditional=$dataListSendEmail[$a]['last_user_additional'];
    }
}
$bodyText.='</ol>';



if(sizeof($dataListSendEmail)>0){
    $fixBodyText=$bodyText;
    echo $fixBodyText;
    // Sending email from user registered
    $queryRegisterEmail="SELECT * FROM tb_admin WHERE id > '$startIdAdditional' LIMIT 100";
    $listEmailRegistered=customQuerySelect($connect,$queryRegisterEmail);
    for($a=0;$a<sizeof($listEmailRegistered);$a++){
        writeDebugLog("Get Email : ".$listEmailRegistered[$a]['username']);
        if(preg_match('/@/i',$listEmailRegistered[$a]['username'])){
            $bodyEmail=str_replace("%nama%",$listEmailRegistered[$a]['nama'],$fixBodyText);

            if(sendEmail($listEmailRegistered[$a]['username'],$GLOBALS['EMAIL_SENDER_PELATIHAN'],$subjectEmail,$bodyEmail))
                writeDebugLog("Success Sent Email To : ".$listEmailRegistered[$a]['username']);
            else
                writeDebugLog("Failed Sent Email To : ".$listEmailRegistered[$a]['username']);
        }
        else
            writeDebugLog($listEmailRegistered[$a]['username']." is not an email");

        $lastIdRegistered=$listEmailRegistered[$a]['id'];
    }
    if($a<100)
        $endRegisteredList=true;


    // Sending email from user additional
    $queryAdditionalEmail="SELECT * FROM tb_email_additional WHERE id > '$startIdRegistered' LIMIT 100";
    $listEmailAdditional=customQuerySelect($connect,$queryAdditionalEmail);
    for($a=0;$a<sizeof($listEmailAdditional);$a++){
        writeDebugLog("Get Email : ".$listEmailAdditional[$a]['email']);
        if(preg_match('/@/i',$listEmailAdditional[$a]['email'])){
            $bodyEmail=str_replace("%nama%",$listEmailRegistered[$a]['nama'],$fixBodyText);
            if(sendEmail($listEmailAdditional[$a]['email'],$GLOBALS['EMAIL_SENDER_PELATIHAN'],$subjectEmail,$bodyEmail))
                writeDebugLog("Success Sent Email To : ".$listEmailAdditional[$a]['email']);
            else
                writeDebugLog("Failed Sent Email To : ".$listEmailAdditional[$a]['email']);
        }
        else
            writeDebugLog($listEmailAdditional[$a]['email']." is not an email");

        $lastIdAdditional=$listEmailAdditional[$a]['id'];
    }
    if($a<100)
        $endAdditionalList=true;

    $valueEmail=array(
        "last_user_additional"=>$lastIdAdditional,
        "last_user_register"=>$lastIdRegistered
    );
    if($endAdditionalList&&$endRegisteredList)
        $valueEmail['sent_status']="1";

    updateDb($connect,"tb_must_send_email",$whereListEmail,$valueEmail);
    echo "Process Completed";
}
else{
    echo "No data that need to sent";
}

// ========================= cornJob Sending Email ============================


?>