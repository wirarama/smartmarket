<?php
class supplier extends database{
    public function __construct($home) {
        $this->select = "SELECT * FROM supplier WHERE 1";
        $this->insert = "INSERT INTO supplier (nama,alamat,notelp)VALUES(?,?,?)";
        $this->update = "UPDATE supplier SET nama=?,alamat=?,notelp=? WHERE id=?";
        $this->delete = "DELETE FROM supplier WHERE id=?";
        $this->paramSelect = array('nama','alamat','notelp');
        $this->paramInsert = array('nama','alamat','notelp');
        $this->paramUpdate = array('nama','alamat','notelp','edit');
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
            $form->formInput("nama","text","Nama",60,4,true,$d['nama']);
            $form->formInput("alamat","text","Alamat",60,4,true,$d['alamat']);
            $form->formInput("notelp","text","No Telp",60,4,true,$d['notelp']);
            if(!empty(filter_input(1,'edit'))){ $form->formHidden("edit",filter_input(1,'edit')); }
            $form->formSubmit("submit","Kirim");
            ?>
        </form>
        <?php
    }
    public function queryDetail() {
        parent::queryDetail();
        ?>
        <div class="col-lg-6">
        <ul class="list-group">
            <li class="list-group-item active"><strong>Total Transaksi</strong></li>
            <li class="list-group-item">
            <?php echo $this->rupiah($this->totalTable("SELECT SUM(total) AS totalTrans "
                    . "FROM pembelian WHERE supplier='".filter_input(1,'detail')."'","totalTrans")); ?>
            </li>
        </ul>
        </div>
        <?php
        $this->relatedListTable('Transaksi',"SELECT total,tanggal,id FROM pembelian "
                . "WHERE supplier='".filter_input(1,'detail')."'",array('tanggal','total'),'index.php?p=pembelian&detail=');
    }
}
