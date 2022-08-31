<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Ui\Component\Question\Form;

use Mtrzk\FaqPage\Model\Question;
use Mtrzk\FaqPage\Model\ResourceModel\Question\Collection;
use Mtrzk\FaqPage\Model\ResourceModel\Question\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{
    /** @var Collection */
    protected $collection;

    /** @var DataPersistorInterface */
    private DataPersistorInterface $dataPersistor;

    /** @var array */
    private array $loadedData;

    /**
     * @param string                 $name
     * @param string                 $primaryFieldName
     * @param string                 $requestFieldName
     * @param CollectionFactory      $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array                  $meta
     * @param array                  $data
     * @param PoolInterface|null     $pool
     */
    public function __construct(
        string                 $name,
        string                 $primaryFieldName,
        string                 $requestFieldName,
        CollectionFactory      $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array                  $meta = [],
        array                  $data = [],
        PoolInterface          $pool = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);

        $this->collection        = $collectionFactory->create();
        $this->dataPersistor     = $dataPersistor;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $this->loadedData = [];
        $items            = $this->collection->getItems();

        foreach ($items as $faq) {
            $this->loadedData[$faq->getId()] = $faq->getData();
        }

        $data = $this->dataPersistor->get(Question::DATA_PERSISTOR_KEY);

        if (!empty($data)) {
            $faqs = $this->collection->getNewEmptyItem();
            $faqs->setData($data);
            $this->loadedData[$faqs->getId()] = $faqs->getData();
            $this->dataPersistor->clear(Question::DATA_PERSISTOR_KEY);
        }

        return $this->loadedData;
    }
}
