<?php
require '../class/databaseInterface.php';
require '../class/database.php';
$q1 = new database();
$q = $q1->conn->prepare("SELECT b.id AS xid,b.rfid AS xrfid,b.nama AS xnama,"
        . "a.tanggal AS tgl FROM loginpenduduk AS a,penduduk AS b "
        . "WHERE a.rfid=b.rfid ORDER BY a.id DESC");
$q->execute();
while($d = $q->fetch()){
?>
    <div class="alert alert-success">
      [<?php echo $d['tgl']; ?>] <?php echo $d['xrfid']; ?> - 
      <a href="index.php?p=penduduk&detail=<?php echo $d['xid']; ?>"><?php echo $d['xnama']; ?></a>
    </div>
<?php
}
date_default_timezone_set("Asia/Kuala_Lumpur");
echo date('h:m:s a');