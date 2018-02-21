<?php
class viewrfidlist extends template{
    var $title = "RFID";
    public function objdef() {
        require 'control/rfidlist.php';
        $this->home = 'index.php?p=rfidlist';
        $this->obj = new rfidlist($this->home);
    }
    public function bodymain() {
        $this->obj->maincontent();
    }
    public function bodymainjs(){
        parent::bodymainjs();
    }
}