<?php
class template extends view{
    function __construct() {
        $this->preload();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->headmeta(); $this->headcss(); ?>
</head>
<body>
    <div id="wrapper">
        <?php $this->bodyheadernav(); $this->body(); ?>
    </div>
    <?php $this->bodymainjs(); ?>
</body>
</html>
<?php
    }
    public function body() {
        if(!empty(filter_input(2,'login'))){ ?>
        <div id="page-wrapper">
            <?php $this->bodyheader(); $this->bodypart(); ?>
        </div>
        <?php }else{ $this->bodymain(); }
    }
    public function bodypart(){
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <?php if(!empty(filter_input(2,'login')) && !empty(filter_input(1,'p'))){ ?>
                    <div class="panel-heading">
                        <?php if(empty(filter_input(1,'input')) && empty(filter_input(1,'edit')) && empty(filter_input(1,'detail')) && filter_input(1,'p')!='chart'){ ?>
                        <a href="<?php echo $this->home; ?>&input=1" class="btn btn-success">Input Baru <i class="fa fa-plus fa-fw"></i></a>
                        <?php }else if(filter_input(1,'p')=='chart'){ ?>&nbsp;
                        <?php }else{ ?><a href="<?php echo $this->home; ?>" class="btn btn-danger"><i class="fa fa-arrow-left fa-fw"></i> Kembali</a><?php } ?>
                    </div><?php } ?>
                    <div class="panel-body">
                        <?php echo $this->bodymain(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
