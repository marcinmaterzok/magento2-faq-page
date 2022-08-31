<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Ui\Component\Question\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class QuestionActions extends Column
{
    private const URL_PATH_EDIT = 'mtrzk_faqpage/question/edit';

    private const URL_PATH_DELETE = 'mtrzk_faqpage/question/delete';

    protected UrlInterface $_urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);

        $this->_urlBuilder = $urlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                if (isset($item['id'])) {
                    $title = $item['name'] ?? '';

                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->_urlBuilder->getUrl(
                                self::URL_PATH_EDIT,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label' => __('Edit')->render()
                        ],
                        'delete' => [
                            'href'    => $this->_urlBuilder->getUrl(
                                self::URL_PATH_DELETE,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label'   => __('Delete')->render(),
                            'confirm' => [
                                'title'   => __('Delete %1', $title)->render(),
                                'message' => __('Are you sure you want to delete a %1 record?', $title)->render(),
                            ],
                            'question'    => true
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
