<?php

namespace Dadolun\Hreflang\Model\Retriever;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\ResourceModel\Page as PageResource;
use Magento\CmsUrlRewrite\Model\CmsPageUrlPathGenerator;
use Magento\Store\Model\Store;
use Dadolun\Hreflang\Api\HreflangRetrieverInterface;

/**
 * Class CmsPageHreflangRetriever
 * @package Dadolun\Hreflang\Model\Retriever
 */
class CmsPageHreflangRetriever implements HreflangRetrieverInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var CmsPageUrlPathGenerator
     */
    private $cmsPageUrlPathGenerator;

    /**
     * @var PageResource
     */
    private $pageResource;

    /**
     * CmsPageHreflangRetriever constructor.
     * @param PageRepositoryInterface $pageRepository
     * @param CmsPageUrlPathGenerator $cmsPageUrlPathGenerator
     * @param PageResource $pageResource
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        CmsPageUrlPathGenerator $cmsPageUrlPathGenerator,
        PageResource $pageResource
    ) {
        $this->pageRepository = $pageRepository;
        $this->cmsPageUrlPathGenerator = $cmsPageUrlPathGenerator;
        $this->pageResource = $pageResource;
    }

    /**
     * @param int $identifier
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store)
    {
        try {
            $page = $this->pageRepository->getById($identifier);
            $pageId = $this->pageResource->checkIdentifier($page->getIdentifier(), $store->getId());
            $storePage = $this->pageRepository->getById($pageId);
            $path = $this->cmsPageUrlPathGenerator->getUrlPath($storePage);
            return $store->getBaseUrl() . $path;
        } catch (\Exception $e) {
            return "";
        }
    }
}
