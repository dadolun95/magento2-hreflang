<?php

namespace Dadolun\Hreflang\ViewModel;

use Dadolun\Hreflang\Model\Retriever\HreflangService;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class Hreflang
 * @package Dadolun\Hreflang\ViewModel
 */
class Hreflang implements ArgumentInterface
{
    /**
     * @var HreflangService
     */
    private $alternativeUrlService;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * Hreflang constructor.
     * @param HreflangService $alternativeUrlService
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     */
    public function __construct(
        HreflangService $alternativeUrlService,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer
    ) {
        $this->alternativeUrlService = $alternativeUrlService;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAlternativeUrls()
    {
        $data = [];
        foreach ($this->getStores() as $store) {
            $url = $this->getStoreUrl($store);
            if ($url) {
                if (!is_array($this->getLocaleCode($store))) {
                    $data[$this->getLocaleCode($store)] = $url;
                } else {
                    foreach($this->getLocaleCode($store) as $localeCode) {
                        $data[$localeCode] = $url;
                    }
                }
            }
        }
        return $data;
    }

    /**
     * @param $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getStoreUrl($store)
    {
        return $this->alternativeUrlService->getAlternativeUrl($store);
    }

    /**
     * @param $store
     * @return array|string|string[]
     */
    private function getLocaleCode($store)
    {
        if ($this->scopeConfig->getValue('dadolun_hreflang/general/locale_code', 'stores', $store->getId()) === null) {
            $localeCode = $this->scopeConfig->getValue('general/locale/code', 'stores', $store->getId());
        } else {
            $locales = [];
            $localeCode = $this->serializer->unserialize($this->scopeConfig->getValue('dadolun_hreflang/general/locale_code', 'stores', $store->getId()));
            foreach ($localeCode as $localeCodeData) {
                $locales[] = str_replace('_', '-', strtolower($localeCodeData["locale_code"]));;
            }
            return $locales;
        }
        return str_replace('_', '-', strtolower($localeCode));
    }

    /**
     * @return StoreInterface[]
     */
    private function getStores()
    {
        return $this->storeManager->getStores();
    }
}
