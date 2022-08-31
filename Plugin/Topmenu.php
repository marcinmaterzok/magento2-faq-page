<?php
/**
 * Copyright © Marcin Materzok - MTRZK Sp. z o .o. All rights reserved.
 * See LICENSE_MTRZK for license details.
 */

declare(strict_types=1);

namespace Mtrzk\FaqPage\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\Block\Html\Topmenu as Subject;
use Mtrzk\FaqPage\Model\Config;

class Topmenu
{
    protected NodeFactory $nodeFactory;
    protected UrlInterface $urlBuilder;
    protected Config $config;
    protected StoreManagerInterface $storeManager;

    /**
     * @param NodeFactory           $nodeFactory
     * @param UrlInterface          $urlBuilder
     * @param Config                $config
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        NodeFactory           $nodeFactory,
        UrlInterface          $urlBuilder,
        Config                $config,
        StoreManagerInterface $storeManager
    ) {
        $this->nodeFactory  = $nodeFactory;
        $this->urlBuilder   = $urlBuilder;
        $this->config       = $config;
        $this->storeManager = $storeManager;
    }

    /**
     * @param Subject $subject
     * @param $outermostClass
     * @param $childrenWrapClass
     * @param $limit
     *
     * @return void
     */
    public function beforeGetHtml(
        Subject $subject,
                $outermostClass = '',
                $childrenWrapClass = '',
                $limit = 0
    ) {
        $storeId = 0;

        try {
            $storeId = $this->storeManager->getStore()->getId();
        } catch (NoSuchEntityException $e) {
        }

        if ($this->config->isEnabled($storeId) && $this->config->isAddToMenu($storeId)) {
            $menuNode = $this->nodeFactory->create([
                'data'    => $this->getNodeAsArray($this->config->getMenuName($storeId), "faq"),
                'idField' => 'id',
                'tree'    => $subject->getMenu()->getTree(),
            ]);

            $subject->getMenu()->addChild($menuNode);
        }
    }

    /**
     * @param $name
     * @param $route
     *
     * @return array
     */
    protected function getNodeAsArray($name, $route): array
    {
        $url = $this->urlBuilder->getUrl("/" . $route); //here you can add url as per your choice of menu

        return [
            'name'       => __($name),
            'id'         => $route,
            'url'        => $url,
            'has_active' => false,
            'is_active'  => false,
        ];
    }
}
