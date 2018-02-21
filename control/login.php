<?php
class login extends database{
    public function __construct($home) {
        $this->select = "SELECT * FROM login WHERE 1";
        $this->insert = "INSERT INTO login (username,password,status)VALUES(?,MD5(?),?)";
        $this->update = "UPDATE login SET password=MD5(?),status=? WHERE id=?";
        $this->delete = "DELETE FROM login WHERE id=?";
        $this->paramSelect = array('username','status');
        $this->paramInsert = array('username','password','status');
        $this->paramUpdate = array('password','status','edit');
        $this->paramDelete = array('hapus');
        $this->paramDetail = array('username','status');
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
            if(!empty(filter_input(1,'input'))){ $form->formInput("username","text","Username",60,4,true,$d['username']);}
            $form->formInput("password","password","Password",60,4,true,$d['password']);
            if(filter_input(2,'status')=='admin'){
            $form->formRadio("status","Status",array('admin','pegawai','penduduk'),true,$d['status']);
            }else{ $form->formHidden('status',$d['status']); }
            if(!empty(filter_input(1,'edit'))){ $form->formHidden("edit",filter_input(1,'edit')); }
            $form->formSubmit("submit","Kirim");
            ?>
        </form>
        <?php
    }
}
