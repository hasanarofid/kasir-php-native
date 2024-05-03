<?php 
    @ob_start();
    session_start();
    if(empty($_SESSION['admin'])){
        echo '<script>window.location="login.php";</script>';
        exit;
    }
    require 'config.php';
    include $view;
    $lihat = new view($config);
    $toko = $lihat->toko();
    $id_service = isset($_GET['id_service']) ? $_GET['id_service'] : null;
    // var_dump($id_service);die;
    
    // Fungsi untuk mengambil data service berdasarkan id_service
    function ser($id_service, $config) {
        // $db = new PDO($config['dsn'], $config['username'], $config['password']);
        $sql = "SELECT * FROM service WHERE id = :id_service";
        $stmt = $config->prepare($sql);
        $stmt->bindParam(':id_service', $id_service, PDO::PARAM_INT);
        $stmt->execute();
        $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }

    // Memanggil fungsi ser() untuk mendapatkan data service
    $hasil = ser($id_service, $config);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Service - Bosss Printer</title>
    <style>
        /* Invoice Template */
        #invoice-template {
            width: 1733.78 px; /* Setengah kertas A4 */
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .invoice-template {
            display: block;
            margin-bottom: 20px;
        }

        /* Invoice Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .invoice-logo {
            width: 150px;
            height: auto;
        }

        .invoice-info {
            text-align: right;
        }

        /* Invoice Customer */
        .invoice-customer {
            margin-bottom: 20px;
        }

        /* Invoice Table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .invoice-footer {
            text-align: center; /* (Optional) Center text in the footer */
            display: flex; /* Enable flexbox layout */
            justify-content: space-between; /* Distribute space between signature and total */
            align-items: flex-start; /* Align items vertically (signature top, total top) */
        }

        .footer {
            text-align: center; /* (Optional) Center text in the footer */
            display: flex; /* Enable flexbox layout */
            justify-content: space-between; /* Distribute space between signature and total */
            align-items: flex-start; /* Align items vertically (signature top, total top) */
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .signature-container {
            margin-top: 20px;
            text-align: left;
        }

        .signature-area {
            width: 100px;
            height: 50px;
            border: 1px dashed #ccc;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div id="invoice-template">
        <div class="invoice-header">
            <div class="invoice-logo">
                <img src="assets/img/logo.png" alt="Logo Bosss Printer" width="300px">
            </div>
            <div class="invoice-info">
                <h2><?php echo $toko['nama_toko'];?></h2>
                <p><?php echo $toko['alamat_toko'];?></p>
                <p>Telp. <?php echo $toko['tlp'];?></p>
                <p>Email: <?php echo $toko['email'];?></p>
            </div>
        </div>

        <div class="invoice-customer">
            <p>Tanggal : <?php echo $hasil[0]['tgl']; ?></p>
            <p>Nama Pelanggan : <?php echo $hasil[0]['pelanggan']; ?></p>
            <p>Alamat : <?php echo $hasil[0]['alamat']; ?></p>
            <p>No HP : <?php echo $hasil[0]['hp']; ?></p>
        </div>

        <div class="invoice-table">
            <table class="table table-bordered" style="width:100%;">
                <tr>
                    <td>Code Service</td>
                    <td>Kerusakan</td>
                    <td>Kategori</td>
                    <td>Perangkat</td>
                    <td>Kelengkapan</td>
                    <td>Keterangan</td>
                </tr>
                <?php foreach($hasil as $isi){?>
                <tr>
                    <td><?php echo $isi['id_service'];?></td>
                    <td><?php echo $isi['kerusakan'];?></td>
                    <td><?php echo $isi['kategori'];?></td>
                    <td><?php echo $isi['perangkat'];?></td>
                    <td><?php echo $isi['kelengkapan'];?></td>
                    <td><?php echo $isi['keterangan'];?></td>
                </tr>
                <?php }?>
            </table>
        </div>

        <div class="invoice-footer">
            <div class="signature-container">
                <p>Tanda Tangan :</p>
                <div class="signature-area"></div>
            </div>
            <div class="total"><br><br>
                Biaya : Rp.<?php echo $hasil[0]['biaya'];?>,-
                <br/>
                Bayar : Rp.<?php echo $hasil[0]['bayar'];?>,-
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda.</p>
            <p><?php echo $toko['nama_toko'];?></p>
        </div>
    </div>
</body>
</html>
