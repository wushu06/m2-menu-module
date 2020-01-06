<?php
namespace Tbb\Menu\Model\Post\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

class Visibility extends AbstractSource implements SourceInterface, OptionSourceInterface
{
    const STATUS_HIDDEN = 0;


    const STATUS_VISIBLE = 1;

    /**
     * Retrieve Visible Status Ids
     *
     * @return int[]
     */
    public function getVisibleIds()
    {
        return [self::STATUS_VISIBLE];
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        return [
            self::STATUS_HIDDEN    => __('Hidden'),
            self::STATUS_VISIBLE     => __('Visible')
        ];
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }
}
