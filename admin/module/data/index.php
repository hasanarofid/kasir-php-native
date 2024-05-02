 <?php 
  	$id = $_GET['service'];
	$hasil = $lihat -> service_edit($id);
 
 
	$bulan_tes =array(
		'01'=>"Januari",
		'02'=>"Februari",
		'03'=>"Maret",
		'04'=>"April",
		'05'=>"Mei",
		'06'=>"Juni",
		'07'=>"Juli",
		'08'=>"Agustus",
		'09'=>"September",
		'10'=>"Oktober",
		'11'=>"November",
		'12'=>"Desember"
	);
?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered w-100 table-sm" id="example1">
                <thead>
                    <tr style="background:#DFF0D8;color:#333;">
                        <th>No</th>
                        <th>Code Service</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>No Hp</th>
                        <th>Kerusakan</th>
                        <th>Kategori</th>
                        <th>Perangkat</th>
                        <th>Kelengkapan</th>
                        <th>Keterangan</th>
                        <th style="width:10%;">Biaya</th>
                        <th style="width:10%;">Bayar</th>
                        <th style="width:10%;">Pembayaran</th>
                        <th style="width:10%;">Status</th>
                        <th>Tanggal Input</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no=1; 
                        if(!empty($_GET['cari'])){
                            $periode = $_POST['bln'].'-'.$_POST['thn'];
                            $no=1; 
                            $bayar = 0;
                            $hasil = $lihat->periode_service($periode);
                        } elseif(!empty($_GET['hari'])){
                            $hari = $_POST['hari'];
                            $no=1; 
                            $bayar = 0;
                            $hasil = $lihat->hari_service($hari);
                        } else {
                            $hasil = $lihat->service();
                        }
                    ?>
                    <?php 
                        $no=1;
                        foreach($hasil as $isi){
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $isi['id_service'];?></td>
                        <td><?php echo $isi['pelanggan'];?></td>
                        <td><?php echo $isi['alamat'];?></td>
                        <td><?php echo $isi['hp'];?></td>
                        <td><?php echo $isi['kerusakan'];?></td>
                        <td><?php echo $isi['kategori'];?></td>
                        <td><?php echo $isi['perangkat'];?></td>
                        <td><?php echo $isi['kelengkapan'];?></td>
                        <td><?php echo $isi['keterangan'];?></td>
                        <td>Rp.<?php echo number_format($isi['biaya']);?>,-</td>
                        <td>Rp.<?php echo number_format($isi['bayar']);?>,-</td>
                        <td><?php if($isi['status_p'] == 'Belum Lunas'){?><b style="color:#ff2424;"><?php echo $isi['status_p'];?></b><?php }else{?><b style="color:#0bb365;"><?php echo $isi['status_p'];?></b><?php }?></td>
                        <td><?php if($isi['status_s'] == 'Diservice'){?><b style="color:#ffc824;"><?php echo $isi['status_s'];?></b><?php }else if($isi['status_s'] == 'Selesai'){?><b style="color:#2424ff;"><?php echo $isi['status_s'];?></b><?php }else{?><b style="color:#0bb365;"><?php echo $isi['status_s'];?></b><?php }?></td>
                        <td><?php echo $isi['tgl'];?></td>
                        <td>

    <?php if ($isi['status_s'] == 'Diservice') {?>
        <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#selesai<?php echo $isi['id_service'];?>">Selesai</button>
    <?php } else if ($isi['status_s'] == 'Selesai') {?>
        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#bayar<?php echo $isi['id_service'];?>">Bayar</button>
    <?php } else{?>
        <a href="print_s.php?nm_member=<?php echo $_SESSION['admin']['nm_member'];?>" target="_blank">
    <button class="btn btn-secondary">
     Print Struk
    </button>
</a>
    <?php }?>
                        <a href="" data-toggle="modal" data-target="#service_edit<?php echo $isi['id_service'];?>"><button
                                class="btn btn-warning btn-xs">Edit</button></a>
                                
                        <a href="fungsi/hapus/hapus.php?service=hapus&id=<?php echo $isi['id_service'];?>"
                            onclick="javascript:return confirm('Hapus Barang Ini?');"><button
                                class="btn btn-danger btn-xs">Hapus</button></a>
                        </td>
                    </tr>
                    <?php $no++; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br><br>
<?php
function hitungTotalService($hasil) {
    $totalDiservice = 0;
    $totalSelesai = 0;
    $totalDiambil = 0;

    foreach ($hasil as $isi) {
        if ($isi['status_s'] == 'Diservice') {
            $totalDiservice++;
        } elseif ($isi['status_s'] == 'Selesai') {
            $totalSelesai++;
        } elseif ($isi['status_s'] == 'Diambil') {
            $totalDiambil++;
        }
    }

    $jumlah = $totalDiservice + $totalSelesai + $totalDiambil;

    return array(
        'jumlah' => $jumlah,
        'totalDiservice' => $totalDiservice,
        'totalSelesai' => $totalSelesai,
        'totalDiambil' => $totalDiambil
    );
}

// Panggil fungsi dan simpan hasilnya dalam variabel
$totals = hitungTotalService($hasil);

// Output pada footer
?>

<div class="row">
    <!--STATUS cards -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="pt-2"><i class="fas fa-list"></i></i> Jumlah Orderan Service</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1><?php echo $totals['jumlah'];?></h1>
                </center>
            </div>
        </div>
        <!--/card -->
    </div><!-- /col-md-3-->

    <!-- STATUS cards -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h6 class="pt-2"><i class="fas fa-wrench"></i> Jumlah Sedang Di Service</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1><?php echo $totals['totalDiservice'];?></h1>
                </center>
            </div>
        </div>
        <!--/card -->
    </div><!-- /col-md-3-->

    <!-- STATUS cards -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="pt-2"><i class="fas fa-check"></i> Jumlah Selesai Di Service</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1><?php echo $totals['totalSelesai'];?></h1>
                </center>
            </div>
        </div>
        <!--/card -->
    </div><!-- /col-md-3-->

    <!-- STATUS cards -->
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="pt-2"><i class="fas fa-cubes"></i> Jumlah Telah Diambil</h6>
            </div>
            <div class="card-body">
                <center>
                    <h1><?php echo $totals['totalDiambil'];?></h1>
                </center>
            </div>
        </div>
        <!--/card -->
    </div><!-- /col-md-3-->
</div>
<br>


<!-- Modal Pengembalian Start -->
<?php foreach ($hasil as $isi) { ?>
    <div class="modal fade" id="selesai<?php echo $isi['id_service']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Selesaikan Service Perangkat</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        Apakah perangkat sudah selesai diservice?
                        <br><br>	
                        <label class="control-label" for="typeahead">Service Code </label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="id_service" value="<?php echo $isi['id_service']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Nama Pelanggan </label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="pelanggan" value="<?php echo $isi['pelanggan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Alamat Pelanggan </label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="alamat" value="<?php echo $isi['alamat']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">No Hp Pelanggan </label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="hp" value="<?php echo $isi['hp']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kerusakan</label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="kerusakan" value="<?php echo $isi['kerusakan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kategori</label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="kategori" value="<?php echo $isi['kategori']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Perangkat </label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="perangkat" value="<?php echo $isi['perangkat']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kelengkapan </label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="kelengkapan" value="<?php echo $isi['kelengkapan']; ?>">
                        </div><br>
                           <label class="control-label" for="typeahead">Keterangan </label>
						<div class="input-group">
                            <input type="text" class="form-control"  readonly="readonly" name="keterangan" value="<?php echo $isi['keterangan']; ?>">
                        </div><br>
                        <input type="hidden" name="status_s" value="Selesai">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="selesai_service">Iya</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
<!-- Modal Pengembalian End -->

<?php foreach ($hasil as $isi) { ?>
    <div class="modal fade" id="bayar<?php echo $isi['id_service']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Selesaikan Pembayaran Service</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        Apakah ingin diselesaikan pembayaran servicenya?
                        <br><br>	
                        <label class="control-label" for="typeahead">Service Code </label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="id_service" value="<?php echo $isi['id_service']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Nama Pelanggan </label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="pelanggan" value="<?php echo $isi['pelanggan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Alamat Pelanggan </label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="alamat" value="<?php echo $isi['alamat']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">No Hp Pelanggan </label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="hp" value="<?php echo $isi['hp']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kerusakan</label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="kerusakan" value="<?php echo $isi['kerusakan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kategori</label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="kategori" value="<?php echo $isi['kategori']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Perangkat </label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="perangkat" value="<?php echo $isi['perangkat']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kelengkapan </label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="kelengkapan" value="<?php echo $isi['kelengkapan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Keterangan </label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="keterangan" value="<?php echo $isi['keterangan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Biaya Service</label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="biaya" value="<?php echo $isi['biaya']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Dp / Sudah Dibayar </label>
						<div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="bayar" value="<?php echo $isi['bayar']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Penulasan </label>
						<div class="input-group">
                            <input type="text" class="form-control" name="bayar" placeholder="Masukkan Uang Penulasan" required>
                        </div>
                        <input type="hidden" name="status_s" value="Diambil">
                        <input type="hidden" name="status_p" value="Lunas">
                        <input type="hidden" name="tgl" value="<?php echo  date("j F Y, G:i");?>">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="selesai_bayar">Iya</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>


<?php foreach ($hasil as $isi) { ?>
    <div class="modal fade" id="service_edit<?php echo $isi['id_service']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Service</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form method="post" action="fungsi/edit/edit.php?service=edit<?php echo $isi['id_service']; ?>">
                    <div class="modal-body">
                        Apakah Anda ingin menyimpan perubahan data service ini?
                        <br><br>    
                        <label class="control-label" for="typeahead">Service Code </label>
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="readonly" name="id_service" value="<?php echo $isi['id_service']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Nama Pelanggan </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="pelanggan" value="<?php echo $isi['pelanggan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Alamat Pelanggan </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="alamat" value="<?php echo $isi['alamat']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">No Hp Pelanggan </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="hp" value="<?php echo $isi['hp']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kerusakan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="kerusakan" value="<?php echo $isi['kerusakan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kategori</label>
                        <div class="input-group">
                              <select name="kategori" class="form-control" required>
                                    <option value="#">Pilih Kategori</option>
                                    <?php foreach($kategori as $kat){ ?>
                                    <option value="<?php echo $kat['id_kategori']; ?>" <?php echo ($isi['kategori'] == $kat['id_kategori']) ? 'selected' : ''; ?>>
                                        <?php echo $kat['nama_kategori']; ?></option>
                                    <?php }?>
                                </select>
                        </div><br>
                        <label class="control-label" for="typeahead">Perangkat </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="perangkat" value="<?php echo $isi['perangkat']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Kelengkapan </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="kelengkapan" value="<?php echo $isi['kelengkapan']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Keterangan </label>
                        <div class="input-group">
                            <textarea class="form-control" name="keterangan"><?php echo $isi['keterangan']; ?></textarea>
                        </div><br>
                        <label class="control-label" for="typeahead">Biaya Service</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="biaya" value="<?php echo $isi['biaya']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Dibayar </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="bayar" value="<?php echo $isi['bayar']; ?>">
                        </div><br>
                        <label class="control-label" for="typeahead">Status Pembayaran </label>
                        <div class="input-group">
                            <select name="status_p" class="form-control">
                                <option value="Lunas" <?php echo ($isi['status_p'] == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
                                <option value="Belum Lunas" <?php echo ($isi['status_p'] == 'Belum Lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                            </select>
                        </div><br>
                        <input type="hidden" name="status_s" value="Diambil">
                        <input type="hidden" name="tgl" value="<?php echo date("j F Y, G:i"); ?>">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>






<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['service_edit'])) {
    // Sanitasi dan escape input pengguna
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
    $data = array($kategori, $alamat, $hp, $perangkat, $kelengkapan, $kerusakan, $keterangan, $pelanggan, $status_p, $status_s, $tgl, $biaya, $bayar, $id_service);

    // Prepare and execute SQL query for updating data
    $sql = 'UPDATE service SET kategori=?, alamat=?, hp=?, perangkat=?, kelengkapan=?, kerusakan=?, keterangan=?, pelanggan=?, status_p=?, status_s=?, tgl=?, biaya=?, bayar=? WHERE id_service=?';
    $stmt = $config->prepare($sql);
    $stmt->execute($data);

    // Check if the update operation was successful
    if ($stmt->rowCount() > 0) {
        // Redirect to the service page with success message
        echo '<script>window.location="index.php?page=data&uid=' . $id_service . '&success=edit-data"</script>';
        exit(); // Stop further execution
    } else {
        // Handle update failure (e.g., database error)
        echo 'Error updating data: ' . $stmt->error;
    }
}  


// Memeriksa apakah data selesai_bayar telah dikirim melalui metode POST
if (isset($_POST['selesai_bayar'])) {
    // Mengambil data dari formulir
    $status_s = htmlentities($_POST['status_s']);
    $status_p = htmlentities($_POST['status_p']);
    $bayar = htmlentities($_POST['bayar']); // Penambahan
    $id_service = htmlentities($_POST['id_service']);
    $tgl = htmlentities($_POST['tgl']);

    // Menyiapkan data untuk dieksekusi dalam query
    $data = array($status_s, $status_p, $bayar, $tgl, $id_service); // Penambahan

    // Menyiapkan dan mengeksekusi query untuk mengupdate status layanan menjadi "Selesai"
    $sql = 'UPDATE service SET status_s=?, status_p=?, bayar=?, tgl=? WHERE id_service=?';
    $row = $config->prepare($sql);
    $row->execute($data);

    // Redirect kembali ke halaman data dengan pesan sukses
    echo '<script>window.location="index.php?page=data&uid=' . $id_service . '&success-bayar=edit-data"</script>';
} elseif (isset($_POST['selesai_service'])) {
    // Memeriksa apakah data selesai_service telah dikirim melalui metode POST
    // Mengambil data dari formulir
    $status_s = htmlentities($_POST['status_s']);
    $id_service = htmlentities($_POST['id_service']);

    // Menyiapkan data untuk dieksekusi dalam query
    $data = array($status_s, $id_service);

    // Menyiapkan dan mengeksekusi query untuk mengupdate status layanan menjadi "Selesai"
    $sql = 'UPDATE service SET status_s=? WHERE id_service=?';
    $row = $config->prepare($sql);
    $row->execute($data);

    // Redirect kembali ke halaman data dengan pesan sukses
    echo '<script>window.location="index.php?page=data&uid=' . $id_service . '&success-update=edit-data"</script>';
} else {
    // Jika tidak ada data yang dikirimkan, tidak perlu menampilkan pesan error
    // Karena ini adalah kondisi normal
}

