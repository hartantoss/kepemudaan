<?php
$arrayValue=array('tb_pekerja_pendidikan','tb_pelamar','tb_pelatihan','tb_pengaduan_phit','tb_pengaduan_phit_response','tb_pengaduan_pmi','tb_pengaduan_pmi_response','tb_peraturan','tb_peraturan_detail','tb_perusahaan','tb_perusahaan_benefit','tb_perusahaan_disabilitas','tb_perusahaan_tenagakerja','tb_pkwt','tb_pkwt_detail');
$arrayValue2=array('namaPengaduPHIForm','jenisKelaminPengaduPHIForm','alamatRumahPengaduPHIForm','pekerjaanPHIForm','alamatKantorPengaduPHIForm','emailPengaduPHIForm','noKTPPengaduPHIForm','noHpPengaduPHIForm','lainLainPengaduPHIForm','jenisPerselisihanPHIForm','caraPengirimanPHIForm','tujuanPHIForm','deskripsiPHIForm','rencanaPHIForm');
$arrayValue3=array("Latitude","Longitude","Nama Pemilik","Jenis Kelamin","Jenis Industri","Aset Pendukung","Aset Nonpendukung","Omzet","Cakupan Pemasaran Kota","Cakupan Pemasaran Provinsi","Cakupan Pemasaran Nasional","Cakupan Pemasaran Internasional","Media Promosi Sosial","Media Promosi Elektronik","Media Promosi Cetak","Media Promosi Lainnya","Kendala SDA","Kendala Modal","Kendala Perizinan","Kendala Infrastruktur","Kendala Lainnya","Kendala Prioritas");
$arrayValue4=array("Aplikasi","Pengembang Game (Game Developer)","Arsitektur","Desain Interior","Desain Komunikasi Visual","Desain Produk","Fashion","Film, Animasi, dan Video","Fotografi","Kriya","Kuliner","Musik","Penerbitan","Periklanan","Seni Pertunjukan","Seni Rupa","Televisi dan Radio");

$myText="
ALTER TABLE `%s` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);"; 

$fixText="";

for($a=0;$a<sizeof($arrayValue); $a++){
    // $tmpText=str_replace('%c',$a,$myText);
    // $tmpText=str_replace('%c',lcfirst($arrayValue[$a]),$myText);
    $tmpText=str_replace('%s',$arrayValue[$a],$myText);
    $fixText.=$tmpText;
}

echo "
    <pre>
        ".htmlentities($fixText)."
    </pre>
";
?>