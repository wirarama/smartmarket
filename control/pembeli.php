<?php
class pembeli extends database{
    public function __construct($home) {
        $this->select = "SELECT * FROM pembeli WHERE 1";
        $this->insert = "INSERT INTO pembeli (nama,alamat,notelp,jenisKelamin,"
                . "tanggalLahir,pekerjaan,rfid)VALUES(?,?,?,?,?,?,?)";
        $this->update = "UPDATE pembeli SET nama=?,alamat=?,notelp=?,jenisKelamin=?,"
                . "tanggalLahir=?,pekerjaan=?,rfid=? WHERE id=?";
        $this->delete = "DELETE FROM pembeli WHERE id=?";
        $this->paramSelect = array('nama','alamat','notelp','jenisKelamin','tanggalLahir','pekerjaan','rfid');
        $this->paramInsert = array('nama','alamat','notelp','jenisKelamin','tanggalLahir','pekerjaan','rfid');
        $this->paramUpdate = array('nama','alamat','notelp','jenisKelamin','tanggalLahir','pekerjaan','rfid','edit');
        $this->paramDelete = array('hapus');
        $this->paramDetail = array('nama','alamat','notelp','jenisKelamin','tanggalLahir','pekerjaan','rfid','foto');
        $this->home = $home;
        parent::__construct();
    }
    public function qinsert() {
        if(!empty($_FILES["file"]["tmp_name"])){
            $this->uploadsPhoto();
            $this->insert = "INSERT INTO pembeli (nama,alamat,notelp,jenisKelamin,"
                . "tanggalLahir,pekerjaan,rfid,foto)VALUES(?,?,?,?,?,?,?,?)";
            $this->query("UPDATE rfidlist SET status='unavailable' "
                    . "WHERE rfid='".filter_input(0,'rfid')."'");
        }
        parent::qinsert();
        $this->foto = NULL;
    }
    public function qupdate(){
        if(!empty($_FILES["file"]["tmp_name"])){
            $this->deletePhoto();
            $this->uploadsPhoto();
            $this->queryStat("UPDATE pembeli SET foto=? WHERE id=?",
                    array($this->foto,filter_input(0,'edit')));
        }
        parent::qupdate();
        $this->foto = NULL;
    }
    public function qdelete() {
        $this->deletePhoto();
        parent::qdelete();
    }
    public function queryForm(){
        if(!empty(filter_input(1,'edit'))){ $this->querySelect(); $d = $this->data[0]; }
        ?>
        <form action="" method="POST" id="menuForm" class="form-horizontal" enctype="multipart/form-data">
            <?php
            foreach($this->paramInsert AS $p){ if(empty($d[$p])){ $d[$p]="";}}
            $form = new form();
            $form->formInput("nama","text","Nama",60,4,true,$d['nama']);
            $form->formInput("alamat","text","Alamat",60,4,true,$d['alamat']);
            $form->formInput("notelp","text","Telp",20,4,true,$d['notelp']);
            $jenisKelamin = array('laki-laki','perempuan');
            $form->formRadio("jenisKelamin","Jenis Kelamin",$jenisKelamin,true,$d['jenisKelamin']);
            $form->formInput("tanggalLahir","date","Tanggal Lahir",60,4,true,$d['tanggalLahir']);
            $form->formInput("pekerjaan","text","Pekerjaan",60,4,false,$d['pekerjaan']);
            $this->formselectdb("rfid","RFID","SELECT rfid FROM rfidlist WHERE status='available'","rfid","rfid",true,$d['rfid']);
            $form->formFile("file","Foto");
            if(!empty($d['foto'])){ $form->formPic($form->dir.str_replace(".","_Thumb.",$d['foto'])); 
            }else{ $form->formPic($form->dir.'thumbs.jpg'); }
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
            <?php
            echo $this->rupiah($this->totalTable("SELECT SUM(total) AS totalTrans "
                    . "FROM penjualan WHERE pembeli='".filter_input(1,'detail')."'","totalTrans"));
            ?>
            </li>
        </ul>
        </div>
        <?php
        $this->relatedListTable('Transaksi',"SELECT total,tanggal,id FROM penjualan "
                . "WHERE pembeli='".filter_input(1,'detail')."'",array('tanggal','total'),'index.php?p=penjualan&detail=');
    }
}
