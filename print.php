<?php 
	@ob_start();
	session_start();
	if(!empty($_SESSION['admin'])){ }else{
		echo '<script>window.location="login.php";</script>';
        exit;
	}
	require 'config.php';
	include $view;
	$lihat = new view($config);
	$toko = $lihat -> toko();
	$hasil = $lihat -> nota();
	$hsl = $lihat -> penjualan();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - Bosss Printer</title>
</head>
<body>
    
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
    
    
    <div id="invoice-template">
        <div class="invoice-template">
            <div class="invoice-template">
                <br>
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
        <p>Tanggal : <?php echo date("j F Y, G:i");?></p>
        <p>Nama Pelanggan : <?php echo $nota['pelanggan']; ?></p>
        <p>Alamat : <?php echo $nota['alamat']; ?></p>
        <p>No HP : <?php echo $nota['hp']; ?></p>
    </div>


                <div class="invoice-table">
	<table class="table table-bordered" style="width:100%;">
						<tr>
							<td>No.</td>
							<td>Barang</td>
							<td>Jumlah</td>
							<td>Total</td>
						</tr>
						<?php $no=1; foreach($hsl as $isi){?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $isi['nama_barang'];?></td>
							<td><?php echo $isi['jumlah'];?></td>
							<td><?php echo $isi['total'];?></td>
						</tr>
						<?php $no++; }?>
					</table>
	<div class="invoice-footer">
    <div class="signature-container">
        <p>Tanda Tangan :</p>
        <div class="signature-area"></div>
    </div>
    <div class="total"><br><br>
        	<?php $hasil = $lihat -> jumlah(); ?>
						Total : Rp.<?php echo number_format($hasil['bayar']);?>,-
						<br/>
						Bayar : Rp.<?php echo number_format(htmlentities($_GET['bayar']));?>,-
						<br/>
						Kembali : Rp.<?php echo number_format(htmlentities($_GET['kembali']));?>,-
        </div>
</div>
					<div class="clearfix"></div>
                             </tbody>
                                  </table>
                              <br>
                    	<div class="footer">
                    <p>Terima kasih atas kunjungan Anda.</p>
                    <p><?php echo $toko['nama_toko'];?></p>
                </div></div>
            </div>
        </div>
    </div>
