<?php
include_once("../connect.php");

$fh = fopen('dbData.txt','r');
// echo "<pre>";

$listDB=array();
$ccListDB=0;
$ccListClm=0;
while ($line = fgets($fh)) {
 
    if(preg_match("/tb_/",$line)){
        $ccListDB++;
        $ccListClm=0;
        $listDB[$ccListDB]['tb_name']=trim($line);
    }

    if(preg_match("/- /",$line)){
        $columnText=explode('- ',$line)[1];

        $listDB[$ccListDB]['column'][$ccListClm]=array(
            "nama"=>trim(explode("|",$columnText)[0]),
            "type"=>trim(explode("|",$columnText)[1]),
            "length"=>trim(explode("|",$columnText)[2]),
        );
        $ccListClm++;
    }

}

// print_r($listDB);
// echo "</pre>";
fclose($fh);


for($a=1; $a<=sizeof($listDB); $a++){
    $queryText="CREATE TABLE `".$listDB[$a]['tb_name']."` (";
    for($b=0;$b<sizeof($listDB[$a]['column']);$b++)
        $queryText.="`".$listDB[$a]['column'][$b]['nama']."` ".$listDB[$a]['column'][$b]['type'].($listDB[$a]['column'][$b]['type']=="text"?"":"(".$listDB[$a]['column'][$b]['length'].")")." NOT NULL".($b==(sizeof($listDB[$a]['column'])-1)?"":",");
        
    $queryText.=" ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    echo $queryText."<br/><br/>";
    customExecQuery($connect,$queryText);
    $queryText="ALTER TABLE `".$listDB[$a]['tb_name']."` ADD PRIMARY KEY (`id`)";
    echo $queryText."<br/><br/>";
    customExecQuery($connect,$queryText);
    $queryText="ALTER TABLE `".$listDB[$a]['tb_name']."` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
    echo $queryText."<br/><br/>";
    customExecQuery($connect,$queryText);
    echo $listDB[$a]['tb_name']." Created<br/><br/>";



}
?>