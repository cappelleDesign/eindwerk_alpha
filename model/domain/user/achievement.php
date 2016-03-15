<?php

/**
 * Achievement
 * @package model
 * @subpackage domain.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Achievement implements DaoObject {

    /**
     * The achievement id
     * @var int
     */
    private $_id;

    /**
     * The image for the achievement
     * @var Image
     */
    private $_image;

    /**
     * The name for this achievement
     * @var string
     */
    private $_name;

    /**
     * The description of this achievement
     * @var string 
     */
    private $_desc;

    /**
     * The amount of karma points rewarded when getting this achievement
     * @var int
     */
    private $_karmaReward;

    /**
     * The amount of diamonds rewarded when getting this achievement
     * @var int
     */
    private $_diamondReward;

    public function __construct(Image $image, $name, $desc, $karmaReward, $diamondReward) {
        $this->setImage($image);
        $this->setName($name);
        $this->setDesc($desc);
        $this->setKarmaReward($karmaReward);
        $this->setDiamondReward($diamondReward);
    }

    /* ---------------------------------------------------------------------- */

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setImage(Image $image) {
        $this->_image = $image;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function setDesc($desc) {
        $this->_desc = $desc;
    }

    public function setKarmaReward($karmaReward) {
        $this->_karmaReward = $karmaReward;
    }

    public function setDiamondReward($diamondReward) {
        $this->_diamondReward = $diamondReward;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getImage() {
        return $this->_image;
    }

    public function getName() {
        return $this->_name;
    }

    public function getDesc() {
        return $this->_desc;
    }

    public function getKarmaReward() {
        return $this->_karmaReward;
    }

    public function getDiamondReward() {
        return $this->_diamondReward;
    }

    public function jsonSerialize() {
        $arr = array();
        //TODO implement
        return $arr;
    }

}
