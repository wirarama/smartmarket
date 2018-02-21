<?php
class viewlogin extends template{
    var $title = "Login";
    public function objdef() {
        require 'control/login.php';
        $this->home = 'index.php?p=login';
        $this->obj = new login($this->home);
    }
    public function bodymain() {
        $this->obj->maincontent();
    }
    public function bodymainjs(){
        parent::bodymainjs();
    }
}