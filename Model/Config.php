<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_IS_ENABLED  = 'mtrzk_faqpage/general/is_enabled';
    private const XML_PATH_ADD_TO_MENU = 'mtrzk_faqpage/general/add_to_menu';
    private const XML_PATH_MENU_NAME   = 'mtrzk_faqpage/general/faq_menu_name';

    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param int $storeId
     *
     * @return bool
     */
    public function isEnabled(int $storeId = 0): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_IS_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isAddToMenu(int $storeId = 0): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ADD_TO_MENU,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param int|null $storeId
     *
     * @return string
     */
    public function getMenuName(int $storeId = 0): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_MENU_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
