<?php
class OrganicInternet_SimpleConfigurableProducts_Catalog_Model_Product
    extends Mage_Catalog_Model_Product
{
    public function getMaxPossibleFinalPrice()
    {
        if(is_callable(array($this->getPriceModel(), 'getMaxPossibleFinalPrice'))) {
            return $this->getPriceModel()->getMaxPossibleFinalPrice($this);
        } else {
            #return $this->_getData('minimal_price');
            return parent::getMaxPrice();
        }
    }

    public function isVisibleInSiteVisibility()
    {
        #Force visible any simple products which have a parent conf product.
        #this will only apply to products which have been added to the cart
        if(is_callable(array($this->getTypeInstance(), 'hasConfigurableProductParentId'))
            && $this->getTypeInstance()->hasConfigurableProductParentId()) {
           return true;
        } else {
            return parent::isVisibleInSiteVisibility();
        }
    }

    /**
     * Get product final price not from index
     *
     * @param double $qty
     * @return double
     */
    public function getFinalPrice($qty=null)
    {
        if(Mage::getStoreConfig('SCP_options/moduleInfo/moduleStatus') &&
            Mage::getStoreConfig('SCP_options/product_page/set_price_is_lowest_price')

        ) {
            $price = $this->_getData('min_price');
        }else{
            $price = $this->_getData('final_price');
        }
        if ($price !== null) {
            return $price;
        }
        return $this->getPriceModel()->getFinalPrice($qty, $this);
    }

    public function getProductUrl($useSid = null)
    {
        if(is_callable(array($this->getTypeInstance(), 'hasConfigurableProductParentId'))
            && $this->getTypeInstance()->hasConfigurableProductParentId()) {

            $confProdId = $this->getTypeInstance()->getConfigurableProductParentId();
            return Mage::getModel('catalog/product')->load($confProdId)->getProductUrl();

        } else {
            return parent::getProductUrl($useSid);
        }
    }
}
