<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mtrzk\FaqPage\Model\Question;
use Mtrzk\FaqPage\Model\ResourceModel\Question as ResourceModelQuestion;

class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'id';

    /** @var string */
    protected $_eventPrefix = 'mtrzk_faqpage_question_collection';

    /** @var string */
    protected $_eventObject = 'mtrzk_faqpage_question_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Question::class, ResourceModelQuestion::class);
    }
}
