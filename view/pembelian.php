<?php
class viewpembelian extends template{
    var $title = "Transaksi Pembelian";
    public function objdef() {
        require 'control/pembelian.php';
        $this->home = 'index.php?p=pembelian';
        $this->obj = new pembelian($this->home);
    }
    public function bodymain() {
        $this->obj->maincontent();
    }
    public function bodymainjs(){
        parent::bodymainjs();
    ?>
        <script src="dist/js/transaksi.js" type="text/javascript"></script>
    <?php
    }
}