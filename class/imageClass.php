<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of imageClass
 *
 * @author Рой
 */
class imageClass {
    
    public function uploadFrontImage($file, $width=340, $water = true){
        
        $imageinfo = getimagesize($_FILES[$file]['tmp_name']);
        if (($imageinfo['mime'] != 'image/png')&&($imageinfo['mime'] != 'image/jpg')&&($imageinfo['mime'] != 'image/jpeg')){
            return false;
        }
        
        $image_new = $this->imageResize($_FILES[$file]['tmp_name'], $width);
        
        $image_thumb = $this->imageResize($_FILES[$file]['tmp_name'], 100);
        
        $prefix = uniqid();
        $fileName = $prefix . '_' . basename($_FILES[$file]['name']);
        $uploaddir = heretic::$_path['images_thumb'];
        $uploadfile =  $uploaddir . $fileName;
        if (imagejpeg($image_thumb, $uploadfile, 100)){
            $uploaddir = heretic::$_path['front_images'];
            $uploadfile =  $uploaddir . $fileName;
        
            if (imagejpeg($image_new, $uploadfile, 90)) {
                if ($water) $this->wetermark($uploadfile);
                return $fileName;
            }else return false;
        }else return false;
        
    }
    
    
    
    
    private function uploadFileMany(){
        
        $file = "photogallery";
        $fileCount = count($_FILES["photogallery"]["name"]);
        for($i=0; $i < $fileCount; $i++){
            
            $imageinfo = getimagesize($_FILES[$file]['tmp_name'][$i]);
            if (($imageinfo['mime'] != 'image/png')&&($imageinfo['mime'] != 'image/jpg')&&($imageinfo['mime'] != 'image/jpeg')){
                return false;
            }

            $image_new = $this->imageResize($_FILES[$file]['tmp_name'][$i], $width);

            $image_thumb = $this->imageResize($_FILES[$file]['tmp_name'][$i], 100);

            $prefix = uniqid();
            $fileName = $prefix . '_' . basename($_FILES[$file]['name'][$i]);
            $uploaddir = heretic::$_path['images_thumb'];
            $uploadfile =  $uploaddir . $fileName;
            
            
            if (imagejpeg($image_thumb, $uploadfile, 100)){
                $uploaddir = heretic::$_path['front_images'];
                $uploadfile =  $uploaddir . $fileName;

                if (imagejpeg($image_new, $uploadfile, 90)) {
                    $this->wetermark($uploadfile);
                    return $fileName;
                }else return false;
            }else return false;
            
            
        }
        
        
        
        
        
    }
    
    
    
    
//    public function uploadGallery($file){
//        
//        $imageinfo = getimagesize($_FILES[$file]['tmp_name']);
//        if (($imageinfo['mime'] != 'image/png')&&($imageinfo['mime'] != 'image/jpg')&&($imageinfo['mime'] != 'image/jpeg')){
//            return false;
//        }
//        
//        $image_new = $this->imageResize($_FILES[$file]['tmp_name'], 1024);
//        $image_thumb = $this->imageResize($_FILES[$file]['tmp_name'], 100, 100);
//        
//        $prefix = uniqid();
//        $fileName = $prefix . '_' . basename($_FILES[$file]['name']);
//        $uploaddir = heretic::$_path['images_thumb'];
//        $uploadfile =  $uploaddir . $fileName;
//        if (imagejpeg($image_thumb, $uploadfile, 100)){
//            $uploaddir = heretic::$_path['big_image'];
//            $uploadfile =  $uploaddir . $fileName;
//        
//            if (imagejpeg($image_new, $uploadfile, 90)) return $fileName;
//                else return false;
//        }else return false;
//        
//    }
    
    
    private function imageResize($image, $new_width = 0, $new_height = 0){
        list($width, $height) = getimagesize($image);
        
        if($width < $new_width){
            $new_width = $width;
            $new_height = $height;
        }
        
        if (!$new_height){
            $ratio = $new_width/$width;
            $new_height = round($height * $ratio); 
        }else{
            
        }
        
        $image_new = imagecreatetruecolor($new_width, $new_height);
        $image_old = imagecreatefromjpeg($image);
        imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        return $image_new;
        
    }
    
    
    private function wetermark($image){
        list($width, $height) = getimagesize($image);
        
        $stamp = imagecreatefrompng('assets/images/watermark.png');
        $image_old = imagecreatefromjpeg($image);
        imagecopyresampled($image_old, $stamp, 0, 0, 0, 0, 148, 40, 148, 40);
        imagejpeg($image_old, $image, 100);
        
    }
    
}
