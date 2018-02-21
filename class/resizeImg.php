<?php
class imageEdit{
    function imgRename($in,$name){
        return str_replace(' ','_',$name).$this->imgExt($in);
    }
    function imgThumb($in){
        return str_replace('.','_Thumb.',$in);
    }
    function imgExt($in){
        $info = getimagesize($in);
        $mime = $info['mime'];
        switch ($mime) {
            case 'image/jpeg':
                    $ext = '.jpg';
                    break;
            case 'image/png':
                    $ext = '.png';
                    break;
            case 'image/gif':
                    $ext = '.gif';
                    break;
        }
        return $ext;
    }
    function imgInfo($in){
        $info = getimagesize($in);
        $mime = $info['mime'];
        switch ($mime) {
            case 'image/jpeg':
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';
                    break;
            case 'image/png':
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';
                    break;
            case 'image/gif':
                    $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';
                    break;
        }
        return array($mime,$image_create_func,$image_save_func);
    }
    function imgResize($in,$out,$w,$h){
        $opt = $this->imgInfo($in);
        $image = $opt[1]($in);
        $width = imagesx($image);
        $height = imagesy($image);
        $original_aspect = $width / $height;
        $thumb_aspect = $w / $h;
        if ( $original_aspect >= $thumb_aspect ){
           $new_height = $h;
           $new_width = $width / ($height / $h);
        }else{
           $new_width = $w;
           $new_height = $height / ($width / $w);
        }
        $thumb = imagecreatetruecolor( $w, $h );
        imagecopyresampled($thumb,$image,0 - ($new_width - $w) / 2,0 - ($new_height - $h) / 2,0, 0,$new_width, $new_height,$width, $height);
        $opt[2]($thumb,$out);
    }
}