<?php

class imageHelper {
    public function __construct() {
    }

    private function createCarouselSizes() {
        $sizesArr = array();
        $sizesArr['xl'] = array('w' => '1100', 'h' => '400');
        $sizesArr['l'] = array('w' => '800', 'h' => '400');
        $sizesArr['mpr'] = array('w' => '', 'h' => '');
        $sizesArr['msec'] = array('w' => '', 'h' => '');
        
        $sizesArr['sideXL'] = array('w' => '152', 'h' => '402');
        $sizesArr['sideL'] = array('w' => '102', 'h' => '402');        
        return $sizesArr;        
    }
    
    private function createNewsfeedSizes() {                
        $sizesArr = array();
        $sizesArr['xl'] = array('w' => '800', 'h' => '320');
        $sizesArr['l'] = array('w' => '571', 'h' => '320');
        $sizesArr['m'] = array('w' => '', 'h' => '');
        $sizesArr['sm'] = array('w' => '', 'h' => '');
        $sizesArr['xs'] = array('w' => '', 'h' => '');
        return $sizesArr;
    }   
   
    private function getSizesArr($type, $size) {
        switch ($type) {
            case 'carousel' : 
                return $this->createCarouselSizes()[$size];                
            case 'newsfeed' :
                return $this->createNewsfeedSizes()[$size];
        }
    }
    
    private function getImgSrc($size, $imgPath, $img, $type) {
        $sizeArr = $this->getSizesArr($type, $size);
        $viewRoot = Globals::getRoot('view');
        $imgFullPath = $imgPath . '/' . $img;
        $crop = $sizeArr['w'] . ':' . $sizeArr['h'];
        $og = array('parImg', 'parW', 'parH', 'parCrop', 'par-img-path');
        $repl = array($img, $sizeArr['w'], $sizeArr['h'], $crop, $imgFullPath);
        $srcOg = 'view/phpscripts/image.php/parImg?width=parW&AMP;height=parH&AMP;cropratio=parCrop&AMP;image=/' . $viewRoot . '/images/par-img-path';
        $src = str_replace($og, $repl, $srcOg);
        return $src;
    }

    public function getCarouselSourceArray($path, $img){        
        $sources = array();
        $keys = array_keys($this->createCarouselSizes());
        foreach($keys as $key) {            
            $src = $this->getImgSrc($key, $path, $img, 'carousel');
            $sources[$key] = $src;
        }
        return $sources;
    }
    
    public function getNewsfeedSourceArray($images) {        
        $sources = array();        
        foreach ($images as $img){                        
        $keys = array_keys($this->createNewsfeedSizes());        
            foreach ($keys as $key) {                     
                $src = $this->getImgSrc($key, 'newsfeeditems', $img, 'newsfeed');
                $sources[$img][$key] = $src;
            }
        }
        
        return $sources;
    }
    
}
