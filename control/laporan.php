<?php
class laporan extends database{
    public $dir = 'uploads/laporan/'; 
    public function __construct($home) {
        $this->select = "SELECT * FROM laporan WHERE 1 ";
        $this->insert = "INSERT INTO laporan (nama,diskripsi)VALUES(?,?)";
        $this->update = "UPDATE laporan SET nama=?,diskripsi=? WHERE id=?";
        $this->delete = "DELETE FROM laporan WHERE id=?";
        $this->paramSelect = array('nama');
        $this->paramInsert = array('nama','diskripsi');
        $this->paramUpdate = array('nama','diskripsi','edit');
        $this->paramDelete = array('hapus');
        $this->paramDetail = array('nama','diskripsi','files');
        $this->home = $home;
        parent::__construct();
    }
    public function qinsert() {
        if(!empty($_FILES["file"])){
            $this->queryStat("INSERT INTO laporan (nama,diskripsi,files)VALUES(?,?,?)",
                    array(filter_input(0,'nama'),filter_input(0,'diskripsi'),
                        $this->multifileupload($this->dir,filter_input(0,'nama'))));
        }else{
            parent::qinsert();
        }
    }
    public function qupdate(){
        if(!empty($_FILES["file"])){
            $this->deleteFiles(filter_input(0,'edit'),$this->dir);
            $this->queryStat("UPDATE laporan SET nama=?,diskripsi=?,files=? WHERE id=?",
                    array(filter_input(0,'nama'),filter_input(0,'diskripsi'),
                        $this->multifileupload($this->dir,filter_input(0,'nama')),filter_input(0,'edit')));
        }else{
            parent::qupdate();
        }
    }
    public function qdelete() {
        $this->deleteFiles(filter_input(1,'hapus'),$this->dir);
        parent::qdelete();
    }
    public function queryForm(){
        if(!empty(filter_input(1,'edit'))){ 
            $this->select = "SELECT * FROM laporan WHERE 1";
            $this->querySelect(); $d = $this->data[0];
        }
        ?>
        <form action="" method="POST" id="menuForm" class="form-horizontal" enctype="multipart/form-data">
            <?php
            foreach($this->paramInsert AS $p){ if(empty($d[$p])){ $d[$p]="";}}
            $form = new form();
            $form->formInput("nama","text","Nama",60,4,true,$d['nama']);
            $form->formArea("diskripsi","Diskripsi",60,5,true,$d['diskripsi']);
            $form->formFile('file','File',true);
            if(!empty(filter_input(1,'edit'))){ $form->formHidden("edit",filter_input(1,'edit')); }
            $form->formSubmit("submit","Kirim");
            ?>
        </form>
        <?php
    }
}
