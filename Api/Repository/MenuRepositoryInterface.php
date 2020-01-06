<?php

namespace Tbb\Menu\Api\Repository;

interface MenuRepositoryInterface
{
    /**
     * @return \Mirasvit\Blog\Model\ResourceModel\Post\Collection | \Mirasvit\Blog\Api\Data\PostInterface[]
     */
    public function getCollection();

    /**
     * @return \Mirasvit\Blog\Api\Data\PostInterface
     */
    public function create();

    /**
     * @param \Mirasvit\Blog\Api\Data\PostInterface $model
     * @return \Mirasvit\Blog\Api\Data\PostInterface
     */
    public function save(\Tbb\Menu\Api\Data\MenuInterface $model);

    /**
     * @return \Mirasvit\Blog\Api\Data\PostInterface[]
     */
    public function getList();

    /**
     * @param int $id
     * @return \Mirasvit\Blog\Api\Data\PostInterface|false
     */
    public function get($id);

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     */
    public function apiDelete($id);
    /**
     * @param int $id
     * @param \Mirasvit\Blog\Api\Data\PostInterface $post
     * @return \Mirasvit\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\StateException
     */
    public function update($id, \Tbb\Menu\Api\Data\MenuInterface $menu);

    /**
     * @param \Mirasvit\Blog\Api\Data\PostInterface $model
     * @return bool
     */
    public function delete(\Tbb\Menu\Api\Data\MenuInterface $model);
}