<?php

declare(strict_types=1);

namespace Sapiha\Improvedcontact\Ui\Component\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
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

    /** @var DataPersistorInterface */
    protected $dataPersistor;

    /** @var array */
    protected $loadedData;
    /** @var RequestInterface */
    private $request;

    /** @var UrlInterface */
    private $urlBuilder;

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
        RequestInterface $request,
        UrlInterface $urlBuilder,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;

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
        $items = $this->collection->getItems();
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

    public function getMeta()
    {
        $meta = parent::getMeta();
        $newMeta = [
            'general' => [
                'children' => [
                    'reply_form_modal' => [
                        'children' => [
                            'reply_form_loader' => [
                                'arguments' => [
                                    'data' => [
                                        'config' => [
                                            'render_url' => $this->getRenderUrl(),
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ];

        return array_merge_recursive($meta, $newMeta);
    }

    /**
     * @return string
     */
    private function getRenderUrl(): string
    {
        return $this->urlBuilder->getUrl(
            'mui/index/render_handle',
            [
                'handle' => 'improvedcontact_improvedcontact_reply',
                'buttons' => '1',
                'id' => $this->request->getParam('id'),
            ]
        );
    }

}
