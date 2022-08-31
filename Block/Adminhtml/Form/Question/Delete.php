<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. (MIT License)
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Block\Adminhtml\Form\Question;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Delete entity button.
 */
class Delete extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve Delete button settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return $this->wrapButtonSettings(
            'Delete',
            'delete',
            'deleteConfirm(\''
            . __('Are you sure you want to delete this line configuration?')->render()
            . '\', \'' . $this->getUrl('*/*/remove', ['id' => $this->getId()]) . '\')',
            [],
            20
        );
    }
}
