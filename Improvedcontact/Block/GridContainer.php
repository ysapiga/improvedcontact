<?php

namespace Sapiha\Improvedcontact\Block;

/**
 * Class GridContainer
 * @package Sapiha\Improvedcontact\Block
 */
class GridContainer extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Part for generating appropriate grid block name
     *
     * @var string
     */
    protected $_controller = 'improvedcontact';

    /**
     * Set custom labels and headers
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->removeButton('add');
    }
}
