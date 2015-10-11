<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageProcessingCollection
 *
 * @author sergey
 */
class ImageProcessingCollection {
    
    public function crop($file_input, $file_output, $crop = 'square', $percent = false) {
        
        list($w_i, $h_i, $type) = getimagesize($file_input);
        if (!$w_i || !$h_i) {
            echo 'Невозможно получить длину и ширину изображения';
             return;
        }
        $types = array('','gif','jpeg','png');
        $ext = $types[$type];
        if ($ext) {
            $func = 'imagecreatefrom'.$ext;
             $img = $func($file_input);
        } else {
            echo 'Некорректный формат файла';
            return;
        }
        if ($crop == 'square') {
            $min = $w_i;
            if ($w_i > $h_i) $min = $h_i;
            $w_o = $h_o = $min;
        } else {
            list($x_o, $y_o, $w_o, $h_o) = $crop;
            if ($percent) {
                $w_o *= $w_i / 100;
                $h_o *= $h_i / 100;
                $x_o *= $w_i / 100;
                $y_o *= $h_i / 100;
            }
            if ($w_o < 0) $w_o += $w_i;
            $w_o -= $x_o;
            if ($h_o < 0) $h_o += $h_i;
            $h_o -= $y_o;
        }
        $img_o = imagecreatetruecolor($w_o, $h_o);
        imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
        if ($type == 2) {
            imagejpeg($img_o,$file_output,100);

        } else {
            $func = 'image'.$ext;
            $func($img_o,$file_output);
        }
        imagedestroy($img_o);
    }
    
    public function scan($dir){

        $files = array();

        // Is there actually such a folder/file?

        if(file_exists($dir)){

            foreach(scandir($dir) as $f) {

                if(!$f || $f[0] == '.') {
                    continue; // Ignore hidden files
                }

                if(is_dir($dir . '/' . $f)) {

                    // The path is a folder

                    $files[] = array(
                        "name" => $f,
                        "type" => "folder",
                        "path" => $this->getShortPath($dir . '/' . $f),
                        "items" => $this->scan($dir . '/' . $f) // Recursively get the contents of the folder
                    );
                }

                else {

                    // It is a file

                    $files[] = array(
                        "name" => $f,
                        "type" => "file",
                        "path" => $this->getShortPath($dir . '/' . $f),
                        "size" => filesize($dir . '/' . $f) // Gets the size of this file
                    );
                }
            }

        }

        return $files;
    }
    
    public function getShortPath($fullPath){
        $cut = [];
        $arr = explode('/', $fullPath);
        for($i = 0; $i < count($arr); $i++){
            if($arr[$i] === 'files') {
                for($j = 0; $i < count($arr); $i++){
                        $cut[++$j] = $arr[$i];
                }
            }

        }
            
       return implode('/', $cut);
        
    }
    
}
