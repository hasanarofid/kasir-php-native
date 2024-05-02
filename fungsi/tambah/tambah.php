<?php

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';
    
    
if (!empty($_GET['kategori'])) {
        $nama= htmlentities(htmlentities($_POST['kategori']));
        $tgl= date("j F Y, G:i");
        $data[] = $nama;
        $data[] = $tgl;
        $sql = 'INSERT INTO kategori (nama_kategori,tgl_input) VALUES(?,?)';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&success=tambah-data"</script>';
}
    


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['service'])) {
    // Sanitize and escape user input
    $id_service = htmlspecialchars($_POST['id_service']);
    $pelanggan = htmlspecialchars($_POST['pelanggan']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $hp = htmlspecialchars($_POST['hp']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $kerusakan = htmlspecialchars($_POST['kerusakan']);
    $perangkat = htmlspecialchars($_POST['perangkat']);
    $kelengkapan = htmlspecialchars($_POST['kelengkapan']);
    $keterangan = htmlspecialchars($_POST['keterangan']);
    $status_p = htmlspecialchars($_POST['status_p']);
    $status_s = htmlspecialchars($_POST['status_s']);
    $tgl = date("j F Y, G:i");
    $biaya = htmlspecialchars($_POST['biaya']);
    $bayar = htmlspecialchars($_POST['bayar']);

    // Prepare data array for SQL query
    $data = array($id_service, $kategori, $alamat, $hp, $perangkat, $kelengkapan, $kerusakan, $keterangan, $pelanggan, $status_p, $status_s, $tgl, $biaya, $bayar);

    // Prepare and execute SQL query
    $sql = 'INSERT INTO service (id_service, kategori, alamat, hp, perangkat, kelengkapan, kerusakan, keterangan, pelanggan, status_p, status_s, tgl, biaya, bayar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $config->prepare($sql);
    $stmt->execute($data);

    if ($stmt->rowCount() > 0) {
        // Redirect to success page
        // Get the ID of the last inserted service
$id_service_baru = $config->lastInsertId();

// Redirect to success page with the ID of the new service
echo '<script>window.location="../../index.php?page=service&success=tambah-data&bayar=' . $id_service_baru . '"</script>';

        // echo '<script>window.location="../../index.php?page=service&success=tambah-data"</script>';
        exit(); // stop further execution
    } else {
        // Handle insertion failure (e.g., database error)
        echo 'Error inserting data: ' . $stmt->error;
    }
}


if (!empty($_GET['barang'])) {
        $id = htmlentities($_POST['id']);
        $kategori = htmlentities($_POST['kategori']);
        $nama = htmlentities($_POST['nama']);
        $merk = htmlentities($_POST['merk']);
        $beli = htmlentities($_POST['beli']);
        $jual = htmlentities($_POST['jual']);
        $satuan = htmlentities($_POST['satuan']);
        $stok = htmlentities($_POST['stok']);
        $tgl = htmlentities($_POST['tgl']);

        $data[] = $id;
        $data[] = $kategori;
        $data[] = $nama;
        $data[] = $merk;
        $data[] = $beli;
        $data[] = $jual;
        $data[] = $satuan;
        $data[] = $stok;
        $data[] = $tgl;
        $sql = 'INSERT INTO barang (id_barang,id_kategori,nama_barang,merk,harga_beli,harga_jual,satuan_barang,stok,tgl_input) 
			    VALUES (?,?,?,?,?,?,?,?,?) ';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=barang&success=tambah-data"</script>';
}
    
    
    if (!empty($_GET['jual'])) {
        $id = $_GET['id'];

        // get tabel barang id_barang
        $sql = 'SELECT * FROM barang WHERE id_barang = ?';
        $row = $config->prepare($sql);
        $row->execute(array($id));
        $hsl = $row->fetch();

        if ($hsl['stok'] > 0) {
            $kasir =  $_GET['id_kasir'];
            $jumlah = 1;
            $total = $hsl['harga_jual'];
            $tgl = date("j F Y, G:i");

            $data1[] = $id;
            $data1[] = $kasir;
            $data1[] = $jumlah;
            $data1[] = $total;
            $data1[] = $tgl;

            $sql1 = 'INSERT INTO penjualan (id_barang,id_member,jumlah,total,tanggal_input) VALUES (?,?,?,?,?)';
            $row1 = $config -> prepare($sql1);
            $row1 -> execute($data1);

            echo '<script>window.location="../../index.php?page=jual&success=tambah-data"</script>';
        } else {
            echo '<script>alert("Stok Barang Anda Telah Habis !");
					window.location="../../index.php?page=jual#keranjang"</script>';
        }
    }
}
