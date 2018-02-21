<?php
class penjualan extends database{
    public function __construct($home) {
        $this->select = "SELECT a.tanggal AS tanggal,b.nama AS pembeli,a.id AS id,a.total "
                . "FROM penjualan AS a,pembeli AS b "
                . "WHERE a.pembeli=b.id";
        $this->insert = "INSERT INTO penjualan (pembeli)VALUES(?)";
        $this->update = "UPDATE penjualan SET pembeli=? WHERE id=?";
        $this->delete = "DELETE FROM penjualan WHERE id=?";
        $this->paramSelect = array('tanggal','pembeli','total');
        $this->paramInsert = array('pembeli');
        $this->paramUpdate = array('pembeli','edit');
        $this->paramDelete = array('hapus');
        $this->paramDetail = array('tanggal','pembeli');
        $this->home = $home;
        parent::__construct();
    }
    public function queryForm(){
        if(!empty(filter_input(1,'edit'))){ 
            $this->select = "SELECT * FROM penjualan WHERE 1";
            $this->querySelect(); $d = $this->data[0];
        }
        ?>
        <form action="" method="POST" id="menuForm" class="form-horizontal">
            <?php
            foreach($this->paramInsert AS $p){ if(empty($d[$p])){ $d[$p]="";}}
            $form = new form();
            $this->formselectdb("pembeli","Pembeli","SELECT id,nama FROM pembeli","id","nama",true,$d['pembeli']);
            if(!empty(filter_input(1,'edit'))){ $form->formHidden("edit",filter_input(1,'edit')); }
            $form->formAdd("addProduct","Tambah Produk");
            $form->formSubmit("submit","Kirim");
            ?>
         </form>
        <div id="addForm" style="display:none;">
            <?php
            $d['produk']="";
            $this->formselectdbMulti("produk","Produk","SELECT id,nama,hargaJual FROM produk","id","nama",$d['produk'],"hargaJual");
            ?>
        </div>
        <?php
    }
    public function qinsert() {
        parent::qinsert();
        $query = $this->conn->prepare("SELECT MAX(id) AS newId FROM penjualan");
        $query->execute();
        $d = $query->fetch();
        $prod = filter_input(0,'produk', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $num = filter_input(0,'num', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $values = array();
        $total = 0;
        for ($i=0;$i<sizeof($prod);$i++) {
            $prod1 = explode(',',$prod[$i]);
            array_push($values,"('".$d['newId']."','".$prod1[0]."','".$num[$i]."')");
            $total += $prod1[2]*$num[$i];
        }
        $query1 = $this->conn->prepare("INSERT INTO transPenjualan (penjualan,produk,jumlah) "
                . "VALUES".implode(',',$values));
        $query1->execute();
        $query2 = $this->conn->prepare("UPDATE penjualan SET total='".$total."' WHERE id='".$d['newId']."'");
        $query2->execute();
    }
    public function queryDetail() {
        parent::queryDetail();
        $this->relatedListTable('Transaksi',"SELECT b.nama AS nama,b.hargaJual AS harga,a.jumlah AS jumlah,"
                . "(b.hargaJual*a.jumlah) AS total,b.id AS id "
                . "FROM transPenjualan AS a,produk AS b WHERE "
                . "a.penjualan='".filter_input(1,'detail')."' "
                . "AND a.produk=b.id",array('nama','harga','jumlah','total'),'index.php?p=produk&detail=');
    }
    public function querySelectExcept() {
        if(!empty(filter_input(1,'edit'))){ $this->select .= " AND id='".filter_input(1,'edit')."'"; }
        else if(!empty(filter_input(0,'edit'))){ $this->select .= " AND id='".filter_input(0,'edit')."'"; }
        else if(!empty(filter_input(1,'hapus'))){ $this->select .= " AND id='".filter_input(1,'hapus')."'"; }
        else if(!empty(filter_input(1,'detail'))){ $this->select .= " AND a.id='".filter_input(1,'detail')."'"; }
    }
}
