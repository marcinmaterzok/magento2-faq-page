<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface QuestionSearchResultInterface
 */
interface QuestionSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get customers list.
     *
     * @return QuestionInterface[]
     */
    public function getItems(): array;

    /**
     * Set customers list.
     *
     * @param QuestionInterface[] $items
     *
     * @return QuestionSearchResultInterface
     */
    public function setItems(array $items): self;
}
