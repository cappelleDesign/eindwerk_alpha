<?php

/**
 * FileHandler
 * This is a class that handles file related functions
 * @package service
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class FileHandler {

    public function addFolder($root, $folderName) {
        if(!is_dir($root)){
            throw new ServiceException($root . ' is not a path to a folder');
        }
        if (!mkdir($root . $folderName)) {
            throw new ServiceException('Could not create ' . $root . $folderName . ' new folder');
        }
    }

    public function removeFolder($path) {
        if (!is_dir($path)) {
            throw new ServiceException('Folder ' . $path .' not found');
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
        rmdir($path);
        Globals::cleanDump('rm dir: ' . $path);
    }

    public function removeFile($path) {
        Globals::cleanDump('rm file: ' . $path);
    }

}
