<?php

namespace Dadolun\Hreflang\Model\Retriever;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Hreflang
 * @package Dadolun\Hreflang\Model\Retriever
 */
class HreflangService
{

    /**
     * @var HttpRequest
     */
    private $request;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var array
     */
    private $retrievers;

    /**
     * HreflangService constructor.
     * @param HttpRequest $request
     * @param StoreManagerInterface $storeManager
     * @param array $retrievers
     */
    public function __construct(
        HttpRequest $request,
        StoreManagerInterface $storeManager,
        array $retrievers
    ) {
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->retrievers = $retrievers;
    }

    /**
     * @param $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAlternativeUrl($store)
    {
        foreach ($this->retrievers as $path => $retriever) {
            if ($this->request->getFullActionName() === $path) {
                if ($retriever !== false) {
                    return $retriever->getUrl($this->request->getParam('id'), $store);
                } else {
                    return $this->storeManager->getStore($store->getId())->getBaseUrl();
                }
            }
        }
        return '';
    }
}
