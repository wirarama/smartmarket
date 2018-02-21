<?php
class produk extends database{
    public function __construct($home) {
        $this->select = "SELECT * FROM produk WHERE 1";
        $this->insert = "INSERT INTO produk (code,nama,hargaBeli,hargaJual)VALUES(?,?,?,?)";
        $this->update = "UPDATE produk SET code=?,nama=?,hargaBeli=?,hargaJual=? WHERE id=?";
        $this->delete = "DELETE FROM produk WHERE id=?";
        $this->paramSelect = array('code','nama','hargaBeli','hargaJual');
        $this->paramInsert = array('code','nama','hargaBeli','hargaJual');
        $this->paramUpdate = array('code','nama','hargaBeli','hargaJual','edit');
        $this->paramDelete = array('hapus');
        $this->home = $home;
        parent::__construct();
    }
    public function queryForm(){
        if(!empty(filter_input(1,'edit'))){ $this->querySelect(); $d = $this->data[0]; }
        ?>
        <form action="" method="POST" id="menuForm" class="form-horizontal">
            <?php
            foreach($this->paramInsert AS $p){ if(empty($d[$p])){ $d[$p]="";}}
            $form = new form();
            $form->formInput("code","text","Code",60,4,true,$d['code']);
            $form->formInput("nama","text","Nama",60,4,true,$d['nama']);
            $form->formInput("hargaBeli","text","Harga Beli",60,4,true,$d['hargaBeli']);
            $form->formInput("hargaJual","text","Harga Jual",60,4,true,$d['hargaJual']);
            if(!empty(filter_input(1,'edit'))){ $form->formHidden("edit",filter_input(1,'edit')); }
            $form->formSubmit("submit","Kirim");
            ?>
        </form>
        <?php
    }
    public function queryDetail() {
        parent::queryDetail();
        $this->relatedListTable('Transaksi Penjualan',"SELECT a.jumlah AS jumlah,"
                . "c.tanggal AS tanggal,b.hargaJual AS harga,c.id AS id,(a.jumlah*b.hargaJual) AS total "
                . "FROM transPenjualan AS a,produk AS b,penjualan AS c "
                . "WHERE a.produk=b.id AND a.penjualan=c.id AND "
                . "b.id='".filter_input(1,'detail')."'",array('tanggal','harga','jumlah','total'),'index.php?p=penjualan&detail=');    
        $this->relatedListTable('Transaksi Pembelian',"SELECT a.jumlah AS jumlah,"
                . "c.tanggal AS tanggal,b.hargaBeli AS harga,c.id AS id,(a.jumlah*b.hargaBeli) AS total "
                . "FROM transPembelian AS a,produk AS b,pembelian AS c "
                . "WHERE a.produk=b.id AND a.pembelian=c.id AND "
                . "b.id='".filter_input(1,'detail')."'",array('tanggal','harga','jumlah','total'),'index.php?p=pembelian&detail=');
    }   
}
