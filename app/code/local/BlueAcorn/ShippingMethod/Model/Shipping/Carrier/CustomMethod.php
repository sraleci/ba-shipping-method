<?php
class BlueAcorn_ShippingMethod_Model_Shipping_Carrier_CustomMethod
    implements Mage_Shipping_Model_Carrier_Interface
{
    /**
     * Check if carrier has shipping tracking option available
     *
     * @return boolean
     */
    public function isTrackingAvailable() {
        return false;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods() {
        return []; // Todo: Implement
    }

    /**
     * Collect and get rates
     *
     * @abstract
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result|bool|null
     */
     public function collectRates(Mage_Shipping_Model_Rate_Request $request) {
        return null; // Todo: Implement
    }
}
