<?php

class AvatarValidationController extends SuperValidator {

    public function validateAvatarAddForm($avatarArr) {
        $result = $this->getValidationArray();
        if($this->isHuman($avatarArr['isHuman'], $result)){
            $this->validateAvatarAlt($avatarArr['alt'], $result);
            $this->validateAvatarTier($avatarArr['tier'], $result);
        }
        return $result;
    }

    private function validateAvatarTier($val, &$result){
        $this->basicEmptyCheck('Tier', $val, 'avatarTierState', $result);
    }
    
    private function validateAvatarAlt($val, &$result) {
        $this->basicEmptyCheck('Alt', $val, 'avatarAltState', $result);
    }
    
    private function getValidationArray() {
        $validationArray = array(
            'avatarAltState' => $this->getBasicArr(),
            'avatarTierState' => $this->getBasicArr(),            
        );
        return $validationArray;
    }

}
