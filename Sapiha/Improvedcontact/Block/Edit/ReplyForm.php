<?php

namespace Sapiha\Improvedcontact\Block\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Customer feedbacks edit form
 */
class ReplyForm extends Generic
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
                    'id' => 'reply_form',
                ],
            ]
        );
        $fieldset = $form->addFieldset(
            'reply_to_customer',
            []
        );
        $fieldset->addField(
            'customer_email',
            'text',
            [
                'name' => 'customer_email',
                'label' => __('Customer Email'),
                'title' => __('Customer Email'),
                'required' => false,
                'value' =>  $contact ? $contact->getData('email') : '',
                'disabled' => true,
            ]
        );
        $fieldset->addField(
            'subject',
            'text',
            [
                'name' => 'subject',
                'label' => __('Subject'),
                'title' => __('Subject'),
                'required' => true,
                'class' => 'required _required',

            ]
        );
        $fieldset->addField(
            'message_to_customer',
            'textarea',
            [
                'name' => 'message_to_customer',
                'label' => __('Message to customer'),
                'title' => __('Message to customer'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'customer_name',
            'hidden',
            [
                'name' => 'customer_name',
                'value' => $contact ? $contact->getData('name') : '',
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
