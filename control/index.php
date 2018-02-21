<?php
class index extends database{
    public function login() {
        $query = $this->conn->prepare("SELECT username,status,id FROM login "
            . "WHERE username='".filter_input(0,'username')."' "
            . "AND password=MD5('".filter_input(0,'password')."')");
        $query->execute();
        $d = $query->fetch();
        if($query->rowCount()!=0){
            setcookie('login',$d['id']);
            setcookie('status',$d['status']);
            header('location:index.php');
        }else{
            header('location:index.php?gagal=1');
        }
    }
    public function logout() {
        setcookie('login','');
        setcookie('status','');
        header('location:index.php');
    }
}
