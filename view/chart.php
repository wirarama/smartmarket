<?php
class viewchart extends template{
    var $title = "Chart";
    public $bidang = array();
    public $tahun = array();
    private $chart1;
    private $chart2;
    public function objdef() {
        require 'control/chart.php';
        $this->home = 'index.php?p=chart';
        $this->obj = new chart($this->home);
    }
    public function preload() {
        parent::preload();
        $this->bidang = array('pertanian','perdagangan','kuliner');
        $this->tahun = array('2012','2013','2014','2015','2016');
    }
    public function bodymain() {
        $this->obj->bidangUKMRand();
        $qmulti = array();
        foreach($this->tahun AS $tahun1){
            array_push($qmulti,"SELECT * FROM ukmtahun WHERE tahun='".$tahun1."'");
        }
        $this->chart1 = $this->obj->chartQueryMulti($qmulti,array('bidang','profit','tahun'),$this->tahun);
        $this->chartPanel('Profit','profit');
        $this->chart2 = $this->obj->chartQueryMulti($qmulti,array('bidang','jumlah','tahun'),$this->tahun);
        $this->chartPanel('Jumlah','jumlah');
        foreach($this->bidang AS $bidang1){
            $this->obj->chartQuery("SELECT * FROM ukmtahun WHERE bidang='".$bidang1."'",
                    array('bidang','tahun','jumlah','pendapatan','pengeluaran','profit'));
            $this->chartPanel($bidang1,$bidang1);
        }
    }
    public function chartPanel($head,$chart){
        ?>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo ucfirst($head); ?>
                    </div>
                    <div class="panel-body">
                        <div id="<?php echo $chart; ?>"></div>
                    </div>
                </div>
            </div>
        <?php
    }
    public function headcss() {
        parent::headcss();
        $this->headcssadd();
    }
    public function bodymainjs(){
        parent::bodymainjs();
        $this->bodymainjsAdditional();
        ?>
        <script>
        Morris.Area({
            element : 'profit',
            data:[<?php echo $this->chart1; ?>],
            xkey:'tahun',
            ykeys:['pertanian','perdagangan','kuliner'],
            labels:['Pertanian','Perdagangan','Kuliner'],
            hideHover: 'auto',
            resize: true
        });
        Morris.Area({
            element : 'jumlah',
            data:[<?php echo $this->chart2; ?>],
            xkey:'tahun',
            ykeys:['pertanian','perdagangan','kuliner'],
            labels:['Pertanian','Perdagangan','Kuliner'],
            hideHover: 'auto',
            resize: true
        });
        <?php $i=0; foreach($this->bidang AS $bidang1){ ?>
        Morris.Bar({
            element : '<?php echo $bidang1; ?>',
            data:[<?php echo $this->obj->chartd[$i]; ?>],
            xkey:'tahun',
            ykeys:['jumlah','pendapatan','pengeluaran','profit'],
            labels:['jumlah','Pendapatan(jt)','Pengeluaran(jt)','Profit(jt)'],
            hideHover: 'auto',
            resize: true
        });
        <?php $i++; } ?>
        </script>
        <?php
    }
}