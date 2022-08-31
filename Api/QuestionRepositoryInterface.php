<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Api;

use Mtrzk\FaqPage\Api\Data\QuestionInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface QuestionRepositoryInterface
 *
 * @api
 * @since 1.0.0
 */
interface QuestionRepositoryInterface
{
    /**
     * @param QuestionInterface $question
     *
     * @return QuestionInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $question): QuestionInterface;

    /**
     * @param int $id
     *
     * @return QuestionInterface
     *
     * @throws NoSuchEntityException
     */
    public function getById(int $id): QuestionInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * @param mixed $id
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function delete($id): bool;

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool;
}
