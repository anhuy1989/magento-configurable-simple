<?php

class OrganicInternet_SimpleConfigurableProducts_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function IsModuleActiveOnStore($storeId)
    {

        if ($storeId === 'undefined') {
            return false;
        }

        return mage::getStoreConfig('SCP_options/moduleInfo/moduleStatus', $storeId);
    }
}
