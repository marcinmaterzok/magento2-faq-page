<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Model\ResourceModel;

use Mtrzk\FaqPage\Api\Data\QuestionInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mtrzk_faqpage_question', QuestionInterface::ID);
    }
}
