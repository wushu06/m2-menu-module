<?php

namespace Tbb\Menu\Repository;

use Tbb\Menu\Api\Data\MenuInterface;
use Tbb\Menu\Api\Repository\MenuRepositoryInterface;
use Tbb\Menu\Model\Menu;
use Tbb\Menu\Model\ResourceModel\Menu\CollectionFactory;
use Tbb\Menu\Api\Data\MenuInterfaceFactory;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\Exception\InputException;

class MenuRepository implements MenuRepositoryInterface
{
    /**
     * @var MenuInterfaceFactory
     */
    private $factory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var TagRepositoryInterface
     */
    private $tagRepository;

    /**
     * @var CatRepositoryInterface
     */
    private $catRepository;

    /**
     * @var FilterManager
     */
    private $filterManager;

    public function __construct(
        MenuInterfaceFactory $factory,
        CollectionFactory $collectionFactory

    ) {
        $this->factory           = $factory;
        $this->collectionFactory = $collectionFactory;

    }

    /**
     * {@inheritdoc}
     */
    public function getCollection()
    {
        return $this->collectionFactory->create();
    }


    /**
     * @inheritdoc
     */
    public function getList()
    {
        /** @var \Tbb\Menu\Model\ResourceModel\Menu\Collection $collection */
        $collection = $this->getCollection();
        return $collection->getItems();
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return $this->factory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        /** @var Menu $menu */
        $menu = $this->create();

        $menu->getResource()->load($menu, $id);

        if ($menu->getId()) {
            return $menu;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, MenuInterface $menu)
    {
        /** @var Menu $model */
        $model = $this->create();
        $model->getResource()->load($model, $id);

        if (!$model->getId()) {
            throw new InputException(__("The menu doesn't exist."));
        }

        $json = json_decode(file_get_contents("php://input"));

        foreach ($json->menu as $k => $v) {
            $model->setData($k, $menu->getData($k));
        }

        $model->getResource()->save($model);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function apiDelete($id)
    {
        /** @var Menu $menu */
        $menu = $this->create();
        $menu->getResource()->load($menu, $id);

        if (!$menu->getId()) {
            throw new InputException(__("The menu doesn't exist."));
        }

        $menu->getResource()->delete($menu);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(MenuInterface $model)
    {
        /** @var Menu $model */
        return $model->getResource()->delete($model);
    }

    /**
     * {@inheritdoc}
     */
    public function save(MenuInterface $model)
    {
        /*if (!$model->getType()) {
            $model->setType(MenuInterface::TYPE);
        }*/


        /** @var Menu $model */
        $model->getResource()->save($model);

        return $model;
    }

}