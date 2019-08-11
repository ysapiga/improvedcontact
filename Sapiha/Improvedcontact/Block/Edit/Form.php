<?php

namespace Sapiha\Improvedcontact\Block\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Customer feedbacks edit form
 */
class Form extends Generic
{
    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        $contact = $this->getData('contact');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('adminhtml/*/save', ['id' => $contact->getId()]),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ],
            ]
        );
        $fieldset = $form->addFieldset(
            'feedback_info',
            ['legend' => __('Feedback information')]
        );
        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Customer Name'),
                'title' => __('Customer Name'),
                'required' => false,
                'value' =>  $contact ? $contact->getData('name') : '',
                'disabled' => true,
            ]
        );
        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Customer Email'),
                'title' => __('Customer Email'),
                'required' => false,
                'value' =>  $contact ? $contact->getData('email') : '',
                'disabled' => true,
            ]
        );
        $fieldset->addField(
            'phone',
            'text',
            [
                'name' => 'phone',
                'label' => __('phone'),
                'title' => __('phone'),
                'required' => false,
                'disabled' => true,
                'value' => $contact ? $contact->getData('phone') : '',
            ]
        );
        $fieldset->addField(
            'message',
            'textarea',
            [
                'name' => 'message',
                'label' => __('message'),
                'title' => __('message'),
                'required' => false,
                'disabled' => true,
                'value' =>  $contact ? $contact->getData('message') : '',
            ]
        );
        $fieldset->addField(
            'is_replied',
            'select',
            [
                'name' => 'is_replied',
                'label' => __('Is message replied'),
                'title' => __('Is message replied'),
                'required' => false,
                'value' => $contact ? $contact->getData('is_replied') : '',
                'values' => [
                    '0' => __('No'),
                    '1' => __('Yes'),
                ]
            ]
        );
        $fieldset->addField(
            'reply',
            'button',
            [
                'name' => 'reply',
                'label' => __('Reply'),
                'title' => __('Reply'),
                'required' => false,
                'value' => __('Reply on message'),
                'class' => 'button',
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
