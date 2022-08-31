<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o.  All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;

abstract class AbstractAction extends Action
{
    const ADMIN_RESOURCE = 'Mtrzk_FaqPage::faqpage';

    /**
     * @param Page $resultPage
     *
     * @return Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('FAQ Question List'), __('FAQ Question List'));

        return $resultPage;
    }
}
