<?php
namespace Dadolun\Hreflang\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class LocaleCode
 * @package Dadolun\Hreflang\Block\Adminhtml\Form\Field
 */
class LocaleCode extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn(
            'locale_code',
            [
                'label' => __('Locale code'),
                'class' => 'required-entry'
            ]
        );

        // do not add after button
        $this->_addAfter = false;

        // set button label
        $this->_addButtonLabel = __('Add new Locale code');
    }
}
