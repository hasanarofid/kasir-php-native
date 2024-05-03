<?php
/*
* PROSES TAMPIL
*/
class view
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function member()
    {
        $sql = "select member.*, login.*
                from member inner join login on member.id_member = login.id_member";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function member_edit($id)
    {
        $sql = "select member.*, login.*
                from member inner join login on member.id_member = login.id_member
                where member.id_member= ?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function toko()
    {
        $sql = "select*from toko where id_toko='1'";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }
    
    public function nota()
    {
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang, member.id_member, pelanggan, alamat, hp,
                member.nm_member from nota
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member
                ORDER BY id_nota";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
         $hasil = $row->fetch(); 
        return $hasil;
    }
    
    public function kategori()
    {
        $sql = "select*from kategori";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }
    
    //     public function barang()
    // {
    //     $sql = "select*from barang";
    //     $row = $this-> db -> prepare($sql);
    //     $row -> execute();
    //     $hasil = $row -> fetchAll(); 
    //     return $hasil;
    // }
    
    public function ser($id_service)
    {
        $sql = "SELECT * FROM service WHERE id_service = :id_service";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_service', $id_service, PDO::PARAM_INT);
        $stmt->execute();
        $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $hasil;
    }


    public function barang()
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori 
                ORDER BY id DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang_stok()
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori 
                where stok <= 3 
                ORDER BY id DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang_masuk()
    {
        $sql = "select masuk.*, barang.id_barang, barang.nama_barang
                from masuk inner join barang on barang.id = masuk.id_barang
                ORDER BY id DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang_edit($id)
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori
                where id_barang=?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }
    
        public function service_edit($id)
    {
        $sql = "select service.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on service.id_kategori = kategori.id_kategori
                where id_service=?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }


    public function barang_cari($cari)
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori
                where id_barang like '%$cari%' or nama_barang like '%$cari%' or merk like '%$cari%'";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang_id()
    {
        $sql = 'SELECT * FROM barang ORDER BY id DESC';
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();

        $urut = substr($hasil['id_barang'], 2, 3);
        $tambah = (int) $urut + 1;
        if (strlen($tambah) == 1) {
            $format = 'BR00'.$tambah.'';
        } elseif (strlen($tambah) == 2) {
            $format = 'BR0'.$tambah.'';
        } else {
            $ex = explode('BR', $hasil['id_barang']);
            $no = (int) $ex[1] + 1;
            $format = 'BR'.$no.'';
        }
        return $format;
    }
    
        public function service_id()
    {
        $sql = 'SELECT * FROM service ORDER BY id DESC';
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();

        $urut = substr($hasil['id_service'], 2, 3);
        $tambah = (int) $urut + 1;
        if (strlen($tambah) == 1) {
            $format = 'SV00'.$tambah.'';
        } elseif (strlen($tambah) == 2) {
            $format = 'SV0'.$tambah.'';
        } else {
            $ex = explode('SV', $hasil['id_service']);
            $no = (int) $ex[1] + 1;
            $format = 'SV'.$no.'';
        }
        return $format;
    }

    public function kategori_edit($id)
    {
        $sql = "select*from kategori where id_kategori=?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function kategori_row()
    {
        $sql = "select*from kategori";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> rowCount();
        return $hasil;
    }

    public function barang_row()
    {
        $sql = "select*from barang";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> rowCount();
        return $hasil;
    }

    public function barang_stok_row()
    {
        $sql ="SELECT SUM(stok) as jml FROM barang";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function barang_beli_row()
    {
        $sql ="SELECT SUM(harga_beli) as beli FROM barang";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jual_row()
    {
        $sql ="SELECT SUM(jumlah) as stok FROM nota";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jual()
    {
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member 
                where nota.periode = ?
                ORDER BY id_nota DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array(date('m-Y')));
        $hasil = $row -> fetchAll();
        return $hasil;
    }
    
     public function service()
    {
        $sql = "select*from service";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }
    
    

    public function periode_jual($periode)
    {
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member WHERE nota.periode = ? 
                ORDER BY id_nota ASC";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($periode));
        $hasil = $row -> fetchAll();
        return $hasil;
    }
    
   public function periode_service($periode)
{
    $sql = "SELECT service.*, kategori, alamat, hp, perangkat, kelengkapan, kerusakan, keterangan, pelanggan, status_p, status_s, tgl, biaya, bayar 
            FROM service 
            WHERE service.periode = ? 
            ORDER BY id_service ASC";
    $row = $this->db->prepare($sql);
    $row->execute(array($periode));
    $hasil = $row->fetchAll();
    return $hasil;
}

public function hari_service($hari)
{
    $ex = explode('-', $hari);
    $monthNum = $ex[1];
    $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
    $tgl = ($ex[2] > 9) ? $ex[2] : (int)$ex[2]; // Menghindari tanda nol di depan angka tanggal
    $cek = "$tgl $monthName $ex[0]";
    $param = "%{$cek}%";
    $sql = "SELECT service.*, kategori, alamat, hp, perangkat, kelengkapan, kerusakan, keterangan, pelanggan, status_p, status_s, tgl, biaya, bayar 
            FROM service
            WHERE service.tgl LIKE ? 
            ORDER BY id_service ASC"; // Saya mengganti id_nota dengan id_service sesuai urutan SELECT
    $row = $this->db->prepare($sql);
    $row->execute(array($param));
    $hasil = $row->fetchAll();
    return $hasil;
}

    public function penjualan()
    {
        $sql ="SELECT penjualan.* , barang.id_barang, barang.nama_barang, member.id_member,
                member.nm_member from penjualan 
                left join barang on barang.id_barang=penjualan.id_barang 
                left join member on member.id_member=penjualan.id_member
                ORDER BY id_penjualan";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function jumlah()
    {
        $sql ="SELECT SUM(total) as bayar FROM penjualan";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jumlah_nota()
    {
        $sql ="SELECT SUM(total) as bayar FROM nota";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jml()
    {
        $sql ="SELECT SUM(harga_beli*stok) as byr FROM barang";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }
    
    
}
