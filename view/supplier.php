<?php
class viewsupplier extends template{
    var $title = "Supplier";
    public function objdef() {
        require 'control/supplier.php';
        $this->home = 'index.php?p=supplier';
        $this->obj = new supplier($this->home);
    }
    public function bodymain() {
        $this->obj->maincontent();
    }
    public function bodymainjs(){
        parent::bodymainjs();
    }
}