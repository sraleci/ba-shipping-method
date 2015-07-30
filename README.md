#BlueAcorn Custom Shipping Method
This is a simple custom shipping method in Magento that communicates with an external rating source via HTTP, which
returns a rate that is the weight of the order (for each item, the weight of the item x the quantity of items) x 10.

The HTTP Client is a Zend_Http_Client located in BlueAcorn_Shipping_Model_Carrier, and the HTTP Server is a simple Node
application located in /shippingCarrierServer.js.

## Get Started
Install magento instance.

Install module into Magento. You can use [Modman](https://github.com/colinmollenhour/modman).

```unix
cd /path/to/magento/installation
modman init
modman clone <location_of_git_repo>
```

If not installed, [install Node](https://nodejs.org/).

Start node server.

```unix
cd /path/to/magento/installation
node shippingCarrierServer.js
```
