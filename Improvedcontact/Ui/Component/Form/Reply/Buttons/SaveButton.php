<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Ui\Component\Form\Reply\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 */
class SaveButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reply to Subscriber'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => '',
            ],
            'sort_order' => 20,
        ];
    }
}
