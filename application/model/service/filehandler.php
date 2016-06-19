<?php

/**
 * FileHandler
 * This is a class that handles file related functions
 * @package service
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class FileHandler {

    const ALLOWED_TYPES = array(1, 2, 3);
    const MAX_IMG_SIZE = 20977520; //20MB
//    const TMP_IMG_ROOT = 'application/view/images/uploads/';
    const IMG_DESTIN_ROOT = 'application/view/images/';

    public function addFolder($root, $folderName) {
        if (!is_dir($root)) {
            throw new ServiceException($root . ' is not a path to a folder');
        }
        if (!mkdir($root . $folderName)) {
            throw new ServiceException('Could not create ' . $root . $folderName . ' new folder');
        }
    }

    public function removeFolder($path) {
        if (!is_dir($path)) {
            throw new ServiceException('Folder ' . $path . ' not found');
        }
        $subs = scandir($path);
        foreach ($subs as $sub) {
            if ($sub != '.' && $sub != '..') {
                $obj = $path . '/' . $sub;
                if (is_dir($obj)) {
                    $this->removeFolder($obj);
                } else {
                    $this->removeFile($obj);
                }
            }
        }
        if (!rmdir($path)) {
            throw new ServiceException('Could not remove dir: ' . $path);
        }
    }

    public function removeFile($path) {
        if (!is_file($path)) {
            throw new ServiceException($path . ' is not a file');
        }
        if (!unlink($path)) {
            throw new ServiceException('Could not remove file: ' . $path);
        }
    }

    public function getDirFileCount($path) {
        $count = 0;
        $files = scandir($path);
        foreach ($files as $file) {
            if (is_file($path . $file)) {
                $count ++;
            }
        }
        return $count;
    }

    private function getNumberName($dir, $imgName) {
        $i = $this->getDirFileCount($dir);
        $nr = ($i > 0) ? '_' . $i : '';
        $pos = strrpos($imgName, '.');
        $imgName = substr($imgName, 0, $pos) . $nr . substr($imgName, $pos);
        return $imgName;
    }

    public function addImgFile($fileArr, $type, $subFolder = '', $altName = NULL) {
        $imgType = $this->imgUploadChecks($fileArr);
        $tmpLocation = $fileArr['tmp_name'];
        $imgName = $fileArr['name'];
        if ($altName) {
            $imgName = $altName . $imgType;
        }
        $destin = $this->getDestination($type, $imgName, $subFolder);
        if (!move_uploaded_file($tmpLocation, $destin)) {
            throw new ServiceException('Could not add file: ' . $destin);
        }
        $pos = strrpos($destin, '/');
        return substr($destin, $pos + 1);
    }

    public function getDestination($type, $imgName, $subFolder = '') {
        switch ($type) {
            case 'achievement':
                return self::IMG_DESTIN_ROOT . 'achievements/' . $imgName;
            case 'avatar':
                $dir = self::IMG_DESTIN_ROOT . 'avatars/';
                $num = explode('.', $imgName)[0];
                if (is_numeric($num)) {
                    $extention = substr($imgName, strrpos($imgName, '.'));
                    $imgName = 'avatar' . $this->getNumberName($dir . 'tier' . $num, $extention);
                } else {
                    $imgName = 'user_' . $imgName;
                }
                if (!is_dir($dir . $subFolder)) {
                    $this->addFolder($dir, $subFolder);
                }
                return $dir . $subFolder . $imgName;
            case 'design' :
                return self::IMG_DESTIN_ROOT . 'design/' . $imgName;
            case 'game' :
                $dir = self::IMG_DESTIN_ROOT . 'games/' . $subFolder;
                if (!is_dir($dir)) {
                    mkdir($dir);
                }
                $imgName = $this->getNumberName($dir, $imgName);
                return $dir . $imgName;
            case 'newsfeed' :
                return self::IMG_DESTIN_ROOT . 'newsfeeditems/' . $imgName;
            default :
                throw new ServiceException('Could not find a destination folder for ' . $type);
        }
    }

    public function cleanWhiteSpace($nameOg) {
        $name = preg_replace("/[^A-Za-z0-9 ]/", '', $nameOg);        
        $name = str_replace(' ', '_', $name);
        return $name;
    }

    private function imgUploadChecks($fileArr) {
        $imgType = exif_imagetype($fileArr['tmp_name']);
        $errorTxt = '';
        if (!$imgType) {
            throw new ServiceException('Not able to add the image, image type not found');
        }
        if (!$this->checkAllowedImgType($imgType)) {
            $errorTxt .= 'Sorry, this file size is not allowed. You can only add png, jpeg or gif images\n';
        }
        if (!$this->checkSizeAllowed($fileArr['size'])) {
            $errorTxt .= 'Sorry, this image is to large. The maximum allowed image size is ' . $this->FileSizeConvert(self::MAX_IMG_SIZE);
        }
        if (!empty($errorTxt)) {
            throw new ServiceException($errorTxt);
        }
        return image_type_to_extension($imgType);
    }

    private function checkAllowedImgType($imgType) {
        return in_array($imgType, self::ALLOWED_TYPES);
    }

    private function checkSizeAllowed($imgSize) {
        return ($imgSize <= self::MAX_IMG_SIZE);
    }

    /**
     * Converts bytes into human readable file size. 
     * FOUND ON php.net comments
     * @param string $bytes 
     * @return string human readable file size (2,87 Мб)
     * @author Mogilev Arseny 
     */
    function FileSizeConvert($bytes) {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 0))) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    public function reArrayFiles(&$file_post) {
        //FOUND ON PHP.NET COMMENTS (phpuser@gmail.com)
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

    public function removeEmptyFiles(&$file_post) {
        $cleaned = array();
        foreach ($file_post as $fileArr) {
            if ($fileArr['name']) {
                array_push($cleaned, $fileArr);
            }
        }
        return $cleaned;
    }

}
