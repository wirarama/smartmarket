<?php
class dokumen extends database{
    public $dir = 'uploads/dokumen/';
    public function __construct($home) {
        $this->select = "SELECT a.nama AS dokumen,b.nama AS pemilik,"
                . "c.nama AS jenis,a.id AS id,a.files AS files "
                . "FROM dokumen AS a,penduduk AS b,jenis AS c "
                . "WHERE a.pemilik=b.id AND a.jenis=c.id";
        $this->insert = "INSERT INTO dokumen (nama,jenis,pemilik,diskripsi)VALUES(?,?,?,?)";
        $this->update = "UPDATE dokumen SET nama=?,jenis=?,pemilik=?,diskripsi=? WHERE id=?";
        $this->delete = "DELETE FROM dokumen WHERE id=?";
        $this->paramSelect = array('dokumen','pemilik','jenis');
        $this->paramInsert = array('nama','jenis','pemilik','diskripsi');
        $this->paramUpdate = array('nama','jenis','pemilik','diskripsi','edit');
        $this->paramDetail = array('dokumen','pemilik','jenis','files');
        $this->paramDelete = array('hapus');
        $this->home = $home;
        parent::__construct();
    }
    public function qinsert() {
        if(!empty($_FILES["file"])){
            $this->queryStat("INSERT INTO dokumen (nama,jenis,pemilik,diskripsi,files)VALUES(?,?,?,?,?)",
                    array(filter_input(0,'nama'),filter_input(0,'jenis'),
                        filter_input(0,'pemilik'),filter_input(0,'diskripsi'),
                        $this->multifileupload($this->dir,filter_input(0,'nama'))));
        }else{ parent::qinsert(); }
    }
    public function qupdate(){
        if(!empty($_FILES["file"])){
            $this->deleteFiles(filter_input(0,'edit'),$this->dir);
            $this->queryStat("UPDATE dokumen SET nama=?,jenis=?,pemilik=?,diskripsi=?,files=? WHERE id=?",
                    array(filter_input(0,'nama'),filter_input(0,'jenis'),
                        filter_input(0,'pemilik'),filter_input(0,'diskripsi'),
                        $this->multifileupload($this->dir,filter_input(0,'nama')),
                        filter_input(0,'edit')));
        }else{ parent::qupdate(); }
    }
    public function qdelete() {
        $this->deleteFiles(filter_input(1,'hapus'),$this->dir);
        parent::qdelete();
    }
    public function queryForm(){
        if(!empty(filter_input(1,'edit'))){ 
            $this->select = "SELECT * FROM dokumen WHERE 1";
            $this->querySelect(); $d = $this->data[0];
        }
        ?>
        <form action="" method="POST" id="menuForm" class="form-horizontal" enctype="multipart/form-data">
            <?php
            foreach($this->paramInsert AS $p){ if(empty($d[$p])){ $d[$p]="";}}
            $form = new form();
            $form->formInput("nama","text","Nama",60,4,true,$d['nama']);
            $this->formselectdb("jenis","Jenis","SELECT id,nama FROM jenis","id","nama",true,$d['jenis']);
            $this->formselectdb("pemilik","Pemilik","SELECT id,nama FROM penduduk","id","nama",true,$d['pemilik']);
            $form->formArea("diskripsi","Diskripsi",60,5,true,$d['diskripsi']);
            $form->formFile('file','File',true);
            if(!empty(filter_input(1,'edit'))){ $form->formHidden("edit",filter_input(1,'edit')); }
            $form->formSubmit("submit","Kirim");
            ?>
        </form>
        <?php
    }
    public function querySelectExcept() {
        if(!empty(filter_input(1,'edit'))){ $this->select .= " AND id='".filter_input(1,'edit')."'"; }
        else if(!empty(filter_input(0,'edit'))){ $this->select .= " AND id='".filter_input(0,'edit')."'"; }
        else if(!empty(filter_input(1,'hapus'))){ $this->select .= " AND id='".filter_input(1,'hapus')."'"; }
        else if(!empty(filter_input(1,'detail'))){ $this->select .= " AND a.id='".filter_input(1,'detail')."'"; }
    }
}
