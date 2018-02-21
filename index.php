<?php
require 'class/viewinterface.php';
require 'class/view.php';
require 'class/template.php';
require 'class/databaseInterface.php';
require 'class/database.php';
require 'class/form.php';
switch(filter_input(1,'p')){
    case('produk'):
        require 'view/produk.php';
        $view = new viewproduk();
        break;
    case('supplier'):
        require 'view/supplier.php';
        $view = new viewsupplier();
        break;
    case('pembeli'):
        require 'view/pembeli.php';
        $view = new viewpembeli();
        break;
    case('pembelian'):
        require 'view/pembelian.php';
        $view = new viewpembelian();
        break;
    case('penjualan'):
        require 'view/penjualan.php';
        $view = new viewpenjualan();
        break;
    case('login'):
        require 'view/login.php';
        $view = new viewlogin();
        break;
    case('rfidlist'):
        require 'view/rfidlist.php';
        $view = new viewrfidlist();
        break;
    default:
        require 'view/index.php';
        $view = new viewindex();
        break;
}