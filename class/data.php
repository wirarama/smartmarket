<?php

class data extends database{
    public function inputPembeli() {
        $trunc = $this->conn->prepare("TRUNCATE TABLE pembeli");
        $trunc->execute();
        $trunc1 = $this->conn->prepare("UPDATE rfidlist SET status='available'");
        $trunc1->execute();
        $qrfid = $this->conn->prepare("SELECT rfid,id FROM rfidlist ORDER BY id ASC");
        $qrfid->execute();
        $status = array('laki-laki','perempuan');
        $pekerjaan = array('Pegawai Swasta','Pegawai Negri','Siswa','Mahasiswa','Wirausaha','Lain-lain');
        require 'randomname.php';
        while($d = $qrfid->fetch()){
            $q = "INSERT INTO pembeli VALUES"
                . "(null,'".$people[rand(0,999)]."','alamat".$d['id']."',"
                . "'081".rand(10000,99999)."',"
                . "'".$status[rand(0,1)]."','".rand(1980,2000)."-".rand(1,12)."-".rand(1,30)."',"
                . "'".$pekerjaan[rand(0,4)]."',null,"
                . "'".$d['rfid']."')";
            $ins = $this->conn->prepare($q);
            $ins->execute();
        }
    }
    public function inputProduk(){
        $trunc = $this->conn->prepare("TRUNCATE TABLE supplier");
        $trunc->execute();
        $trunc1 = $this->conn->prepare("TRUNCATE TABLE produk");
        $trunc1->execute();
        $jenis = array('PT Indofood','PT Kimia Farma','PT Wings',
            'PT Unilever','PT Garudafood');
        $qjenis = "INSERT INTO supplier VALUES";
        $qjenisarr = array();
        foreach($jenis AS $jenis1){
            array_push($qjenisarr,"(null,'".$jenis1."','alamat ".$jenis1."','081".rand(10000,99999)."')");
        }
        $qjenis .= implode(',',$qjenisarr);
        $insjenis = $this->conn->prepare($qjenis);
        $insjenis->execute();
        $qpenduduk = $this->conn->prepare("SELECT nama,id FROM supplier ORDER BY id ASC");
        $qpenduduk->execute();
        while($d = $qpenduduk->fetch()){
            $n = rand(10,50);
            for($i=0;$i<$n;$i++){
                $hargaBeli = rand(5,1000)*1000;
                $hargaJual = $hargaBeli+(rand(5,100)*1000);
                $q = "INSERT INTO produk VALUES"
                    . "(null,'".rand(10000,99999)."','Produk ".$d['nama'].$i."','".$hargaBeli."','".$hargaJual."')";
                $ins = $this->conn->prepare($q);
                $ins->execute();
            }
        }
    }
    public function inputTransaksi(){
        $trunc = $this->conn->prepare("TRUNCATE TABLE pembelian");
        $trunc->execute();
        $trunc1 = $this->conn->prepare("TRUNCATE TABLE penjualan");
        $trunc1->execute();
        $trunc2 = $this->conn->prepare("TRUNCATE TABLE transPenjualan");
        $trunc2->execute();
        $trunc3 = $this->conn->prepare("TRUNCATE TABLE transPembelian");
        $trunc3->execute();
        $npr = $this->conn->prepare("SELECT MAX(id) AS total FROM produk");
        $npr->execute();
        $dpr = $npr->fetch();
        $qpenduduk = $this->conn->prepare("SELECT nama,id FROM supplier ORDER BY id ASC");
        $qpenduduk->execute();
        while($d = $qpenduduk->fetch()){
            $n = rand(10,50);
            for($i=0;$i<$n;$i++){
                $ins = $this->conn->prepare("INSERT INTO pembelian VALUES(null,'".$d['id']."',null,null)");
                $ins->execute();
                $nid = $this->conn->prepare("SELECT MAX(id) AS newid FROM pembelian");
                $nid->execute();
                $did = $nid->fetch();
                $m = rand(2,20);
                $tot = 0;
                for($j=0;$j<$m;$j++){
                    $pr = rand(1,$dpr['total']);
                    $jm = rand(1,50);
                    $insTr = $this->conn->prepare("INSERT INTO transPembelian VALUES(null,'".$did['newid']."','".$pr."','".$jm."')");
                    $insTr->execute();
                    $hpr = $this->conn->prepare("SELECT hargaBeli FROM produk WHERE id='".$pr."'");
                    $hpr->execute();
                    $dhpr = $hpr->fetch();
                    $tot += $dhpr['hargaBeli']*$jm;
                }
                $upTr = $this->conn->prepare("UPDATE pembelian SET total='".$tot."' WHERE id='".$did['newid']."'");
                $upTr->execute();
            }
        }
        $qpembeli = $this->conn->prepare("SELECT nama,id FROM pembeli ORDER BY id ASC");
        $qpembeli->execute();
        while($d = $qpembeli->fetch()){
            $n = rand(10,50);
            for($i=0;$i<$n;$i++){
                $ins1 = $this->conn->prepare("INSERT INTO penjualan VALUES(null,'".$d['id']."',null,null,null)");
                $ins1->execute();
                $nid1 = $this->conn->prepare("SELECT MAX(id) AS newid FROM penjualan");
                $nid1->execute();
                $did1 = $nid1->fetch();
                $m = rand(2,20);
                $tot = 0;
                for($j=0;$j<$m;$j++){
                    $pr = rand(1,$dpr['total']);
                    $jm = rand(1,20);
                    $insTr = $this->conn->prepare("INSERT INTO transPenjualan VALUES(null,'".$did1['newid']."','".$pr."','".$jm."')");
                    $insTr->execute();
                    $hpr = $this->conn->prepare("SELECT hargaJual FROM produk WHERE id='".$pr."'");
                    $hpr->execute();
                    $dhpr = $hpr->fetch();
                    $tot += $dhpr['hargaJual']*$jm;
                }
                $upTr = $this->conn->prepare("UPDATE penjualan SET total='".$tot."' WHERE id='".$did1['newid']."'");
                $upTr->execute();
            }
        }
    }
}
