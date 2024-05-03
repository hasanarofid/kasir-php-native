<h4>Data Barang Masuk</h4>
<br />
<?php if(isset($_GET['success-stok'])){?>
<div class="alert alert-success">
    <p>Tambah Stok Berhasil !</p>
</div>
<?php }?>
<?php if(isset($_GET['success'])){?>
<div class="alert alert-success">
    <p>Tambah Data Berhasil !</p>
</div>
<?php }?>
<?php if(isset($_GET['remove'])){?>
<div class="alert alert-danger">
    <p>Hapus Data Berhasil !</p>
</div>
<?php }?>


<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> Insert Data</button>
<!-- <a href="index.php?page=masuk&stok=yes" class="btn btn-warning btn-md mr-2">
    <i class="fa fa-list"></i> Sortir Stok Kurang</a> -->
<a href="index.php?page=masuk" class="btn btn-success btn-md">
    <i class="fa fa-refresh"></i> Refresh Data</a>
<div class="clearfix"></div>
<br />
<!-- view barang -->
<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
            <thead>
                <tr style="background:#DFF0D8;color:#333;">
                    <th>No.</th>
                    <th>Barang</th>
                    <th>Supplier</th>
                    <th>Penerima</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $hasil = $lihat->barang_keluar();
                    // var_dump($hasil);die;
                    $no=1;
                    foreach($hasil as $isi) {
                ?>
                <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $isi['nama_barang'];?></td>
                    <td><?php echo $isi['supplier'];?></td>
                    <td><?php echo $isi['penerima'];?></td>
                    <td><?php echo $isi['jumlah'];?></td>
                    <td><?php echo $isi['tgl'];?></td>
                    <td>
                        <a href="index.php?page=masuk/details&barang=<?php echo $isi['id'];?>"><button
                                class="btn btn-primary btn-xs">Details</button></a>

                        <a href="index.php?page=masuk/edit&barang=<?php echo $isi['id'];?>"><button
                                class="btn btn-warning btn-xs">Edit</button></a>
                        <a href="fungsi/hapus/hapus.php?masuk=hapus&id=<?php echo $isi['id'];?>"
                            onclick="javascript:return confirm('Hapus Barang Ini?');"><button
                                class="btn btn-danger btn-xs">Hapus</button></a>
                    </td>
                </tr>
                <?php 
                        $no++; 
                    }
                ?>
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
            <form action="fungsi/tambah/tambah.php?masuk=tambah" method="POST">
                <div class="modal-body">
                    <table class="table table-striped bordered">
                       
                     
                        <tr>
                            <td>Barang</td>
                            <td>
                                <select name="id_barang" class="form-control" required>
                                    <option value="#">Pilih Barang</option>
                                    <?php $kat = $lihat->barang(); foreach($kat as $isi){ 
                                        
                                        ?>
                                    <option value="<?php echo $isi['id'];?>">
                                        <?php echo $isi['nama_barang'];?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>supplier</td>
                            <td><input type="text" placeholder="Nama supplier" required class="form-control"
                                    name="supplier"></td>
                        </tr>
                        <tr>
                            <td>penerima</td>
                            <td><input type="text" placeholder="penerima" required class="form-control"
                                    name="penerima"></td>
                        </tr>
                        <tr>
                            <td>jumlah</td>
                            <td><input type="number" placeholder="jumlah" required class="form-control"
                                    name="jumlah"></td>
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
