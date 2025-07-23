<?php
include '../connect.php';
function sendRawPostRequest($url, $rawData, $contentType = 'application/json') {
    $ch = curl_init($url);

    // Set opsi cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: ' . $contentType,
        'Content-Length: ' . strlen($rawData)
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $verbose = fopen('php://temp', 'rw+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); // Paksa IPv4

    // Eksekusi request
    $response = curl_exec($ch);

    // Periksa error
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        fclose($verbose);
        curl_close($ch);
        throw new Exception("cURL Error: " . $error_msg . "\nVerbose Output:\n" . htmlspecialchars($verboseLog));
    }

    // Dapatkan kode status HTTP
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Tutup koneksi cURL
    curl_close($ch);
    fclose($verbose);

    // Kembalikan response dan kode status
    return [
        'response' => $response,
        'httpcode' => $httpcode
    ];
}


// Contoh Penggunaan:
$url = "https://prod-14.southeastasia.logic.azure.com/workflows/346aaa88a7054952a25e2c075fccfbb7/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=uD8PWm7XGG24e8RxiP4gpt8cRWF1hn5VrnWBeqBCKAU"; // Ganti dengan URL endpoint Anda
$data = json_encode(['key1' => 'value1', 'key2' => 'value2']); // Contoh data JSON

try {
    $result = sendRawPostRequest($url, $data, 'application/json');

    echo "HTTP Code: " . $result['httpcode'] . "\n";
    echo "Response:\n" . $result['response'] . "\n";

    if ($result['httpcode'] >= 200 && $result['httpcode'] < 300) {
        echo "Request berhasil!\n";
    } else {
        echo "Request gagal.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>