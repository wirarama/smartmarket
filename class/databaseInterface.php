<?php
interface databaseInterface{
    public function connect();
    public function query($q);
    public function querySelect();
    public function queryStat($q,$stat=array());
}
