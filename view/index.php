<?php
class viewindex extends template{
    var $title = "Home";
    public function objdef() {
        require 'control/index.php';
        $this->home = 'index.php';
        $this->obj = new index($this->home);
    }
    public function bodymain() {
        if(empty(filter_input(2,'login'))){
            $this->loginform();
        }else{
            $this->home();
        }
    }
    public function preload() {
        $this->objdef();
        if(!empty(filter_input(0,'login'))){
            $this->obj->login();
        }else if(!empty(filter_input(1,'logout'))){
            $this->obj->logout();
        }
    }
    public function loginform(){
        ?>
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Login</h3>
                </div>
                <div class="panel-body">
                    <?php $this->theform(); ?>
                </div>
            </div>
        </div>
        <?php
    }
    public function dashBoard($tt,$ic,$col,$num,$link){
        ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel <?php echo $col; ?>">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa <?php echo $ic; ?> fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $num; ?></div>
                            <div><?php echo $tt; ?></div>
                        </div>
                    </div>
                </div>
                <a href="index.php?p=<?php echo $link; ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Lihat</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <?php
    }
    public function theform(){
    ?>
<form role="form" method="POST" action="">
    <fieldset>
        <div class="form-group">
            <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Password" name="password" type="password" value="">
        </div>
        <div class="form-group">
            <input class="btn btn-lg btn-success btn-block" name="login" type="submit" value="Login">
        </div>
    </fieldset>
</form>
    <?php
    }
    public function home() {
        require 'class/data.php';
        $rand = new data();
        //$rand->inputPembeli();
        //$rand->inputProduk();
        //$rand->inputTransaksi();
        //$rand->inputUKM();
        $title = array('Produk','Pembelian','Penjualan','Laporan');
        $icon = array('fa-gift','fa-briefcase','fa-shopping-cart','fa-book');
        $color = array('panel-primary','panel-green','panel-yellow','panel-red');
        $link = array('penduduk','ukm','dokumen','laporan');
        $num = array(rand(0,100),rand(0,100),rand(0,100),rand(0,100));
        for($i=0;$i<sizeof($title);$i++){
            $this->dashBoard($title[$i],$icon[$i],$color[$i],$num[$i],$link[$i]);
        }
    }
}
