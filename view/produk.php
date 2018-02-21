<?php
class viewproduk extends template{
    var $title = "Produk";
    public function objdef() {
        require 'control/produk.php';
        $this->home = 'index.php?p=produk';
        $this->obj = new produk($this->home);
    }
    public function bodymain() {
        $this->obj->maincontent();
    }
    public function bodymainjs(){
        parent::bodymainjs();
    }
}