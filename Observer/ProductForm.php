<?php

declare(strict_types=1);

namespace Pointeger\AttributeLock\Observer;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class ProductForm
 * @package Pointeger\AttributeLock\Observer
 */
class ProductForm implements ObserverInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Lock constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        $product = $event->getProduct();
        $attributeCollection = $this->collectionFactory->create()->addFieldToFilter('edit_lock', 1);
        foreach ($attributeCollection->getItems() as $item) {
            $product->lockAttribute($item->getAttributeCode());
        }
    }
}


