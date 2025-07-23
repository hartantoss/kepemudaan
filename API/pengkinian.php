
<?php
include "../connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$entities = [
    "PemudaInovatif" => [
        "table" => "tb_pemuda_inovatif_staging",
        "fields" => [
            "nama", "nik", "tempat_lahir", "tanggal_lahir", "alamat_ktp",
            "alamat_domisili",  "kecamatan", "jenis_kelamin", "no_hp", "email", "instagram", "nama_karya",
            "bidang_karya", "tahun_mulai_karya","deskripsi", "upload_file"
        ]
    ],
    "PemudaPelopor" => [
        "table" => "tb_pemuda_pelopor_staging",
        "fields" => [
            "nama", "nik", "tempat_lahir", "tanggal_lahir", "alamat_ktp",
            "alamat_domisili",  "kecamatan", "jenis_kelamin", "no_hp", "email", "instagram", "nama_kepeloporan",
            "bidang_kepeloporan", "tahun_mulai_pelopor","deskripsi", "upload_file"
        ]
    ],
    "WirausahaMuda" => [
        "table" => "tb_wirausaha_muda_staging",
        "fields" => [
            "nama_pemilik", "nik", "tempat_lahir", "tanggal_lahir", "alamat_ktp",
            "alamat_domisili",  "kecamatan", "jenis_kelamin", "no_hp", "email", "instagram", "nama_usaha",
            "no_hp_pemilik", "jenis_usaha",
            "nama_produk", "tahun_mulai_usaha","deskripsi","nib", "upload_file"
        ]
    ],
    "PemudaBerprestasi" => [
        "table" => "tb_pemuda_berprestasi_staging",
        "fields" => [
            "nama", "nik", "tempat_lahir", "tanggal_lahir", "alamat_ktp",
            "alamat_domisili",  "kecamatan", "jenis_kelamin", "no_hp", "email", "instagram", "nama_prestasi",
            "peringkat", "penyelenggara", "tahun_prestasi", "upload_file"
        ]
    ],
    "PemudaBerorganisasi" => [
        "table" => "tb_pemuda_berorganisasi_staging",
        "fields" => [
            "nama", "nik", "tempat_lahir", "tanggal_lahir", "alamat_ktp",
            "alamat_domisili",  "kecamatan", "jenis_kelamin", "no_hp", "email", "instagram", "nama_organisasi",
            "ketua_organisasi", "no_hp_ketua",
            "kegiatan", "tahun_bergabung"
        ]
    ],
    "DutaPemuda" => [
        "table" => "tb_duta_pemuda_staging",
        "fields" => [
            "nama", "nik", "tempat_lahir", "tanggal_lahir", "alamat_ktp",
            "alamat_domisili",  "kecamatan", "jenis_kelamin", "no_hp", "email", "instagram", "predikat",
            "prestasi_akademik", "prestasi_non_akademik", "upload_file"
        ]
    ],
    "OrganisasiKepemudaan" => [
        "table" => "tb_organisasi_kepemudaan_staging",
        "fields" => [
            "nama_organisasi", "ketua_organisasi",
            "jumlah_anggota", "no_hp_ketua",
            "kegiatan", "tanggal_berdiri", "alamat_sekretariat", "email", "instagram", 
        ]
    ],
    "KomunitasKepemudaan" => [
        "table" => "tb_komunitas_kepemudaan_staging",
        "fields" => [       
            "alamat_sekretariat", "email", "instagram", "nama_komunitas",
            "ketua_komunitas",   "kecamatan", "jenis_kelamin", "no_hp_ketua",
            "jumlah_anggota", "kegiatan", "tanggal_berdiri"
        ]
    ]
];

$csvMappings = [
    "KomunitasKepemudaan" => [
        "table" => "tb_komunitas_kepemudaan_staging",
        "mapping" => [
            "Alamat Sekretariat Organisasi" => "alamat_sekretariat",
            "e-Mail" => "email",
            "Username Instagram" => "instagram",
            "Jenis Kelamin" => "jenis_kelamin",
            "Kecamatan" => "kecamatan",
            "Nama Organisasi" => "nama_komunitas",
            "Nama Ketua Organisasi" => "ketua_komunitas",
            "Nomor Hp Ketua Komunitas" => "no_hp_ketua",
            "Jumlah Anggota Komunitas" => "jumlah_anggota",
            "Kegiatan dalam Komunitas" => "kegiatan",
            "Tanggal Bediri Komunitas" => "tanggal_berdiri"
        ]
    ],
    "PemudaBerorganisasi" => [
        "table" => "tb_pemuda_berorganisasi_staging",
        "mapping" => [
            "Nama" => "nama",
            "Tempat Lahir" => "tempat_lahir",
            "Tanggal Lahir" => "tanggal_lahir",
            "NIK" => "nik",
            "Alamat sesuai KTP" => "alamat_ktp",
            "Alamat Domisili Kota Serang" => "alamat_domisili",
            "Jenis Kelamin" => "jenis_kelamin",
            "Kecamatan" => "kecamatan",
            "Nomor Hp" => "no_hp",
            "e-Mail" => "email",
            "Username Instagram" => "instagram",
            "Nama Organisasi" => "nama_organisasi",
            "Nama Ketua Organisasi" => "ketua_organisasi",
            "Nomor Hp Ketua Organisasi" => "no_hp_ketua",
            "Kegiatan dalam Organisasi" => "kegiatan",
            "Tahun Bergabung dengan Organisasi" => "tahun_bergabung"
        ]
    ],
    "OrganisasiKepemudaan" => [
        "table" => "tb_organisasi_kepemudaan_staging",
        "mapping" => [
            "Nama Organisasi" => "nama_organisasi",
            "Nama Ketua Organisasi" => "ketua_organisasi",
            "Jenis Kelamin" => "jenis_kelamin",
            "Kecamatan" => "kecamatan",
            "Nomor Hp Ketua Organisasi" => "no_hp_ketua",
            "Jumlah Anggota Organisasi" => "jumlah_anggota",
            "Kegiatan dalam Organisasi" => "kegiatan",
            "Tanggal Bediri Organisasi" => "tanggal_berdiri",
            "Alamat Sekretariat Organisasi" => "alamat_sekretariat",
            "e-Mail" => "email",
            "Username Instagram" => "instagram"
        ]
    ],
    "DutaPemuda" => [
        "table" => "tb_duta_pemuda_staging",
        "mapping" => [
            "Nama" => "nama",
            "Tempat Lahir" => "tempat_lahir",
            "Tanggal Lahir" => "tanggal_lahir",
            "NIK" => "nik",
            "Alamat sesuai KTP" => "alamat_ktp",
            "Alamat Domisili Kota Serang" => "alamat_domisili",
            "Jenis Kelamin" => "jenis_kelamin",
            "Kecamatan" => "kecamatan",
            "Nomor Hp" => "no_hp",
            "e-Mail" => "email",
            "Username Instagram" => "instagram",
            "Predikat Duta yang Diraih" => "predikat",
            "Prestasi Akademik" => "prestasi_akademik",
            "Prestasi Non Akademik" => "prestasi_non_akademik"
        ]
    ],
    "PemudaBerprestasi" => [
        "table" => "tb_pemuda_berprestasi_staging",
        "mapping" => [
            "Nama" => "nama",
            "Tempat Lahir" => "tempat_lahir",
            "Tanggal Lahir" => "tanggal_lahir",
            "NIK" => "nik",
            "Alamat sesuai KTP" => "alamat_ktp",
            "Alamat Domisili Kota Serang" => "alamat_domisili",
            "Jenis Kelamin" => "jenis_kelamin",
            "Kecamatan" => "kecamatan",
            "Nomor Hp" => "no_hp",
            "e-Mail" => "email",
            "Username Instagram" => "instagram",
            "Nama Prestasi" => "nama_prestasi",
            "Peringkat" => "peringkat",
            "Penyelenggara" => "penyelenggara",
            "Tahun Prestasi" => "tahun_prestasi"
        ]
    ],
    "WirausahaMuda" => [
        "table" => "tb_wirausaha_muda_staging",
        "mapping" => [
            "Nama Pemilik Usaha" => "nama_pemilik",
            "Tempat Lahir" => "tempat_lahir",
            "Tanggal Lahir" => "tanggal_lahir",
            "NIK" => "nik",
            "Alamat sesuai KTP" => "alamat_ktp",
            "Alamat Domisili Kota Serang" => "alamat_domisili",
            "Jenis Kelamin" => "jenis_kelamin",
            "Kecamatan" => "kecamatan",
            "Nomor Hp" => "no_hp",
            "e-Mail" => "email",
            "Username Instagram" => "instagram",
            "Nama Usaha" => "nama_usaha",            
            "Nomor Hp Pemilik Usaha" => "no_hp_pemilik",
            "Jenis Usaha" => "jenis_usaha",
            "Nama Produk" => "nama_produk",
            "Tahun Mulai Usaha" => "tahun_mulai_usaha",
            "Deskripsi Singkat tentang Kondisi UsahaTerkini" => "deskripsi",
            "Nomor NIB (jika ada silakan diisi)" => "nib"
        ]
    ],
    "PemudaPelopor" => [
        "table" => "tb_pemuda_pelopor_staging",
        "mapping" => [
            "Nama" => "nama",
            "Tempat Lahir" => "tempat_lahir",
            "Tanggal Lahir" => "tanggal_lahir",
            "NIK" => "nik",
            "Alamat sesuai KTP" => "alamat_ktp",
            "Alamat Domisili Kota Serang" => "alamat_domisili",
            "Jenis Kelamin" => "jenis_kelamin",
            "Kecamatan" => "kecamatan",
            "Nomor Hp" => "no_hp",
            "e-Mail" => "email",
            "Username Instagram" => "instagram",
            "Nama Kepeloporan" => "nama_kepeloporan",
            "Bidang Kepeloporan" => "bidang_kepeloporan",
            "Tahun Mulai dilaksanakan Kepeloporan" => "tahun_mulai_pelopor",
            "Deskripsi Singkat tentang Kepeloporan Terkini" => "deskripsi"
        ]
    ],
    "PemudaInovatif" => [
        "table" => "tb_pemuda_inovatif_staging",
        "mapping" => [
            "Nama" => "nama",
            "Tempat Lahir" => "tempat_lahir",
            "Tanggal Lahir" => "tanggal_lahir",
            "NIK" => "nik",
            "Alamat sesuai KTP" => "alamat_ktp",
            "Alamat Domisili Kota Serang" => "alamat_domisili",
            "Jenis Kelamin" => "jenis_kelamin",
            "Kecamatan" => "kecamatan",
            "Nomor Hp" => "no_hp",
            "e-Mail" => "email",
            "Username Instagram" => "instagram",
            "Nama Inovasi" => "nama_karya",
            "Bidang Inovasi" => "bidang_karya",
            "Tahun Mulai dilaksanakan Inovasi" => "tahun_mulai_karya",
            "Deskripsi Singkat tentang Karya Inovasi Terkini" => "deskripsi"
        ]
    ]
];

$grafikDefinitions = [
    "PemudaInovatif" => [
        ["field" => "jenis_kelamin", "type" => "pie", "label" => "Jenis Kelamin", "colClass"=>"col s12 m6"],
        ["field" => "kecamatan", "type" => "bar", "label" => "Kecamatan", "colClass"=>"col s12 m6"],
        ["field" => "bidang_karya", "type" => "bar", "label" => "Bidang Inovasi", "colClass"=>"col s12"]
    ],
    "PemudaPelopor" => [
        ["field" => "jenis_kelamin", "type" => "pie", "label" => "Jenis Kelamin", "colClass"=>"col s12 m6"],
        ["field" => "kecamatan", "type" => "bar", "label" => "Kecamatan", "colClass"=>"col s12 m6"],
        ["field" => "bidang_kepeloporan", "type" => "bar", "label" => "Bidang Kepeloporan", "colClass"=>"col s12"]
    ],
    "WirausahaMuda" => [
        ["field" => "jenis_kelamin", "type" => "pie", "label" => "Jenis Kelamin", "colClass"=>"col s12 m6"],
        ["field" => "kecamatan", "type" => "bar", "label" => "Kecamatan", "colClass"=>"col s12 m6"],
        ["field" => "jenis_usaha", "type" => "bar", "label" => "Jenis Usaha", "colClass"=>"col s12"]
    ],
    "PemudaBerprestasi" => [
        ["field" => "jenis_kelamin", "type" => "pie", "label" => "Jenis Kelamin", "colClass"=>"col s12 m6"],
        ["field" => "kecamatan", "type" => "bar", "label" => "Kecamatan", "colClass"=>"col s12 m6"],
        ["field" => "peringkat", "type" => "line", "label" => "Peringkat", "colClass"=>"col s12"],
        ["field" => "tahun_prestasi", "type" => "line", "label" => "Tahun Prestasi", "isYear" => true, "colClass"=>"col s12"]
    ],
    "PemudaBerorganisasi" => [
        ["field" => "jenis_kelamin", "type" => "pie", "label" => "Jenis Kelamin", "colClass"=>"col s12 m6"],
        ["field" => "kecamatan", "type" => "bar", "label" => "Kecamatan", "colClass"=>"col s12 m6"],
        ["field" => "tahun_bergabung", "type" => "line", "label" => "Tahun Bergabung", "isYear" => true, "colClass"=>"col s12"]
    ],
    "DutaPemuda" => [
        ["field" => "jenis_kelamin", "type" => "pie", "label" => "Jenis Kelamin", "colClass"=>"col s12 m6"],
        ["field" => "kecamatan", "type" => "bar", "label" => "Kecamatan", "colClass"=>"col s12 m6"],
        ["field" => "predikat", "type" => "line", "label" => "Predikat Duta Pemuda", "colClass"=>"col s12"]
    ],
    "OrganisasiKepemudaan" => [
        ["field" => "jenis_kelamin", "type" => "pie", "label" => "Jenis Kelamin", "colClass"=>"col s12 m6"],
        ["field" => "kecamatan", "type" => "bar", "label" => "Kecamatan", "colClass"=>"col s12 m6"],
        ["field" => "tanggal_berdiri", "type" => "line", "label" => "Tanggal Berdiri", "isYear" => true, "colClass"=>"col s12"],
        ["field" => "jumlah_anggota", "type" => "bar", "label" => "Jumlah Anggota", "isRange" => true, "colClass"=>"col s12"]
    ],
    "KomunitasKepemudaan" => [
        ["field" => "jenis_kelamin", "type" => "pie", "label" => "Jenis Kelamin", "colClass"=>"col s12 m6"],
        ["field" => "kecamatan", "type" => "bar", "label" => "Kecamatan", "colClass"=>"col s12 m6"],
        ["field" => "tanggal_berdiri", "type" => "line", "label" => "Tanggal Berdiri", "isYear" => true, "colClass"=>"col s12 m6"],
        ["field" => "jumlah_anggota", "type" => "bar", "label" => "Jumlah Anggota", "isRange" => true, "colClass"=>"col s12 m6"]
    ]
];
  
function reformatTanggal($input) {
    if (!$input || trim($input) === "" || strtolower(trim($input)) === "n/a") {
        return null;
    }

    $input = trim($input);

    // Format 1: d/m/Y → 22/07/2025
    $date = DateTime::createFromFormat('d/m/Y', $input);
    if ($date) return $date->format('Y-m-d');

    // Format 2: d-M-y → 25-Sep-96
    $date = DateTime::createFromFormat('d-M-y', $input);
    if ($date && $date->format('Y') >= 1900) return $date->format('Y-m-d');

    // Format 3: d F Y → 29 Desember 1995
    $indo_to_eng = [
        "Januari" => "January", "Februari" => "February", "Maret" => "March",
        "April" => "April", "Mei" => "May", "Juni" => "June",
        "Juli" => "July", "Agustus" => "August", "September" => "September",
        "Oktober" => "October", "November" => "November", "Desember" => "December"
    ];
    $input_eng = str_ireplace(array_keys($indo_to_eng), array_values($indo_to_eng), $input);
    $date = DateTime::createFromFormat('d F Y', $input_eng);
    if ($date) return $date->format('Y-m-d');

    // Format tidak dikenali
    return null;
}

function reformatDate($thisDate){
    $date = DateTime::createFromFormat('d/m/Y', $thisDate);
    return $date->format('Y-m-d');
}

function detectDelimiter($file) {
    $delimiters = [",", ";", "\t"];
    $firstLine = fgets(fopen($file, 'r'));
    $maxCount = 0;
    $delimiter = ",";

    foreach ($delimiters as $d) {
        $fields = str_getcsv($firstLine, $d);
        if (count($fields) > $maxCount) {
            $maxCount = count($fields);
            $delimiter = $d;
        }
    }
    return $delimiter;
}
function convertCsvDelimiter($inputFile, $outputFile, $from = ',', $to = ';') {
    if (!file_exists($inputFile)) {
        return false;
    }

    $inHandle = fopen($inputFile, 'r');
    $outHandle = fopen($outputFile, 'w');

    if (!$inHandle || !$outHandle) {
        return false;
    }

    while (($row = fgetcsv($inHandle, 0, $from)) !== false) {
        fputcsv($outHandle, $row, $to);
    }

    fclose($inHandle);
    fclose($outHandle);

    return true;
}

foreach ($entities as $key => $entity) {
    $lowerKey = strtolower($key);
    $table = $entity["table"];
    $fields = $entity["fields"];

    // SHOW
    if (isset($_GET["show{$key}"])) {
        $query = "SELECT * FROM $table WHERE 1=1 ";
        if (isset($_POST['id'])) $query .= " AND id='{$_POST['id']}' ";
        $query .= " ORDER BY id DESC";
        $data = customQuerySelect($connect, $query);
        echo json_encode([
            "message" => "Show success",
            "data" => $data,
            "response_status" => "true"
        ]);
        exit;
    }

    // LOAD
    if (isset($_GET["load{$key}Staging"])) {
        if (isset($_POST['type']) && isset($_POST['numPage']) && isset($_POST['search'])) {
            $sizePage = 20;
            $numPage = (int)$_POST['numPage'];
            $search = $_POST['search'];
            $type = $_POST['type'];
            $dataStart = (($numPage - 1) * $sizePage);

            $query ="";
            $queryAll ="";

            if($type=="SUMMARY"){
                $selector="nik";
                $querySearch="";

                if($key=="OrganisasiKepemudaan")
                    $selector="nama_organisasi";
                else if($key=="KomunitasKepemudaan")
                    $selector="nama_komunitas";
                

                if($search!=""){
                    $querySearch=" AND nik ='$search' ";
                    if($key=="OrganisasiKepemudaan")
                        $querySearch=" AND nama_organisasi like ('%$search%') ";
                    else if($key=="KomunitasKepemudaan")
                        $querySearch=" AND nama_komunitas like ('%$search%') ";
                }
                
                $query="SELECT $selector, count(*) AS jumlah From $table WHERE status in ('0','1','2') $querySearch GROUP BY $selector ORDER BY $selector ASC LIMIT $sizePage OFFSET $dataStart";
                $queryAll ="SELECT count(*) AS jumlah FROM (SELECT $selector, count(*) AS jml From $table  WHERE status in ('0','1','2') $querySearch GROUP BY $selector) AS sub";

            }
            else if($type=="DETAIL"){
                $querySearch="";
                if($search!=""){
                    $querySearch=" AND nik ='$search' ";
                    if($key=="OrganisasiKepemudaan")
                        $querySearch=" AND nama_organisasi like ('%$search%') ";
                    else if($key=="KomunitasKepemudaan")
                        $querySearch=" AND nama_komunitas like ('%$search%') ";
                }
                
                $query="SELECT * From $table WHERE status in ('0','1','2') $querySearch ORDER BY id, status DESC";
                $queryAll ="SELECT count(*) AS jumlah FROM (SELECT * From $table WHERE status in ('0','1','2') $querySearch ORDER BY id, status DESC) AS sub";

            }
            else if($type=="MAIN"){
                $querySearch="";
                
                if($search!=""){
                    $querySearch=" AND nik ='$search' ";
                    if($key=="OrganisasiKepemudaan")
                        $querySearch=" AND nama_organisasi like ('%$search%') ";
                    else if($key=="KomunitasKepemudaan")
                        $querySearch=" AND nama_komunitas like ('%$search%') ";
                }
                
                $query="SELECT * From $table WHERE status in ('2') $querySearch ORDER BY id, status DESC LIMIT $sizePage OFFSET $dataStart";
                $queryAll ="SELECT count(*) AS jumlah FROM (SELECT * From $table WHERE status in ('2') $querySearch ORDER BY id, status DESC) AS sub";

            }
            else if($type=="MAINALL"){
                $querySearch="";
                
                if($search!=""){
                    $querySearch=" AND nik ='$search' ";
                    if($key=="OrganisasiKepemudaan")
                        $querySearch=" AND nama_organisasi like ('%$search%') ";
                    else if($key=="KomunitasKepemudaan")
                        $querySearch=" AND nama_komunitas like ('%$search%') ";
                }
                
                $query="SELECT * From $table WHERE status in ('2') $querySearch ORDER BY id, status DESC";
                $queryAll ="SELECT count(*) AS jumlah FROM (SELECT * From $table WHERE status in ('2') $querySearch ORDER BY id, status DESC) AS sub";

            }
            
            else{
                $query = "SELECT * FROM $table WHERE 1=1 ";
                $queryAll = "SELECT count(*) AS jumlah FROM $table WHERE 1=1 ";

                if ($search != "") {
                    $query .= " AND (nama LIKE '%$search%') ";
                    $queryAll .= " AND (nama LIKE '%$search%') ";
                }

                $query .= " ORDER BY id DESC LIMIT $sizePage OFFSET $dataStart";
            }
            $dataResponse = customQuerySelect($connect, $query);
            $dataAll = customQuerySelect($connect, $queryAll);
            $listPageNum = range(1, ceil(((int)$dataAll[0]['jumlah']) / $sizePage));

            echo json_encode([
                "message" => "Load success",
                "data" => $dataResponse,
                "page_now" => $numPage,
                "list_page" => $listPageNum,
                "response_status" => "true"
            ]);
        } else {
            echo json_encode(["message" => "Data tidak lengkap", "response_status" => "false"]);
        }
        exit;
    }

    // DELETE
    if (isset($_GET["delete{$key}Staging"])) {
        $id = $_POST['id'] ?? "";
        if ($id) {
            $where = ["id" => $id];
            if (deleteDb($connect, $table, $where)) {
                echo json_encode(["message" => "Delete success", "response_status" => "true"]);
            } else {
                echo json_encode(["message" => "Delete failed", "response_status" => "false"]);
            }
        } else {
            echo json_encode(["message" => "ID tidak ditemukan", "response_status" => "false"]);
        }
        exit;
    }

    // SAVE
    if (isset($_GET["save{$key}Staging"])) {
        $myValue = [];
        // Penanganan file upload (jika ada field upload_file)
        if (in_array("upload_file", $fields) && isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
            $file = $_FILES['upload_file'];
            $allowedType = 'application/pdf';
            $maxSize = 1 * 1024 * 1024; // 1MB
            $uploadDir = "../imagesAPI/fileFormUpload/"; // buat folder ini jika belum ada

            // Validasi tipe dan ukuran
            if ($file['type'] != $allowedType) {
                echo json_encode(["message" => "File harus berupa PDF", "response_status" => "false"]);
                exit;
            }

            if ($file['size'] > $maxSize) {
                echo json_encode(["message" => "Ukuran file maksimal 1MB", "response_status" => "false"]);
                exit;
            }

            // Pastikan folder ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Simpan file
            $fileName = $key."_".uniqid("file_") . ".pdf";
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $myValue["upload_file"] = $fileName;
            } else {
                echo json_encode(["message" => "Gagal menyimpan file", "response_status" => "false"]);
                exit;
            }
        }

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $myValue[$field] = mysqli_real_escape_string($connect, htmlentities(strip_tags(trim($_POST[$field]))));
            }
        }
        if (isset($_POST['id'])) {
            $where = ['id' => $_POST['id']];
            if (updateDb($connect, $table, $where, $myValue)) {
                $dataResp = showDb($connect, $table, $where);
                echo json_encode([
                    "message" => "Update success",
                    "data" => end($dataResp),
                    "response_status" => "true"
                ]);
            } else {
                echo json_encode(["message" => "Update failed", "response_status" => "false"]);
            }
        } else {
            $myValue['created_date'] = date("Y-m-d H:i:s");
            $myValue['status'] = 1;
            if (addToDb($connect, $table, $myValue)) {
                $dataResp = showDb($connect, $table, $myValue);
                echo json_encode([
                    "message" => "Insert success",
                    "data" => end($dataResp),
                    "response_status" => "true"
                ]);
            } else {
                echo json_encode(["message" => "Insert failed", "response_status" => "false"]);
            }
        }
        exit;
    }

    // UPLOAD
    if (isset($_GET["upload{$key}Staging"])) {
        if (isset($_FILES["file_csv"]) && $_FILES["file_csv"]["error"] == 0) {
            $file = $_FILES["file_csv"]["tmp_name"];
            $delimiter = detectDelimiter($file);
    
            if ($delimiter === ',') {// convert delimiter
                $convertedFile = tempnam(sys_get_temp_dir(), 'csv_');
                if (convertCsvDelimiter($file, $convertedFile)) {
                    $file = $convertedFile;
                    $delimiter = ';'; // overwrite delimiter untuk proses selanjutnya
                } else {
                    echo json_encode([
                        "message" => "Gagal mengonversi CSV dari delimiter , ke ;",
                        "response_status" => "false"
                    ]);
                    exit;
                }
            }
    
            if (($handle = fopen($file, "r")) !== false) {
                $header = fgetcsv($handle, 1000, $delimiter);
                $mapping = $csvMappings[$key]["mapping"];
                $table = $csvMappings[$key]["table"];
    
                $columns = array_keys($mapping);
    
                $selector = "nik";
                if ($key == "OrganisasiKepemudaan") {
                    $selector = "nama_organisasi";
                } elseif ($key == "KomunitasKepemudaan") {
                    $selector = "nama_komunitas";
                }
    
                $successCount = 0;
                $failCount = 0;
                $duplicateCount = 0;
    
                while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    if (count($data) !== count($header)) {
                        writeDbLog("SKIPPED: header has " . count($header) . " cols, data has " . count($data) . " cols. Data: " . implode(", ", $data));
                        continue;
                    }
    
                    $rowAssoc = array_combine($header, $data);
                    $dbRow = [];
    
                    foreach ($mapping as $csvCol => $dbCol) {
                        $value = isset($rowAssoc[$csvCol]) ? trim($rowAssoc[$csvCol]) : '';
                        $dbRow[$dbCol] = mysqli_real_escape_string($connect, htmlentities(strip_tags($value)));
                    }
    
                    $searchVal = $dbRow[$selector];
                    $querySearch = "SELECT $selector, id FROM $table WHERE $selector = '$searchVal' AND status = '2' LIMIT 1";
                    // $result = mysqli_query($connect, $querySearch);
                    $result = customQuerySelect($connect, $querySearch);
    
                    $dbRow["uploaded_by"] = "ADMIN";
                    $dbRow["created_date"] = date("Y-m-d H:i:s");
                    // $dbRow["status"] = (mysqli_num_rows($result) > 0) ? 1 : 2;
                    // $dbRow["status"] == 1 ? $duplicateCount++ : "";
                    $dbRow["status"]=2;
    
                    if ($key == "KomunitasKepemudaan" || $key == "OrganisasiKepemudaan") {
                        $tgl = reformatTanggal($dbRow['tanggal_berdiri']);
                        if ($tgl) {
                            $dbRow['tanggal_berdiri'] = $tgl;
                        } else {
                            unset($dbRow['tanggal_berdiri']); // hapus jika null
                        }
                    } else {
                        $tgl = reformatTanggal($dbRow['tanggal_lahir']);
                        if ($tgl) {
                            $dbRow['tanggal_lahir'] = $tgl;
                        } else {
                            unset($dbRow['tanggal_lahir']); // hapus jika null
                        }
                    }
    
                    if(sizeof($result) > 0){
                        $where = ["id" => $result[0]['id']];
                        if (updateDb($connect, $table, $where,$dbRow)) {
                            $successCount++;
                        } else {
                            $failCount++;
                        }
                    }
                    else{
                        if (addToDb($connect, $table, $dbRow)) {
                            $successCount++;
                        } else {
                            $failCount++;
                        }
                    }
                }
    
                fclose($handle);
    
                echo json_encode([
                    "message" => "CSV processed. Success: $successCount, Failed: $failCount." . ($duplicateCount > 0 ? " <br/> Ditemukan $duplicateCount data yang sama dengan tabel Main, silahkan cek pada menu <b>Pending Appoval</b>" : ""),
                    "response_status" => "true"
                ]);
            } else {
                echo json_encode(["message" => "Failed to open CSV", "response_status" => "false"]);
            }
        } else {
            echo json_encode(["message" => "No CSV file uploaded", "response_status" => "false"]);
        }
        exit;
    }
    

    // Approve
    if (isset($_GET["approve{$key}Staging"])){
        $id = $_POST['id'] ?? "";
        $idMain = $_POST['idMain'] ?? "";
        if($idMain!='0'){
            $where = ["id" => $idMain];
            deleteDb($connect, $table, $where);
        }
        if ($id) {
            $where = ["id" => $id];
            $value = ["status"=>"2"];
            if (updateDb($connect, $table, $where,$value)) {
                echo json_encode(["message" => "Appove success", "response_status" => "true"]);
            } else {
                echo json_encode(["message" => "Appove failed", "response_status" => "false"]);
            }
        } else {
            echo json_encode(["message" => "ID tidak ditemukan", "response_status" => "false"]);
        }
        exit;
    }
    // Reject
    if (isset($_GET["reject{$key}Staging"])){
        $id = $_POST['id'] ?? "";
        if ($id) {
            $where = ["id" => $id];
            $value = ["status"=>"0"];
            if (updateDb($connect, $table, $where,$value)) {
                echo json_encode(["message" => "Reject success", "response_status" => "true"]);
            } else {
                echo json_encode(["message" => "Reject failed", "response_status" => "false"]);
            }
        } else {
            echo json_encode(["message" => "ID tidak ditemukan", "response_status" => "false"]);
        }
        exit;
    }
}

if(isset($_GET['loadGraph'])){
    $chartConfigs = [];
    $statusLabels = [];
    $statusValues = [];

    foreach ($grafikDefinitions as $entity => $charts) {
        if (!isset($entities[$entity])) continue;
        $table = $entities[$entity]['table'];

        foreach ($charts as $chart) {
            $field = $chart['field'];
            $type = $chart['type'];
            $label = $chart['label'];
            $colClass = $chart['colClass'];
            $isYear = $chart['isYear'] ?? false;
            $isRange = $chart['isRange'] ?? false;

            if ($isYear) {
                $query = "SELECT YEAR(`$field`) as label, COUNT(*) as jumlah FROM `$table` WHERE `$field` IS NOT NULL AND `$field` != '' AND status='2' GROUP BY YEAR(`$field`) ORDER BY YEAR(`$field`)";
            } elseif ($isRange) {
                $query = "SELECT 
                    CASE 
                    WHEN `$field` < 50 THEN '0-50'
                    WHEN `$field` < 100 THEN '50-100'
                    WHEN `$field` < 150 THEN '100-150'
                    WHEN `$field` < 200 THEN '150-200'
                    WHEN `$field` < 250 THEN '200-250'
                    ELSE '>250'
                    END AS label, COUNT(*) as jumlah 
                    FROM `$table` WHERE `$field` IS NOT NULL AND `$field` != '' AND status='2' GROUP BY label";
            } else {
                $query = "SELECT `$field` as label, COUNT(*) as jumlah FROM `$table` WHERE `$field` IS NOT NULL AND `$field` != '' AND status='2' GROUP BY `$field` ORDER BY jumlah DESC LIMIT 10";
            }

            $result = mysqli_query($connect, $query);
            $labels = [];
            $values = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $labels[] = $row['label'];
                $values[] = (int)$row['jumlah'];
            }

            $chartConfigs[] = [
                "title" => "$label - " . ucwords(preg_replace('/([a-z])([A-Z])/', '$1 $2', $entity)),
                "type" => $type,
                "colClass" => $colClass,
                "labels" => $labels,
                "values" => $values
            ];
        }

        // Kumpulkan data status = 2 ke satu grafik gabungan
        $statusQuery = "SELECT COUNT(*) as jumlah FROM `$table` WHERE `status` = 2";
        $res = mysqli_query($connect, $statusQuery);
        $count = mysqli_fetch_assoc($res)['jumlah'] ?? 0;

        $statusLabels[] = ucwords(preg_replace('/([a-z])([A-Z])/', '$1 $2', $entity));
        $statusValues[] = (int)$count;
    }

    // Tambahkan grafik gabungan status 2 ke AWAL
    array_unshift($chartConfigs, [
        "title" => "Data Kepemudaan",
        "type" => "bar",
        "colClass" => "col s12 m12",
        "labels" => $statusLabels,
        "values" => $statusValues
    ]);

    echo json_encode([
        "message" => "Load success",
        "data" => $chartConfigs,
        "response_status" => "true"
    ]);
}

?>
