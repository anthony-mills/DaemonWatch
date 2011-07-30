<?php
class Zend_View_Helper_BaseUrl
{

    /* Function baseUrl()
     * Gets the base url
     */
    function baseUrl()
    {
        $fc = Zend_Controller_Front::getInstance();
        return $fc->getBaseUrl();
    }
}