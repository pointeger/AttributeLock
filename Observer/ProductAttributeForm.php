<?php

declare(strict_types=1);

namespace Pointeger\AttributeLock\Observer;

use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class ProductAttributeForm
 * @package Pointeger\AttributeLock\Observer
 */
class ProductAttributeForm implements ObserverInterface
{
    /**
     * @var Yesno
     */
    protected $yesNo;

    /**
     * ProductAttributeForm constructor.
     * @param Yesno $yesno
     */
    public function __construct(Yesno $yesno)
    {
        $this->yesNo = $yesno;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $yesno = $this->yesNo->toOptionArray();

        $form = $observer->getData('form');
        $advancedFieldset = $form->getElements()->searchById('advanced_fieldset');
        $advancedFieldset->addField(
            'edit_lock',
            'select',
            [
                'name' => 'edit_lock',
                'label' => __('Read Only'),
                'note' => __(
                    'Select "Yes" to set this attribute to "Read Only" on the product edit page.'
                ),
                'values' => $yesno,
                'sortOrder' => 210
            ]
        );
        return $this;
    }
}
