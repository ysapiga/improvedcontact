<?php

namespace Sapiha\Improvedcontact\Block;

use Sapiha\Improvedcontact\Block\Edit\Form;

/**
 * Class Edit
 * @package Sapiha\Improvedcontact\Block
 */
class Edit extends \Magento\Backend\Block\Widget\Container
{
    /**
     * Part for building some blocks names
     *
     * @var string
     */
    protected $_controller = 'improvedcontact';

    /**
     * Adminhtml data
     *
     * @var \Magento\Backend\Helper\Data
     */
    protected $_adminhtmlData = null;

    /**
     * Edit constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Backend\Helper\Data $adminhtmlData
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Backend\Helper\Data $adminhtmlData,
        array $data = []
    ) {
        $this->_adminhtmlData = $adminhtmlData;
        parent::__construct($context, $data);

        $this->buttonList->update('save', 'id', 'runImport');
    }

    /**
     * Prepare layout
     *
     * @return \Magento\Backend\Block\Widget\Container
     */
    protected function _prepareLayout()
    {
        $this->setTemplate('Sapiha_Improvedcontact::edit.phtml');

        $this->_addBackButton();
        $this->_addDeleteButton();
        $this->_prepareLayoutFeatures();

        return parent::_prepareLayout();
    }

    /**
     * Prepage layout features
     *
     * @return void
     */
    private function _prepareLayoutFeatures()
    {
        $this->_addEditFormBlock();
    }

    /**
     * Add child edit form block
     *
     * @return void
     */
    private function _addEditFormBlock()
    {
        $this->setChild('form', $this->_createEditFormBlock());
        $this->_addSaveButton();
    }

    /**
     * Add back button
     *
     * @return void
     */
    private function _addBackButton()
    {
        $this->addButton(
            'back',
            [
                'label' => __('Back'),
                'onclick' => 'setLocation(\'' . $this->_adminhtmlData->getUrl('adminhtml/*/') . '\')',
                'class' => 'back',
                'level' => -1
            ]
        );
    }

    /**
     * Add save button
     *
     * @return void
     */
    private function _addSaveButton()
    {
        $this->addButton(
            'save',
            [
                'label' => __('Save'),
                'class' => 'save primary',
                'level' => -1,
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'save', 'target' => '#edit_form']],
                ]
            ]
        );
    }

    /**
     * Creates edit form block
     *
     * @return \Magento\UrlRewrite\Block\Edit\Form
     */
    private function _createEditFormBlock()
    {
        return $this->getLayout()->createBlock(
            Form::class,
            'edit_form',
            ['data' => ['contact' => $this->getData('contact')]]
        );
    }
    /**
     * Add delete button
     *
     * @return void
     */
    private function _addDeleteButton()
    {
        $this->addButton(
            'delete',
            [
                'label' => __('Delete'),
                'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to do this?'))
                    . ','
                    . json_encode(
                        $this->_adminhtmlData->getUrl(
                            'adminhtml/*/delete',
                            ['id' => $this->getData('contact')->getId()]
                        )
                    )
                    . ', {data: {}})',
                'class' => 'scalable delete',
                'level' => -1
            ]
        );
    }
}
