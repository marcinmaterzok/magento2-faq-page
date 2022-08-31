<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Model;

use Mtrzk\FaqPage\Api\Data\QuestionInterface;
use Mtrzk\FaqPage\Model\ResourceModel\Question as ResourceModelQuestion;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements QuestionInterface, IdentityInterface
{
    public const DATA_PERSISTOR_KEY = 'Mtrzk_FaqPage_question';

    const CACHE_TAG = 'mtrzk_faqpage_question';

    protected $_cacheTag = 'mtrzk_faqpage_question';

    protected $_eventPrefix = 'mtrzk_faqpage_question';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModelQuestion::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->_getData(self::QUESTION);
    }

    /**
     * @param string $question
     *
     * @return QuestionInterface
     */
    public function setQuestion(string $question): QuestionInterface
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * @param string $createdAt
     *
     * @return QuestionInterface
     */
    public function setCreatedAt(string $createdAt): QuestionInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @param string $updatedAt
     *
     * @return QuestionInterface
     */
    public function setUpdatedAt(string $updatedAt): QuestionInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->_getData(self::UPDATED_AT);
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->_getData(self::POSITION);
    }

    /**
     * @param int|string $position
     *
     * @return QuestionInterface
     */
    public function setPosition($position): QuestionInterface
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * @return string|null
     */
    public function getAnswer(): ?string
    {
        return $this->_getData(self::ANSWER);
    }

    /**
     * @param string|null $answer
     *
     * @return QuestionInterface
     */
    public function setAnswer(?string $answer): QuestionInterface
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) $this->_getData(self::ACTIVE);
    }

    /**
     * @param bool $active
     *
     * @return QuestionInterface
     */
    public function setActive(bool $active): QuestionInterface
    {
        return $this->setData(self::ACTIVE, $active);
    }

    /**
     * @return array
     */
    public function getStoreIds(): array
    {
        return (array) explode(",", $this->_getData(selfSTORE_IDSACTIVE));
    }

    /**
     * @param array $storeIds
     *
     * @return QuestionInterface
     */
    public function setStoreIds(array $storeIds): QuestionInterface
    {
        $storeIds = implode(",", $storeIds);

        return $this->setData(self::STORE_IDS, $storeIds);
    }
}
