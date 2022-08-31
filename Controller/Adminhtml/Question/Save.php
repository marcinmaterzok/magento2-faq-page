<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o.  All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Controller\Adminhtml\Question;

use Exception;
use Mtrzk\FaqPage\Api\Data\QuestionInterface;
use Mtrzk\FaqPage\Api\Data\QuestionInterfaceFactory;
use Mtrzk\FaqPage\Api\QuestionRepositoryInterface;
use Mtrzk\FaqPage\Model\Question;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;
use RuntimeException;

class Save extends Action implements HttpPostActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Mtrzk_FaqPage::question_save';

    /** @var QuestionRepositoryInterface */
    private QuestionRepositoryInterface $questionRepository;

    /** @var QuestionInterfaceFactory */
    private QuestionInterfaceFactory $questionFactory;

    /** @var HttpRequest */
    private HttpRequest $request;

    /** @var DataPersistorInterface */
    private DataPersistorInterface $dataPersistor;

    /** @var Json */
    private Json $json;

    /**
     * @param Context                     $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionInterfaceFactory    $questionFactory
     * @param HttpRequest                 $request
     * @param DataPersistorInterface      $dataPersistor
     * @param Json                        $json
     */
    public function __construct(
        Context                      $context,
        QuestionRepositoryInterface $questionRepository,
        QuestionInterfaceFactory    $questionFactory,
        HttpRequest                  $request,
        DataPersistorInterface       $dataPersistor,
        Json                         $json
    ) {
        parent::__construct($context);

        $this->questionRepository = $questionRepository;
        $this->questionFactory    = $questionFactory;
        $this->request             = $request;
        $this->dataPersistor       = $dataPersistor;
        $this->json                = $json;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        /** @phpstan-ignore-next-line */
        $data     = $this->request->getPostValue();

        if ($data) {
            $id = (int) $this->getRequest()->getParam('id');

            if (!empty($id)) {
                $model = $this->questionRepository->getById($id);
            } else {
                unset($data['id']);
                $model = $this->questionFactory->create();
            }

            $data['store_ids'] = implode(",", $data['store_ids']);

            /** @var QuestionInterface $model */
            $model->setData($data);

            try {
                $this->questionRepository->save($model);

                $this->messageManager->addSuccessMessage(
                    __('The question was saved successfully!')->render()
                );

                $this->dataPersistor->clear(Question::DATA_PERSISTOR_KEY);

                return $resultRedirect->setPath('*/*/');
            } catch (CouldNotSaveException | RuntimeException $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the question. %1', $e->getMessage())->render()
                );
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the question.')->render()
                );
            }

            $this->dataPersistor->set(Question::DATA_PERSISTOR_KEY, $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
