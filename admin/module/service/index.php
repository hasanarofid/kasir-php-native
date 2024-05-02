<h4>Input Service Baru</h4>
<br />
<?php if(isset($_GET['success'])){?>
<div class="alert alert-success">
    <p>Tambah Data Berhasil !</p>
</div>
<?php }?>
<?php if(isset($_GET['success-edit'])){?>
<div class="alert alert-success">
    <p>Update Data Berhasil !</p>
</div>
<?php }?>
<?php if(isset($_GET['remove'])){?>
<div class="alert alert-danger">
    <p>Hapus Data Berhasil !</p>
</div>
<?php }?>


<div class="card card-body">
<form method="POST" action="fungsi/tambah/tambah.php?service=tambah">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="tgl">Tanggal</label>
            <input type="text" readonly="readonly" class="form-control" value="<?php echo date("j F Y, G:i"); ?>" name="tgl" id="tgl">
        </div>
        <div class="form-group col-lg-6">
            <?php
            $format = $lihat->service_id();
            ?>
            <label for="code">Service Code</label>
            <input type="text" readonly="readonly" required value="<?php echo $format; ?>" class="form-control" name="id_service">
        </div>
    </div>
<br>
<b><label for="data">Data Pelanggan</label></b>
          <input type="text" class="form-control" required name="pelanggan" id="pelanggan" placeholder="Masukan Nama Pelanggan">
<br>
          <input type="text" class="form-control" required name="hp" id="hp" placeholder="Masukan No Hp Pelanggan">
<br>
          <textarea class="form-control" required name="alamat" id="alamat" placeholder="Masukan Alamat Pelanggan"></textarea>
<br>
<b><label for="service">Data Service</label></b>
                                <select name="kategori" class="form-control" required>
                                    <option value="#">Pilih Kategori Perangkat</option>
                                    <?php $kat = $lihat->kategori(); foreach($kat as $isi){ ?>
                                    <option value="<?php echo $isi['nama_kategori'];?>">
                                        <?php echo $isi['nama_kategori'];?></option>
                                    <?php }?>
                                </select>
<br>
          <input type="text" class="form-control" required name="kerusakan" id="kerusakan" placeholder="Masukan Nama Kerusakan">
<br>
          <input type="text" class="form-control" required name="perangkat" id="perangkat" placeholder="Masukan Nama Perangkat & Typenya">
<br>
          <input type="text" class="form-control" required name="kelengkapan" id="kelengkapan" placeholder="Masukan Kelengkapan Barang">
<br>
          <textarea class="form-control" required name="keterangan" id="keterangan" placeholder="Masukan Keterangan Perbaikan"></textarea>
<br>
      
          <input type="text" class="form-control col-lg-6" required name="biaya" id="biaya" placeholder="Masukan Biaya Perbaikan">
<br>
<table>
<tr>
<td><label for="bayar">Uang Tunai</label>
          <input type="text" class="form-control col-lg-12" name="bayar" placeholder="Masukan Jumlah Yang Dibayar"></td>

<td><label for="status">Status Pembayaran</label>
        <select class="form-control col-lg-12" required name="status_p" id="status_p">
            <option value="Lunas">Lunas</option>
            <option value="Belum Lunas">Belum Lunas</option>
          </select></td>

<td>&emsp;&emsp;&emsp;
          <button type="submit" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Bayar</button></td>
          </tr>
</table> <br>

<br>
          <input type="hidden" class="form-control" required name="status_s" id="status_s" value="Diservice">

&emsp;&emsp;&emsp;    <a href="print_service.php?nm_member=<?php echo $_SESSION['admin']['nm_member'];?>
									&bayar=<?php echo $bayar;?>" target="_blank">
                                    <button class="btn btn-secondary">
                                        <i class="fa fa-print"></i> &nbsp; Print Struk Transaksi
                                    </button></a>
  </form>
</div>
