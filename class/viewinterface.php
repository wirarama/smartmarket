<?php
interface viewinterface {
    public function preload();
    public function headmeta();
    public function headcss();
    public function bodyheadernav();
    public function bodyheadernavcontent();
    public function bodyheader();
    public function bodymain();
    public function bodyfooter();
    public function bodymainjs();
}