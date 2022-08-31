<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o.  All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Controller\Adminhtml\Question;

use Exception;
use Mtrzk\FaqPage\Model\QuestionRepository;
use Mtrzk\FaqPage\Model\ResourceModel\Question\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Mtrzk_FaqPage::edit';

    /** @var Filter */
    protected Filter $filter;

    /** @var CollectionFactory */
    protected CollectionFactory $collectionFactory;

    /** @var QuestionRepository */
    protected QuestionRepository $questions;

    /**
     * @param Context            $context
     * @param Filter             $filter
     * @param CollectionFactory  $collectionFactory
     * @param QuestionRepository $questions
     */
    public function __construct(
        Context            $context,
        Filter             $filter,
        CollectionFactory  $collectionFactory,
        QuestionRepository $questions
    ) {
        parent::__construct($context);

        $this->filter            = $filter;
        $this->questions         = $questions;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute action
     *
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute(): Redirect
    {
        $collection     = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            $item_data = $item->getData();
            $this->questions->deleteById((int) $item_data['id']);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 question(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
