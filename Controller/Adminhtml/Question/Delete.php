<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o.  All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Controller\Adminhtml\Question;

use Exception;
use Mtrzk\FaqPage\Api\QuestionRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Mtrzk_FaqPage::edit';

    /** @var QuestionRepositoryInterface */
    protected QuestionRepositoryInterface $questionRepository;

    /**
     * @param Context                     $context
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context                     $context,
        QuestionRepositoryInterface $questionRepository
    ) {
        parent::__construct($context);

        $this->questionRepository = $questionRepository;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $this->questionRepository->deleteById((int) $id);
                $this->messageManager->addSuccessMessage(__('The question has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find an question to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
