<?php
class viewdokumen extends template{
    var $title = "Dokumen";
    public function objdef() {
        require 'control/dokumen.php';
        $this->home = 'index.php?p=dokumen';
        $this->obj = new dokumen($this->home);
    }
    public function bodymain() {
        $this->obj->maincontent();
    }
}