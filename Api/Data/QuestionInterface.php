<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Api\Data;

/**
 * Interface QuestionInterface
 *
 * @api
 * @since 1.0.0
 */
interface QuestionInterface
{
    public const ID = 'id';
    public const QUESTION = 'question';
    public const ANSWER = 'answer';
    public const POSITION = 'position';
    public const ACTIVE = 'active';
    public const STORE_IDS = 'store_ids';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getQuestion(): string;

    /**
     * @param string $question
     *
     * @return QuestionInterface
     */
    public function setQuestion(string $question): QuestionInterface;

    /**
     * @return string|null
     */
    public function getAnswer(): ?string;

    /**
     * @param string|null $answer
     *
     * @return QuestionInterface
     */
    public function setAnswer(?string $answer): QuestionInterface;

    /**
     * @return int
     */
    public function getPosition(): int;

    /**
     * @param int|null $position
     *
     * @return QuestionInterface
     */
    public function setPosition(?int $position): QuestionInterface;

    /**
     * @return array
     */
    public function getStoreIds(): array;

    /**
     * @param array $storeIds
     *
     * @return QuestionInterface
     */
    public function setStoreIds(array $storeIds): QuestionInterface;

    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @param bool $active
     *
     * @return QuestionInterface
     */
    public function setActive(bool $active): QuestionInterface;

    /**
     * @param string $createdAt
     *
     * @return QuestionInterface
     */
    public function setCreatedAt(string $createdAt): QuestionInterface;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $updatedAt
     *
     * @return QuestionInterface
     */
    public function setUpdatedAt(string $updatedAt): QuestionInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;
}
