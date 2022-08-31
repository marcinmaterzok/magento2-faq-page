<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o.  (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Add extends Action implements HttpGetActionInterface
{
    /**
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Mtrzk_FaqPage::edit';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
