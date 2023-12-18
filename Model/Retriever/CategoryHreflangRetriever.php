<?php

namespace Dadolun\Hreflang\Model\Retriever;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;
use Magento\Store\Model\Store;
use Dadolun\Hreflang\Api\HreflangRetrieverInterface;

/**
 * Class CategoryHreflangRetriever
 * @package Dadolun\Hreflang\Model\Retriever
 */
class CategoryHreflangRetriever implements HreflangRetrieverInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CategoryUrlPathGenerator
     */
    private $categoryUrlPathGenerator;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryUrlPathGenerator $categoryUrlPathGenerator,
        \Magento\Framework\Registry $registry
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryUrlPathGenerator = $categoryUrlPathGenerator;
        $this->registry = $registry;
    }

    /**
     * @param int|string $identifier
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store)
    {
        try {
            /** @var Category $category */
            $category = $this->registry->registry('category');
            if (!$category) {
                $category = $this->categoryRepository->get($identifier, $store->getId());
            }
            $path = $this->categoryUrlPathGenerator->getUrlPathWithSuffix($category);
            return $store->getBaseUrl() . $path;
        } catch (\Exception $e) {
            return "";
        }
    }
}
