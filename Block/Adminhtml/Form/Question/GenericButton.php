<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Block\Adminhtml\Form\Question;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;

/**
 * Generic (form) button for FaqPage Question entity.
 */
class GenericButton
{
    /** @var Context */
    private Context $context;

    /** @var UrlInterface */
    private UrlInterface $urlBuilder;

    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context    = $context;
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->context->getRequest()->getParam('id');
    }

    /**
     * @param string $label
     * @param string $class
     * @param string $onclick
     * @param array  $dataAttribute
     * @param int    $sortOrder
     *
     * @return array
     */
    protected function wrapButtonSettings(
        string $label,
        string $class,
        string $onclick = '',
        array  $dataAttribute = [],
        int    $sortOrder = 0
    ): array {
        return [
            'label'          => $label,
            'on_click'       => $onclick,
            'data_attribute' => $dataAttribute,
            'class'          => $class,
            'sort_order'     => $sortOrder,
        ];
    }

    /**
     * Get url.
     *
     * @param string $route
     * @param array  $params
     *
     * @return string
     */
    protected function getUrl(string $route, array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
