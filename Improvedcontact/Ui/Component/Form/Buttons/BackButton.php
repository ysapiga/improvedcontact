<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Ui\Component\Form\Buttons;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 */
class BackButton implements ButtonProviderInterface
{
    /** @var  UrlInterface*/
    private $urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->urlBuilder->getUrl('*/*/')),
            'class' => 'back',
            'sort_order' => 10
        ];
    }
}
