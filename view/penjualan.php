<?php
class viewpenjualan extends template{
    var $title = "Transaksi Penjualan";
    public function objdef() {
        require 'control/penjualan.php';
        $this->home = 'index.php?p=penjualan';
        $this->obj = new penjualan($this->home);
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