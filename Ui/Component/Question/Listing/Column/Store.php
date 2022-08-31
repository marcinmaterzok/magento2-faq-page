<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Ui\Component\Question\Listing\Column;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Ui\Component\Listing\Columns\Column;

class Store extends Column
{
    /** @var Escaper */
    protected Escaper $escaper;

    /** @var SystemStore */
    protected SystemStore $systemStore;

    /** @var StoreManager */
    protected $storeManager;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Escaper            $escaper
     * @param SystemStore        $systemStore
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        Escaper            $escaper,
        SystemStore        $systemStore,
        array              $components = [],
        array              $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);

        $this->escaper     = $escaper;
        $this->systemStore = $systemStore;
    }

    /**
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * @param array $item
     *
     * @return Phrase|string
     */
    protected function prepareItem(array $item)
    {
        if ($item[$this->getData('name')] === null) {
            return __('All Store Views');
        }

        $content    = '';
        $origStores = explode(',', $item[$this->getData('name')]);

        if (!is_array($origStores)) {
            $origStores = [$origStores];
        }

        if (in_array(0, $origStores)) {
            return __('All Store Views');
        }

        $data = $this->systemStore->getStoresStructure(false, $origStores);

        foreach ($data as $website) {
            $content .= '<b>' . $website['label'] . '</b><br/>';

            foreach ($website['children'] as $group) {
                $content .= str_repeat('&nbsp;', 3) . '<b>' . $this->escaper->escapeHtml($group['label']) . '</b><br/>';

                foreach ($group['children'] as $store) {
                    $content .= str_repeat('&nbsp;', 6) . $this->escaper->escapeHtml($store['label']) . '<br/>';
                }
            }
        }

        return $content;
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function prepare(): void
    {
        parent::prepare();

        if ($this->getStoreManager()->isSingleStoreMode()) {
            $this->_data['config']['componentDisabled'] = true;
        }
    }

    /**
     * @return StoreManager
     */
    private function getStoreManager(): StoreManager
    {
        if ($this->storeManager === null) {
            $this->storeManager = ObjectManager::getInstance()
                ->get(StoreManager::class);
        }

        return $this->storeManager;
    }
}
