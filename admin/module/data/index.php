<h4>Data Service</h4>
<br />
<?php if(isset($_GET['success-stok'])){?>
<div class="alert alert-success">
    <p>Tambah Service Berhasil !</p>
</div>
<?php }?>
<?php if(isset($_GET['success'])){?>
<div class="alert alert-success">
    <p>Tambah Data Berhasil !</p>
</div>
<?php }?>
<?php if(isset($_GET['remove'])){?>
<div class="alert alert-danger">
    <p>Hapus Service Berhasil !</p>
</div>
<?php }?>

<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
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
        <a href="print_s.php?nm_member=<?php echo $_SESSION['admin']['nm_member'];?>&id_service=<?php echo $isi['id'];?>" target="_blank">
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
<!-- end view barang -->
<!-- tambah barang MODALS-->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style=" border-radius:0px;">
            <div class="modal-header" style="background:#285c64;color:#fff;">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="fungsi/tambah/tambah.php?barang=tambah" method="POST">
                <div class="modal-body">
                    <table class="table table-striped bordered">
                        <?php
                            $format = $lihat->barang_id();
                        ?>
                        <tr>
                            <td>ID Barang</td>
                            <td><input type="text" readonly="readonly" required value="<?php echo $format;?>"
                                    class="form-control" name="id"></td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>
                                <select name="kategori" class="form-control" required>
                                    <option value="#">Pilih Kategori</option>
                                    <?php $kat = $lihat->kategori(); foreach($kat as $isi){ ?>
                                    <option value="<?php echo $isi['id_kategori'];?>">
                                        <?php echo $isi['nama_kategori'];?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Barang</td>
                            <td><input type="text" placeholder="Nama Barang" required class="form-control"
                                    name="nama"></td>
                        </tr>
                        <tr>
                            <td>Merk Barang</td>
                            <td><input type="text" placeholder="Merk Barang" required class="form-control"
                                    name="merk"></td>
                        </tr>
                        <tr>
                            <td>Harga Beli</td>
                            <td><input type="number" placeholder="Harga beli" required class="form-control"
                                    name="beli"></td>
                        </tr>
                        <tr>
                            <td>Harga Jual</td>
                            <td><input type="number" placeholder="Harga Jual" required class="form-control"
                                    name="jual"></td>
                        </tr>
                        <tr>
                            <!--<td>Satuan Barang</td>-->
                            <!--<td>-->
                            <!--    <select name="satuan" class="form-control" required>-->
                            <!--        <option value="#">Pilih Satuan</option>-->
                            <!--        <option value="PCS">PCS</option>-->
                            <!--    </select>-->
                            <!--</td>-->
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td><input type="number" required Placeholder="Stok" class="form-control" name="stok">
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td><input type="text" required readonly="readonly" class="form-control"
                                    value="<?php echo  date("j F Y, G:i");?>" name="tgl"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Insert Data</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
