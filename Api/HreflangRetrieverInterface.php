<?php
namespace Dadolun\Hreflang\Api;

use Magento\Store\Model\Store;

/**
 * Interface UrlRetrieverInterface
 * @package Dadolun\Hreflang\Api
 */
interface HreflangRetrieverInterface
{
    /**
     * @param string|int $identifier
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store);
}
