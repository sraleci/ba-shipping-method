<?php

class BlueAcorn_Shipping_Model_Carrier
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    /** @var string */
    protected $_code = 'blueacorn_shipping';

    /**
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request) {
        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');

        $result->append($this->_getShippingMethod());

        return $result;
    }

    protected function _getShippingMethod() {
        /** @var Mage_Shipping_Model_Rate_Result_Method $method */
        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $method->setPrice(13.37);
        $method->setCost(0);

        return $method;
    }

    /**
     * @return array
     */
    public function getAllowedMethods() {
        return array(
            $this->_code => $this->getConfigData('name')
        );
    }
}