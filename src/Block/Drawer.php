<?php

declare(strict_types=1);

namespace Hyva\Drawers\Block;

use Magento\Framework\View\Element\Template;

class Drawer extends Template
{
    /**
     * Drawer's default position
     *
     * @var string
     */
    public const DEFAULT_POSITION = 'left';

    public const DEFAULT_HEIGHT = 'h-[10rem] md:h-[20rem]';
    public const DEFAULT_WIDTH = 'w-full md:w-[40rem]';

    /**
     *
     */
    public const DEFAULT_TEMPLATE = 'Hyva_Drawers::drawer.phtml';

    /**
     * Default template to use for the sections.
     * Can be overridden in the block's XML declaration.
     *
     * @var array|string[]
     */
    public array $defaultTemplates = [
        'header' => 'Hyva_Drawers::drawer/header.phtml',
        'content' => 'Hyva_Drawers::drawer/content.phtml',
        'footer' => 'Hyva_Drawers::drawer/footer.phtml'
    ];

    /**
     * Start and end classes for the transition
     * depending on the element's position (top, left, bottom, right)
     *
     * @var array|array[]
     */
    public array $stateClasses = [
        'top' => [
            'start' => '-translate-y-full',
            'end' => 'translate-y-0'
        ],

        'left' => [
            'start' => '-translate-x-full',
            'end' => 'translate-x-0'
        ],

        'bottom' => [
            'start' => 'translate-y-full',
            'end' => 'translate-y-0'
        ],

        'right' => [
            'start' => 'translate-x-full',
            'end' => 'translate-x-0'
        ]
    ];

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->_template !== null ? $this->_template : self::DEFAULT_TEMPLATE;
    }

    /**
     * @return string
     */
    public function getDrawerHeader(): string
    {
        return $this->getDrawerChildHtml('header');
    }

    /**
     * @return string
     */
    public function getDrawerContent(): string
    {
        return $this->getDrawerChildHtml('content');
    }

    /**
     * @return string
     */
    public function getDrawerFooter(): string
    {
        return $this->getDrawerChildHtml('footer');
    }

    /**
     * @param string $section
     * @return bool|\Magento\Framework\View\Element\BlockInterface
     */
    public function getDrawerChildBlock(string $section): \Magento\Framework\View\Element\BlockInterface|bool
    {
        $block = false;
        $id = $this->getNameInLayout() . '.' . $section;
        $childNames = $this->getChildNames();

        if (in_array($id, $childNames)) {
            $block = $this->getChildBlock($id);
        }

        return $block;
    }

    /**
     * @param string $section
     * @return string
     */
    public function getDrawerChildHtml(string $section): string
    {
        $result = '';

        if ($block = $this->getDrawerChildBlock($section)) {
            /**
             * If block has no template, set the default template
             */
            if (!$block->getTemplate()) {
                $block->setTemplate($this->defaultTemplates[$section]);
            }
            $result = $block->toHtml();
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->getData('position') ?: self::DEFAULT_POSITION;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getData('id') ?: $this->getNameInLayout();
    }

    /**
     * @return string
     */
    public function getClasses(): string
    {
        $position = $this->getPosition();
        $classes = [];

        if (in_array($position, ['top', 'bottom'])) {
            $classes[] = 'w-full ' . ($this->getHeight() ?: self::DEFAULT_HEIGHT);
        } elseif (in_array($position, ['left', 'right'])) {
            $classes[] = 'h-full ' . ($this->getWidth() ?: self::DEFAULT_WIDTH);
        }

        /**
         * Align the element according to it's position
         */
        switch ($position) {
            case 'top':
                $classes[] = 'mt-0';
                break;
            case 'right':
                $classes[] = 'mr-0';
                break;
            case 'bottom':
                $classes[] = 'mb-0';
                break;
            case 'left':
                $classes[] = 'ml-0';
                break;
        }

        return implode(' ', $classes);
    }

    /**
     * @return string
     */
    public function getTransitionEnterStart(): string
    {
        return $this->getStateClass('start');
    }

    /**
     * @return string
     */
    public function getTransitionEnterEnd(): string
    {
        return $this->getStateClass('end');
    }

    /**
     * @return string
     */
    public function getTransitionLeaveStart(): string
    {
        return $this->getStateClass('end');
    }

    /**
     * @return string
     */
    public function getTransitionLeaveEnd(): string
    {
        return $this->getStateClass('start');
    }

    /**
     * Determines the initial and final classes of the element
     * depending on their off-canvas position.
     *
     * @param string $type
     * @return string
     */
    public function getStateClass(string $type = 'start'): string
    {
        $result = '';
        $pos = $this->getPosition();

        if (!empty($pos)) {
            $result = isset($this->stateClasses[$pos]) ? $this->stateClasses[$pos][$type] : '';
        }

        return $result;
    }
}