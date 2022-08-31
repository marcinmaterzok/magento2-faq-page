<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Block\Faq;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Mtrzk\FaqPage\Api\Data\QuestionInterface;
use Mtrzk\FaqPage\Model\ResourceModel\Question\CollectionFactory;
use Mtrzk\FaqPage\Model\ResourceModel\Question\Collection;

class FaqPage extends Template
{
    public const ALL_STORE_VIEWS = 0;

    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private CollectionFactory $collectionFactory;
    private StoreManagerInterface $storeManager;

    /**
     * @param Context               $context
     * @param CollectionFactory     $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array                 $data
     */
    public function __construct(
        Template\Context      $context,
        CollectionFactory     $collectionFactory,
        StoreManagerInterface $storeManager,
        array                 $data = []
    ) {
        parent::__construct($context, $data);

        $this->storeManager      = $storeManager;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param bool $onlyActive
     *
     * @return QuestionInterface[]
     */
    public function getFaqQuestions($onlyActive = true): array {

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        if ($onlyActive) {
            $collection->addFieldToFilter(QuestionInterface::ACTIVE, '1');
        }

        $collection->addFieldToFilter(
            QuestionInterface::STORE_IDS,
            [
                ['finset' => self::ALL_STORE_VIEWS],
                ['finset' => $this->getCurrentStoreId()],
            ]
        );

        $collection->setOrder('position','ASC');

        return $collection->getItems();
    }

    /**
     * @return int
     */
    private function getCurrentStoreId(): int
    {
        try {
            return (int) $this->storeManager->getStore()->getId();
        } catch (NoSuchEntityException $e) {
            return 0;
        }
    }
}
