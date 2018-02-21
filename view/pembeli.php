<?php
class viewpembeli extends template{
    var $title = "Pembeli";
    public function objdef() {
        require 'control/pembeli.php';
        $this->home = 'index.php?p=pembeli';
        $this->obj = new pembeli($this->home);
    }
    public function bodymain() {
        $this->obj->maincontent();
    }
    public function bodymainjs(){
        parent::bodymainjs();
    }
}