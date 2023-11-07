<?php
namespace Xseed\GoogleMap\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class GoogleMap extends Template implements \Magento\Widget\Block\BlockInterface
{
    protected $scopeConfig;

    /**
     * @var string
     */
    protected $_template = 'Xseed_GoogleMap::gmap.phtml';

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getMapLatitude()
    {
        return $this->getData('map_latitude');
    }

    public function getMapLongitude()
    {
        return $this->getData('map_longitude');
    }

    public function getMapZoom()
    {
        return $this->getData('map_zoom');
    }

    public function getGoogleMapUrl()
    {
        $latitude = $this->getMapLatitude();
        $longitude = $this->getMapLongitude();
        $zoom = $this->getMapZoom();

        // Retrieve your Google Maps API key from configuration
        $apiKey = $this->getGoogleMapsApiKey();

        // Build the Google Map URL
        $url = "https://www.google.com/maps/embed/v1/view?key=$apiKey&center=$latitude,$longitude&zoom=$zoom";

        return $url;
    }

    public function getGoogleMapsApiKey()
    {
        // Use scopeConfig to retrieve the Google Maps API key from configuration
        return $this->scopeConfig->getValue('xseed_gmap_section/googlemap_group/api_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    protected function _toHtml()
    {
        return  "Luu Thanh Thuy";
        if (!$this->getTemplate()) {
            return '';
        }
        return $this->fetchView($this->getTemplateFile());
    }

}
