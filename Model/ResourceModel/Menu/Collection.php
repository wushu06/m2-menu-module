<?php

namespace Tbb\Menu\Model\ResourceModel\Menu;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Tbb\Menu\Api\Data\MenuInterface;
use Tbb\Menu\Model\Post;
use Tbb\Menu\Model\Post\Attribute\Source\Status;

class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Tbb\Menu\Model\Menu', 'Tbb\Menu\Model\ResourceModel\Menu');
    }


}