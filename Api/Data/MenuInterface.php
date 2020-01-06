<?php

namespace Tbb\Menu\Api\Data;

interface MenuInterface
{
    const ID = 'entity_id';
    const NAME = 'name';
    const CLASS_NAME = 'class_name';
    const TYPE = 'type';
    const STATUS = 'status';
    const VISIBILITY = 'visibility';
    const URL_KEY = 'url_key';
    CONST PARENTID = 'parent_id';
    const CREATED_AT = 'created_at';
    const STORE_IDS = 'store_ids';
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    const STATUS_HIDDEN = 0;
    const STATUS_VISIBLE = 1;

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $value
     * @return $this
     */
    public function setType($value);

    /**
     * @return string
     */
    public function getStatus();
    /**
     * @return string
     */
    public function getVisibility();

    /**
     * @param string $value
     * @return $this
     */
    public function setStatus($value);

    /**
     * @param string $value
     * @return $this
     */
    public function setVisibility($value);



    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getClassName();

    /**
     * @param string $value
     * @return $this
     */
    public function setName($value);
    /**
     * @param string $value
     * @return $this
     */
    public function setClassName($value);

    /**
     * @return string
     */
    public function getParentId();

    /**
     * @param string $value
     * @return $this
     */
    public function setParentId($value);


    /**
     * @return string
     */
    public function getUrlKey();

    /**
     * @param string $value
     * @return $this
     */
    public function setUrlKey($value);


    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $value
     * @return $this
     */
    public function setCreatedAt($value);


    /**
     * @return mixed
     */
    public function getStoreIds();

    /**
     * @param mixed $value
     * @return $this
     */
    public function setStoreIds(array $value);


}