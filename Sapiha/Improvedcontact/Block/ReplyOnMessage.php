<?php

namespace Sapiha\Improvedcontact\Block;

/**
 * Class ReplyOnMessage
 * @package Sapiha\Improvedcontact\Block
 */
class ReplyOnMessage extends \Magento\Backend\Block\Template
{
    /**
     * Get url for ajax action
     *
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('*/*/reply' );
    }
}
