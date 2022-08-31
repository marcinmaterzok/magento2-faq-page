<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Model;

use Exception;
use Mtrzk\FaqPage\Api\Data\QuestionInterface;
use Mtrzk\FaqPage\Api\Data\QuestionInterfaceFactory;
use Mtrzk\FaqPage\Api\Data\QuestionSearchResultInterfaceFactory;
use Mtrzk\FaqPage\Api\QuestionRepositoryInterface;
use Mtrzk\FaqPage\Model\Question as QuestionModel;
use Mtrzk\FaqPage\Model\ResourceModel\Question;
use Mtrzk\FaqPage\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class QuestionRepository implements QuestionRepositoryInterface
{
    /** @var array */
    private array $questionById;

    /** @var Question */
    private Question $questionResourceModel;

    /** @var QuestionSearchResultInterfaceFactory */
    private QuestionSearchResultInterfaceFactory $searchResultsFactory;

    /** @var QuestionInterfaceFactory */
    private QuestionInterfaceFactory $questionFactory;

    /** @var CollectionProcessorInterface */
    private CollectionProcessorInterface $collectionProcessor;

    /** @var QuestionCollectionFactory */
    private QuestionCollectionFactory $questionCollectionFactory;

    /**
     * @param Question                             $questionResourceModel
     * @param QuestionSearchResultInterfaceFactory $searchResultsFactory
     * @param QuestionInterfaceFactory             $questionFactory
     * @param QuestionCollectionFactory            $questionCollectionFactory
     * @param CollectionProcessorInterface         $collectionProcessor
     */
    public function __construct(
        Question                             $questionResourceModel,
        QuestionSearchResultInterfaceFactory $searchResultsFactory,
        QuestionInterfaceFactory             $questionFactory,
        QuestionCollectionFactory            $questionCollectionFactory,
        CollectionProcessorInterface         $collectionProcessor
    ) {
        $this->questionResourceModel     = $questionResourceModel;
        $this->searchResultsFactory      = $searchResultsFactory;
        $this->questionFactory           = $questionFactory;
        $this->collectionProcessor       = $collectionProcessor;
        $this->questionCollectionFactory = $questionCollectionFactory;
    }

    /**
     * @param QuestionInterface $model
     *
     * @return QuestionInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $model): QuestionInterface
    {
        try {
            /** @phpstan-ignore-next-line */
            $this->questionResourceModel->save($model);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $model;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection    = $this->questionCollectionFactory->create();
        $searchResults = $this->searchResultsFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults->setSearchCriteria($searchCriteria);

        /** @phpstan-ignore-next-line */
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     * @throws LocalizedException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     */
    public function delete($id): bool
    {
        try {
            $model = $this->getById((int) $id);
            /** @phpstan-ignore-next-line */
            $this->questionResourceModel->delete($model);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        unset($this->questionById[$id]);

        return true;
    }

    /**
     * @param int $id
     *
     * @return QuestionInterface
     *
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getById(int $id): QuestionInterface
    {
        if (isset($this->questionById[$id])) {
            return $this->questionById[$id];
        }

        /** @var QuestionModel $model */
        $model = $this->questionFactory->create();
        /** @phpstan-ignore-next-line */
        $this->questionResourceModel->load($model, $id);

        if (!$model->getId()) {
            throw NoSuchEntityException::singleField($this->questionResourceModel->getIdFieldName(), $id);
        }

        $this->questionById[$id] = $model;

        return $model;
    }
}
