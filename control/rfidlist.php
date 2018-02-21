<?php
class rfidlist extends database{
    public function __construct($home) {
        $this->select = "SELECT * FROM rfidlist WHERE 1";
        $this->insert = "INSERT INTO rfidlist (rfid,status)VALUES(?,?)";
        $this->update = "UPDATE rfidlist SET rfid=?,status=? WHERE id=?";
        $this->delete = "DELETE FROM rfidlist WHERE id=?";
        $this->paramSelect = array('rfid','status');
        $this->paramInsert = array('rfid','status');
        $this->paramUpdate = array('rfid','status','edit');
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
            $form->formInput("rfid","text","RFID",60,4,true,$d['rfid']);
            $form->formRadio("status","Status",array('available','unavailable'),true,$d['status']);
            if(!empty(filter_input(1,'edit'))){ $form->formHidden("edit",filter_input(1,'edit')); }
            $form->formSubmit("submit","Kirim");
            ?>
        </form>
        <?php
    }
}
