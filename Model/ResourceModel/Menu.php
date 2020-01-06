<?php

namespace Tbb\Menu\Model\ResourceModel;

use Magento\Framework\DataObject;
use Magento\Eav\Model\Entity\AbstractEntity;
use Magento\Eav\Model\Entity\Context;
use Tbb\Menu\Api\Data\MenuInterface;
use Tbb\Menu\Model\Config;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\File\Uploader as FileUploader;

class Menu extends AbstractEntity
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var FilterManager
     */
    protected $filter;



    public function __construct(
        Config $config,
        FilterManager $filter,
        Context $context,
        $data = []
    ) {
        $this->config = $config;
        $this->filter = $filter;

        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityType()
    {
       if (empty($this->_type)) {
            $this->setType(\Tbb\Menu\Model\Menu::ENTITY);
        }

        return parent::getEntityType();
    }




}