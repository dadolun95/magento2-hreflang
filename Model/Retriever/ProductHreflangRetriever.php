<?php

namespace Dadolun\Hreflang\Model\Retriever;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\Store;
use Dadolun\Hreflang\Api\HreflangRetrieverInterface;

/**
 * Class ProductHreflangRetriever
 * @package Dadolun\Hreflang\Model\Retriever
 */
class ProductHreflangRetriever implements HreflangRetrieverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @param int|string $identifier
     * @param Store $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getUrl($identifier, $store)
    {
        try {
            $product = $this->productRepository->getById($identifier, false, $store->getId());
            return $product->setStoreId($store->getId())->getUrlModel()->getUrlInStore($product, ['_escape' => true]);
        } catch (\Exception $e) {
            return "";
        }
    }
}
