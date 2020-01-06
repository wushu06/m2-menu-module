<?php

namespace Tbb\Menu\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    protected $categoryFactory;
    protected $menuRepository;
    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Request\Http $request,
        \Tbb\Menu\Api\Repository\MenuRepositoryInterface $menuRepository,
        \Tbb\Data\Helper\Categories\CategoriesData $categoryFactory
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->categoryRepository = $categoryRepository;
        $this->menuRepository = $menuRepository;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }


    /**
     * @param $page
     * @return string
     */
	public function getPageUrl($page) {
		return $this->_urlBuilder->getUrl(null, ['_direct' => $page->getIdentifier()]);
	}

    /**
     * @param $menu
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
	public function getLinkUrl($menu) {
		$link = '#';
		switch ($menu['url_type']) {
			case 1:
				if($menu['custom_link'] != '') $link = $this->storeManager->getStore()->getUrl($menu['custom_link']);
				break;
			
			case 0:
				if($menu['category_id'] != '' && $menu['category_id'] > 0) {
				    if( $this->categoryFactory->create()->load($menu['category_id'])->getId()) {
                        $category = $this->categoryRepository->get($menu['category_id'], $this->storeManager->getStore()->getId());
                        $link = $category->getUrl();
                    }else{
                        $link = '';
                    }

				}
		}
		return $link;
	}




    public function getMenuCollection()
    {

        $collection = $this->menuRepository->getCollection()
            ->addAttributeToSelect([
                'name', 'status', 'type', 'url_key', 'parent_id', 'visibility', 'class_name'
            ]);

        return  $collection;


    }

    public function getMenuCollectionById($id)
    {


        $collection = $this->menuRepository->getCollection()
            ->addAttributeToSelect([
                'name', 'status', 'type', 'url_key', 'parent_id', 'visibility', 'class_name'
            ])->addAttributeToFilter('parent_id', array('eq'=>$id))
            ->addAttributeToFilter('entity_id', array('neq'=>$id));

        return $collection;

    }

    public function getCategoryUrlById($id)
    {
        $categoryCollection = $this->categoryFactory->getCategoryCollectionById((int)$id);
        foreach ($categoryCollection as $category) {
            return $category->getUrl();
        }


    }

    /**
     * @param string $nameInLayout
     */
    public function getMenuData($json = true)
    {
        $collection = $this->getMenuCollection();
        $menus = [];
        foreach ($collection as $menu) {

            if ($menu->getName() && ($menu->getId() == $menu->getParentId() || $menu->getParentId() == 0)) :
                if ($menu->getType() == 'category') {
                    $url = $this->getCategoryUrlById($menu->getUrlKey());
                    $cat = $menu->getUrlKey();
                } else {
                    $url = $menu->getUrlKey();
                    $cat = '';
                }
                $menus[$menu->getId()]['parent'] = [
                    'id' => $menu->getId(),
                    'name' => $menu->getName(),
                    'url' => $url,
                    'status' => $menu->getStatus(),
                    'type' => $menu->getType(),
                    'cat' => $cat,
                    'visiblity' => $menu->getVisibility(),
                    'class_name' => $menu->getClassName()
                ];
                if(!empty($this->getMenuChildren( $menu->getId() )) ){
                    $menus[$menu->getId()]['children'] = $this->getMenuChildren( $menu->getId() );
                }


            endif;
        }
        return $json ? json_encode($menus) : $menus;
    }

    public function getMenuChildren($id)
    {
        $menus = [];
        $childCollection = $this->getMenuCollectionById($id);
        foreach ($childCollection as $child) {

            if ($child->getName()) :
                if ($child->getType() == 'category') {
                    $url = $this->getCategoryUrlById($child->getUrlKey());
                    $cat = $child->getUrlKey();
                } else {
                    $url = $child->getUrlKey();
                    $cat = '';
                }
                $menus[$child->getId()] = [
                    'id' => $child->getId(),
                    'name' => $child->getName(),
                    'url' => $url,
                    'status' => $child->getStatus(),
                    'type' => $child->getType(),
                    'cat' => $cat,
                    'visiblity' => $child->getVisibility(),
                    'class_name' => $child->getClassName()
                ];
            endif;
            if(!empty($this->getMenuChildren( $child->getId() )) ){
                $menus[$child->getId()]['children'] = $this->getMenuChildren( $child->getId() );

            }

        }
        return $menus;
    }
}
