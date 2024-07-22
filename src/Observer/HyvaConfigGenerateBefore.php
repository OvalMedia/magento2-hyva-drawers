<?php

declare(strict_types=1);

namespace Hyva\Drawers\Observer;

class HyvaConfigGenerateBefore implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\Component\ComponentRegistrar
     */
    protected \Magento\Framework\Component\ComponentRegistrar $_componentRegistrar;

    /**
     * @param \Magento\Framework\Component\ComponentRegistrar $componentRegistrar
     */
    public function __construct(\Magento\Framework\Component\ComponentRegistrar $componentRegistrar)
    {
        $this->_componentRegistrar = $componentRegistrar;
    }

    /**
     * @param \Magento\Framework\Event\Observer $event
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $config = $observer->getData('config');
        $extensions = $config->hasData('extensions') ? $config->getData('extensions') : [];
        $moduleName = implode('_', array_slice(explode('\\', __CLASS__), 0, 2));
        $path = $this->_componentRegistrar->getPath(\Magento\Framework\Component\ComponentRegistrar::MODULE, $moduleName);
        $extensions[] = ['src' => substr($path, strlen(BP) + 1)];
        $config->setData('extensions', $extensions);
    }
}