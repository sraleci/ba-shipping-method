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

        $totalWeight = 0;
        foreach ($request->getAllItems() as $item) {
            $totalWeight += $item->getWeight() * $item->getQty();
        }
        /** @var string $hostname */
        $hostname = $this->getConfigData('hostname');

        /** @var string $port */
        $port = $this->getConfigData('port');

        try {
            $client = new Zend_Http_Client();
            $response = $client->setUri(
                "http://localhost:3000/"
            )->setRawData(
                json_encode(['totalWeight'=>$totalWeight])
            )->setEncType(
                'application/json'
            )->request('POST');

            $responseBody = json_decode($response->getBody());
            $result->append($this->_getShippingMethod($responseBody->rate));
        } catch (Exception $e) {
            var_dump($e);
        }

        return $result;
    }

    /**
     * @param string|float|int $price
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    protected function _getShippingMethod($price) {
        /** @var Mage_Shipping_Model_Rate_Result_Method $method */
        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $method->setPrice($price);
        $method->setCost(0);

        return $method;
    }

    /**
     * @return array
     */
    public function getAllowedMethods() {
        return [
            $this->_code => $this->getConfigData('name')
        ];
    }
}