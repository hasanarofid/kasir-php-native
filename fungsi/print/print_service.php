<h4>Data Service</h4>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';
    
// Ambil data service dari database berdasarkan ID yang diterima dari parameter 'bayar'
$id_service = $_GET['bayar'];
$id_service = $_GET['bayar'];

// Periksa apakah variabel $_GET['bayar'] telah diatur sebelum menjalankan kueri
if(isset($_GET['bayar']) && !empty($_GET['bayar'])) {
    // Kueri SQL untuk mengambil data service berdasarkan id_service
    $query = "SELECT * FROM service WHERE id_service = $id_service";

    // Jalankan kueri SQL
    $result = $conn->query($query);
    var_dump($result);die;
    // Periksa apakah terdapat kesalahan saat menjalankan kueri
    if (!$result) {
        // Jika terjadi kesalahan, tampilkan pesan kesalahan
        echo "Error: " . $conn->error;
    } else {
        // Jika kueri berhasil dijalankan, lanjutkan dengan pemrosesan hasil
        // ...
    }
} else {
    // Jika variabel $_GET['bayar'] tidak diatur atau kosong, tampilkan pesan kesalahan
    echo "Error: No 'bayar' parameter provided.";
}


// Periksa apakah data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
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

}
?>
