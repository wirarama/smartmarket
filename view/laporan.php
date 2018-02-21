<?php
class viewlaporan extends template{
    var $title = "Laporan";
    public function objdef() {
        require 'control/laporan.php';
        $this->home = 'index.php?p=laporan';
        $this->obj = new laporan($this->home);
    }
    public function bodymain() {
        $this->obj->maincontent();
    }
}