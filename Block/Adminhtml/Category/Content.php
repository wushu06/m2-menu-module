<?php

namespace Tbb\Menu\Block\Adminhtml\Category;


class Content extends \Magento\Framework\View\Element\Template
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
     * @var \Magento\Cms\Model\ResourceModel\Block\CollectionFactory
     */
    protected $blockColFactory;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Magento\Catalog\Model\Indexer\Category\Flat\State
     */
    protected $categoryFlatConfig;
    protected $collection;
    protected $menuRepository;
    protected $_cmsPage;
    protected $_search;

    /**
     * Content constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Model\UrlInterface $urlBuilder
     * @param \Tbb\Menu\Model\MenuFactory $modelMenuFactory
     * @param \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockColFactory
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\UrlInterface $urlBuilder,
        \Tbb\Menu\Model\MenuFactory $modelMenuFactory,
        \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockColFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Tbb\Menu\Api\Repository\MenuRepositoryInterface $menuRepository,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,

        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory  $categoryFactory
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->modelMenuFactory = $modelMenuFactory;
        $this->resource = $resource;
        $this->blockColFactory = $blockColFactory;
        $this->categoryFactory = $categoryFactory;
        $this->categoryFlatConfig = $categoryFlatState;
        $this->menuRepository = $menuRepository;
        $this->_cmsPage = $pageRepository;
        $this->_search = $searchCriteriaBuilder;
        parent::__construct($context);
    }
    protected function _beforeToHtml()
    {


        // called prepare sortable parameters
        $collection = $this->getMenuCollection();

        $this->getMenuCollection()->load();

        return parent::_beforeToHtml();
    }
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }
    /**
     * @return string
     */
    public function getBlockCollection()
    {
        $blocks = $this->blockColFactory->create();

        return json_encode($blocks->getData());
    }

    /**
     * @return string
     */
    public function getCategoryCollection() {
        $storeId = $this->getRequest()->getParam('store');

        if ($storeId == null) {
            $storeId = 0;
        }

        $collection = $this->categoryFactory->create();
        $collection->addAttributeToSelect("*");



        return $collection;


    }


    public function getCategoryCollectionJson()
    {
        $data = [];

        foreach ($this->getCategoryCollection() as $category){
            $data[] = [ 'id' => $category->getId() , 'title' => $category->getName()];
            if($category->hasChildren()){
                $subcategories = $category->getChildrenCategories();
                //foreach($subcategories as $subcategorie) {
                //   $data[$category->getId() ][$subcategorie->getId()] = ['id' => $subcategorie->getId(), 'title' => $subcategorie->getName()];
                //}
            }

        }
        return json_encode($data);

    }
    /**
     * @param $category
     * @param array $data
     * @param int $level
     * @return array
     */
    public function getChildCategories($category, $data = [], $level = 0)
    {
        if($level != 0) {
            $data[] = [ 'id' => $category->getId() , 'title' => str_repeat('-', $level - 1) . ' ' . $category->getName()];
        }

        if ($category->hasChildren()) {
            $childCategories = $category->getChildrenCategories();
            $level++;
            foreach ($childCategories as $childCategory) {
                $data = $this->getChildCategories($childCategory, $data, $level);
            }
        }
        return $data;
    }

    public function getMenuCollection()
    {


        if (empty($this->collection)) {
            $collection = $this->menuRepository->getCollection()
                ->addAttributeToSelect([
                    'name', 'status', 'type', 'url_key',
                ]);

            $this->collection = $collection;

        }

        return $this->collection;
    }

    public function toOptionArray()
    {
        $pages = [];
        foreach($this->_cmsPage->getList($this->_getSearchCriteria())->getItems() as $page) {
            $pages[] = [
                'value' => $page->getIdentifier(),
                'label' => $page->getTitle()
            ];
        }
        return json_encode($pages);
    }
    public function getMenuItemUrl($type)
    {
        return $this->urlBuilder->getUrl('tbbmenu/item/edit', $paramsHere = ['type' => $type]);
    }


    protected function _getSearchCriteria()
    {
        return $this->_search->addFilter('is_active', '1')->create();
    }
}

