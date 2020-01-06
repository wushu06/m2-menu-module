<?php

namespace Tbb\Menu\Model;

use Magento\Framework\Image as MagentoImage;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Store\Model\StoreManagerInterface;
use Tbb\Menu\Api\Data\MenuInterface;
/**
 * @method string getFeaturedShowOnHome()


 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Menu extends AbstractExtensibleModel implements  MenuInterface
{
    const ENTITY = 'tbb_menu';
    const CACHE_TAG = 'tbb_menu';

    /**
     * @var MagentoImage
     */
    protected $_processor;

    /**
     * @var Url
     */
    protected $url;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;


    /**
     * @var Config
     */
    protected $config;

    public function __construct(
        Config $config,
        StoreManagerInterface $storeManager,
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory
    ) {
        $this->config = $config;
        $this->storeManager = $storeManager;

        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Tbb\Menu\Model\ResourceModel\Menu');
    }


    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * {@inheritdoc}
     */
    public function setType($value)
    {
        return $this->setData(self::TYPE, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($value)
    {
        return $this->setData(self::STATUS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getVisibility()
    {
        return $this->getData(self::VISIBILITY);
    }

    /**
     * {@inheritdoc}
     */
    public function setVisibility($value)
    {
        return $this->setData(self::VISIBILITY, $value);
    }




    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setName($value)
    {
        return $this->setData(self::NAME, $value);
    }


    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return $this->getData(self::CLASS_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setClassName($value)
    {
        return $this->setData(self::CLASS_NAME, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getParentId()
    {
        return $this->getData(self::PARENTID);
    }

    /**
     * {@inheritdoc}
     */
    public function setParentId($value)
    {
        return $this->setData(self::PARENTID, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function setUrlKey($value)
    {
        return $this->setData(self::URL_KEY, $value);
    }



    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($value)
    {
        return $this->setData(self::CREATED_AT, $value);
    }


    /**
     * {@inheritdoc}
     */
    public function getStoreIds()
    {
        return $this->getData(self::STORE_IDS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreIds(array $value)
    {
        return $this->setData(self::STORE_IDS, $value);
    }



    /**
     * @param bool $useSid
     * @return string
     */
    public function getUrl($useSid = true)
    {
       // return $this->url->getMenuUrl($this, $useSid);
    }


}