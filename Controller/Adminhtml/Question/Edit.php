<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o.  (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Controller\Adminhtml\Question;

use Exception;
use Mtrzk\FaqPage\Api\QuestionRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Mtrzk_FaqPage::edit';

    /** @var PageFactory */
    private PageFactory $resultPageFactory;

    /** @var QuestionRepositoryInterface */
    private QuestionRepositoryInterface $questionRepository;

    /**
     * @param Context                     $context
     * @param PageFactory                 $resultPageFactory
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context                     $context,
        PageFactory                 $resultPageFactory,
        QuestionRepositoryInterface $questionRepository
    ) {
        parent::__construct($context);

        $this->resultPageFactory  = $resultPageFactory;
        $this->questionRepository = $questionRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mtrzk_FaqPage::question');

        $questionId = (int) $this->getRequest()->getParam('id');
        $pageTitle  = $questionId ? __('Edit question')->render() : __('New question')->render();

        try {
            if ($questionId) {
                $questionModel = $this->questionRepository->getById($questionId);
                $data          = $this->_getSession()->getFormData(true);

                if (!empty($data)) {
                    $data['store_ids'] = explode(",", $data['store_ids']);
                    $questionModel->setData($data);
                }
            }
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This question no longer exists.')->render());

            return $this->_redirect('*/*/');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error occurred while processing your request')->render());

            return $this->_redirect('*/*/');
        }

        $resultPage->getConfig()->getTitle()->set($pageTitle);
        $resultPage->addBreadcrumb(
            $pageTitle,
            $pageTitle
        );

        return $resultPage;
    }
}
