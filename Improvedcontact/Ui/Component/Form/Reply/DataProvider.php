<?php

declare(strict_types=1);

namespace Sapiha\Improvedcontact\Ui\Component\Form\Reply;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Sapiha\Improvedcontact\Model\Contact;
use Sapiha\Improvedcontact\Model\ResourceModel\Contact\Collection;
use Sapiha\Improvedcontact\Model\ResourceModel\Contact\CollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends ModifierPoolDataProvider
{
    /** @var Collection */
    protected $collection;

    /** @var DataPersistorInterface  */
    protected $dataPersistor;

    /** @var array */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->addFieldToSelect(['id', 'email'])->getItems();
        /** @var Contact $item */
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
        }

        $data = $this->dataPersistor->get('improvedcontact');
        if (!empty($data)) {
            $item = $this->collection->getNewEmptyItem();
            $item->setData($data);
            $this->loadedData[$item->getId()] = $item->getData();
            $this->dataPersistor->clear('improvedcontact');
        }

        return $this->loadedData;
    }
}
