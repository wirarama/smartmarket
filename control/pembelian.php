<?php
class pembelian extends database{
    public function __construct($home) {
        $this->select = "SELECT a.tanggal AS tanggal,b.nama AS supplier,a.id AS id,a.total "
                . "FROM pembelian AS a,supplier AS b "
                . "WHERE a.supplier=b.id";
        $this->insert = "INSERT INTO pembelian (supplier)VALUES(?)";
        $this->update = "UPDATE pembelian SET supplier=? WHERE id=?";
        $this->delete = "DELETE FROM pembelian WHERE id=?";
        $this->paramSelect = array('tanggal','supplier','total');
        $this->paramInsert = array('supplier');
        $this->paramUpdate = array('supplier','edit');
        $this->paramDelete = array('hapus');
        $this->paramDetail = array('tanggal','supplier');
        $this->home = $home;
        parent::__construct();
    }
    public function queryForm(){
        if(!empty(filter_input(1,'edit'))){ 
            $this->select = "SELECT * FROM pembelian WHERE 1";
            $this->querySelect(); $d = $this->data[0];
        }
        ?>
        <form action="" method="POST" id="menuForm" class="form-horizontal">
            <?php
            foreach($this->paramInsert AS $p){ if(empty($d[$p])){ $d[$p]="";}}
            $form = new form();
            $this->formselectdb("supplier","Supplier","SELECT id,nama FROM supplier","id","nama",true,$d['supplier']);
            if(!empty(filter_input(1,'edit'))){ $form->formHidden("edit",filter_input(1,'edit')); }
            $form->formAdd("addProduct","Tambah Produk");
            $form->formSubmit("submit","Kirim");
            ?>
         </form>
        <div id="addForm" style="display:none;">
            <?php
            $d['produk']="";
            $this->formselectdbMulti("produk","Produk","SELECT id,nama,hargaBeli FROM produk","id","nama",$d['produk'],"hargaBeli");
            ?>
        </div>
        <?php
    }
    public function qinsert() {
        parent::qinsert();
        $query = $this->conn->prepare("SELECT MAX(id) AS newId FROM pembelian");
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
        $query1 = $this->conn->prepare("INSERT INTO transPembelian (pembelian,produk,jumlah) "
                . "VALUES".implode(',',$values));
        $query1->execute();
        $query2 = $this->conn->prepare("UPDATE pembelian SET total='".$total."' WHERE id='".$d['newId']."'");
        $query2->execute();
    }
    public function queryDetail() {
        parent::queryDetail();
        $this->relatedListTable('Transaksi',"SELECT b.nama AS nama,b.hargaBeli AS harga,a.jumlah AS jumlah,"
                . "(b.hargaBeli*a.jumlah) AS total,b.id AS id "
                . "FROM transPembelian AS a,produk AS b WHERE "
                . "a.pembelian='".filter_input(1,'detail')."' "
                . "AND a.produk=b.id",array('nama','harga','jumlah','total'),'index.php?p=produk&detail=');
    }
    public function querySelectExcept() {
        if(!empty(filter_input(1,'edit'))){ $this->select .= " AND id='".filter_input(1,'edit')."'"; }
        else if(!empty(filter_input(0,'edit'))){ $this->select .= " AND id='".filter_input(0,'edit')."'"; }
        else if(!empty(filter_input(1,'hapus'))){ $this->select .= " AND id='".filter_input(1,'hapus')."'"; }
        else if(!empty(filter_input(1,'detail'))){ $this->select .= " AND a.id='".filter_input(1,'detail')."'"; }
    }
}
