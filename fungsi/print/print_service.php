<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Service</title>
</head>
<body>
    <h4>Data Service</h4>

    <?php
require '../../config.php';

// Ambil data service dari database berdasarkan ID yang diterima dari parameter 'bayar'
$id_service = isset($_GET['bayar']) ? $_GET['bayar'] : null;

// Periksa apakah variabel $_GET['bayar'] telah diatur sebelum menjalankan kueri
if(!empty($id_service)) {
    // Kueri SQL untuk mengambil data service berdasarkan id_service
    $query = "SELECT * FROM service WHERE id = :id_service";
$stmt = $config->prepare($query);
$stmt->bindParam(':id_service', $id_service);
$stmt->execute();
    // if ($stmt->execute()) {
    //     // statement executed successfully
    // } else {
        // error occurred
        // $errorInfo = $stmt->errorInfo();
        // echo "Error: " . $errorInfo[2];die;
    // }
    // $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($stmt->rowCount());die;
    // Periksa apakah terdapat kesalahan saat menjalankan kueri
    if ($stmt) {
        // Periksa apakah data ditemukan
        if ($stmt->rowCount() > 0) {
            // Ambil data baris
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<p><strong>Tanggal:</strong> ' . $row['tgl'] . '</p>';
            echo '<p><strong>Service Code:</strong> ' . $row['id_service'] . '</p>';
            echo '<p><strong>Nama Pelanggan:</strong> ' . $row['pelanggan'] . '</p>';
            echo '<p><strong>Alamat:</strong> ' . $row['alamat'] . '</p>';
            echo '<p><strong>No HP:</strong> ' . $row['hp'] . '</p>';
            echo '<p><strong>Kategori Perangkat:</strong> ' . $row['kategori'] . '</p>';
            echo '<p><strong>Nama Kerusakan:</strong> ' . $row['kerusakan'] . '</p>';
            echo '<p><strong>Nama Perangkat & Typenya:</strong> ' . $row['perangkat'] . '</p>';
            echo '<p><strong>Kelengkapan Barang:</strong> ' . $row['kelengkapan'] . '</p>';
            echo '<p><strong>Keterangan Perbaikan:</strong> ' . $row['keterangan'] . '</p>';
            echo '<p><strong>Biaya Perbaikan:</strong> ' . $row['biaya'] . '</p>';
            echo '<p><strong>Uang Tunai:</strong> ' . $row['bayar'] . '</p>';
            echo '<p><strong>Status Pembayaran:</strong> ' . $row['status_p'] . '</p>';
            echo '<p><strong>Status Service:</strong> ' . $row['status_s'] . '</p>';
        } else {
            echo 'Tidak ada data service.';
        }
    } else {
        // Jika terjadi kesalahan, tampilkan pesan kesalahan
        echo "Error: " . $config->errorInfo()[2];
    }
} else {
    // Jika variabel $_GET['bayar'] tidak diatur atau kosong, tampilkan pesan kesalahan
    echo "Error: No 'bayar' parameter provided.";
}
?>

<script>
    // Panggil fungsi window.print() saat halaman dimuat
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>
