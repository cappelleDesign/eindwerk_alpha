<?php

class imageHelper {

    public function __construct() {
        
    }

    private function createCarouselSizes() {
        $sizesArr = array();
        $sizesArr['xl'] = array('w' => '1100', 'h' => '400');
        $sizesArr['l'] = array('w' => '800', 'h' => '400');
        $sizesArr['m-pri'] = array('w' => '800', 'h' => '300');
        $sizesArr['m-sec'] = array('w' => '399', 'h' => '300');
        $sizesArr['s'] = array('w' => '', 'h' => '');

        $sizesArr['sideXL'] = array('w' => '150', 'h' => '400');
        $sizesArr['sideL'] = array('w' => '100', 'h' => '400');
        return $sizesArr;
    }

    private function createNewsfeedSizes() {
        $sizesArr = array();
        $sizesArr['xl'] = array('w' => '800', 'h' => '320');
        $sizesArr['l'] = array('w' => '571', 'h' => '320');
        $sizesArr['m'] = array('w' => '400', 'h' => '350');
        $sizesArr['s'] = array('w' => '', 'h' => '');
        $sizesArr['xs'] = array('w' => '', 'h' => '');
        return $sizesArr;
    }
    private function createAvatarSizes() {
        $sizesArr = array();
        $sizesArr['xl'] = array('w' => '300', 'h' => '300');
        $sizesArr['l'] = array('w' => '200', 'h' => '200');
        $sizesArr['m'] = array('w' => '100', 'h' => '100');
        $sizesArr['s'] = array('w' => '50', 'h' => '50');
        $sizesArr['xs'] = array('w' => '25', 'h' => '25');
        return $sizesArr;
    }

    private function getSizesArr($type, $size) {
        switch ($type) {
            case 'carousel' :
                return $this->createCarouselSizes()[$size];
            case 'newsfeed' :
                return $this->createNewsfeedSizes()[$size];
            case 'avatar' :
                return $this->createAvatarSizes()[$size];
        }
    }

    public function getImgSrc($size, $imgPath, $img, $type) {
        $sizeArr = $this->getSizesArr($type, $size);
        $viewRoot = Globals::getRoot('view', 'app', true);
        $scriptRoot = Globals::getRoot('view', 'sys');
        $imgFullPath = $imgPath . '/' . $img;
        $crop = $sizeArr['w'] . ':' . $sizeArr['h'];
        $og = array('parImg', 'parW', 'parH', 'parCrop', 'par-img-path');
        $repl = array($img, $sizeArr['w'], $sizeArr['h'], $crop, $imgFullPath);
        $srcOg = $scriptRoot . '/phpscripts/image.php/parImg?width=parW&AMP;height=parH&AMP;cropratio=parCrop&AMP;image=/' . $viewRoot . '/images/par-img-path';
        $src = str_replace($og, $repl, $srcOg);
        return $src;
    }

    public function getCarouselSourceArray($path, $img) {
        $sources = array();
        $keys = array_keys($this->createCarouselSizes());
        foreach ($keys as $key) {
            $src = $this->getImgSrc($key, $path, $img, 'carousel');
            $sources[$key] = $src;
        }
        return $sources;
    }

    public function getNewsfeedSourceArray($images) {
        $sources = array();
        foreach ($images as $img) {
            $keys = array_keys($this->createNewsfeedSizes());
            foreach ($keys as $key) {
                $src = $this->getImgSrc($key, 'newsfeeditems', $img, 'newsfeed');
                $sources[$img][$key] = $src;
            }
        }

        return $sources;
    }

}
