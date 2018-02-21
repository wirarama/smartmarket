<?php
class chart extends database{
    public $chartd = array();
    public function __construct($home) {
        $this->home = $home;
        parent::__construct();
    }
    public function bidangUKMRand() {
        $trunc = $this->conn->prepare("TRUNCATE TABLE ukmtahun");
        $trunc->execute();
        $ins = $this->conn->prepare("INSERT INTO ukmtahun VALUES"
                . "(null,'pertanian','2012','8','50','40','10'),"
                . "(null,'pertanian','2013','12','80','50','30'),"
                . "(null,'pertanian','2014','15','95','70','25'),"
                . "(null,'pertanian','2015','14','90','65','25'),"
                . "(null,'pertanian','2016','16','100','60','40'),"
                . "(null,'perdagangan','2012','2','20','10','10'),"
                . "(null,'perdagangan','2013','4','24','12','12'),"
                . "(null,'perdagangan','2014','5','25','15','10'),"
                . "(null,'perdagangan','2015','6','27','17','10'),"
                . "(null,'perdagangan','2016','6','30','18','12'),"
                . "(null,'kuliner','2012','5','120','90','30'),"
                . "(null,'kuliner','2013','6','125','100','25'),"
                . "(null,'kuliner','2014','5','122','102','20'),"
                . "(null,'kuliner','2015','6','124','100','24'),"
                . "(null,'kuliner','2016','8','140','112','28')");
        $ins->execute();
    }
    public function chartQuery($q,$p=array()) {
        $chartd = array();
        $query = $this->conn->prepare($q);
        $query->execute();
        while($d = $query->fetch()){
            $chartdr = '{';
            $chartdc = array();
            $i=0;
            foreach($p AS $p1){
                if($i>1){
                    array_push($chartdc,$p1.':'.$d[$p1]);
                }else{
                    array_push($chartdc,$p1.":'".$d[$p1]."'");
                }
                $i++;
            }
            $chartdr .= implode(',',$chartdc);
            $chartdr .= '}';
            array_push($chartd,$chartdr);
        }
        array_push($this->chartd,implode(",\n",$chartd));
    }
    public function chartQueryMulti($q=array(),$p=array(),$y=array()) {
        $chartd = array();
        $i=0;
        foreach($q AS $q1){
            $query = $this->conn->prepare($q1);
            $query->execute();
            $chartdr = '{';
            $chartdc = array();
            array_push($chartdc,"tahun:'".$y[$i]."'");
            while($d = $query->fetch()){
                array_push($chartdc,$d[$p[0]].':'.$d[$p[1]]);
            }
            $chartdr .= implode(',',$chartdc);
            $chartdr .= '}';
            array_push($chartd,$chartdr);
            $i++;
        }
        return implode(",\n",$chartd);
    }
}
