<?php

namespace Tbb\Menu\Model;

use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface as MagentoUrlInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{



    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var MagentoUrlInterface
     */
    protected $urlManager;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Filesystem $filesystem
     * @param MagentoUrlInterface $urlManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        MagentoUrlInterface $urlManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->urlManager = $urlManager;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->urlManager->getUrl($this->getBaseRoute());
    }


    /**
     * @return string
     */
    public function getDefaultSortField()
    {
        return 'created_at';
    }


}
