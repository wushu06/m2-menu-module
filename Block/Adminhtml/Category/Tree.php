<?php

namespace Tbb\Menu\Block\Adminhtml\Category;

class Tree extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Tbb\Menu\Model\MenuFactory
     */
    protected $modelMenuFactory;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    protected $jsonHelper;

    /**
     * @var \Tbb\Menu\Model\ConfigFactory
     */
    protected $configFactory;
    protected $menuRepository;
    protected $categoryFactory;
    protected $helperData;
    /**
     * Tree constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Model\UrlInterface $urlBuilder
     * @param \Tbb\Menu\Model\MenuFactory $modelMenuFactory
     * @param \Tbb\Menu\Model\ConfigFactory $configFactory
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeInterface
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\UrlInterface $urlBuilder,
        \Tbb\Menu\Model\MenuFactory $modelMenuFactory,
        \Tbb\Menu\Model\ConfigFactory $configFactory,
        \Tbb\Menu\Helper\Data $helperData,
        \Tbb\Menu\Api\Repository\MenuRepositoryInterface $menuRepository,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\App\ResourceConnection $resource,
        \Tbb\Data\Helper\Categories\CategoriesData  $categoryFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeInterface
        ) {
        $this->configFactory = $configFactory;
        $this->urlBuilder = $urlBuilder;
        $this->modelMenuFactory = $modelMenuFactory;
        $this->resource = $resource;
        $this->scopeConfig = $scopeInterface;
        $this->menuRepository = $menuRepository;
        $this->jsonHelper = $jsonHelper;
        $this->categoryFactory = $categoryFactory;
        $this->helperData = $helperData;
        parent::__construct($context);
    }




    /**
     * @param $type
     * @return string
     */
    public function getMenuItemUrl($type)
    {
        return $this->urlBuilder->getUrl('tbbmenu/item/edit', $paramsHere = ['type' => $type]);
    }






    /**
     * @param string $nameInLayout
     */
    public function getMenuData($json = true)
    {
        return $this->helperData->getMenuData($json);
    }


}
