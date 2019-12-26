<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Ui\Component\Form\Buttons;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Sapiha\Improvedcontact\Model\ContactRepository;

/**
 * Class SaveButton
 */
class DeleteButton implements ButtonProviderInterface
{
    /** @var ContactRepository */
    private $contactRepository;

    /** @var RequestInterface  */
    private $request;

    /** @var UrlInterface  */
    private $urlBuilder;

    /**
     * @param ContactRepository $contactRepository
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        ContactRepository $contactRepository,
        RequestInterface $request,
        UrlInterface $urlBuilder
    ) {
        $this->contactRepository = $contactRepository;
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getContactId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to do this?')
                    . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * URL to send delete requests to.
     *
     * @return string
     */
    private function getDeleteUrl()
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['id' => $this->getContactId()]);
    }


    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    private function getContactId()
    {
        try {
            return $this->contactRepository->getById((int)$this->request->getParam('id'))->getId();
        } catch (NoSuchEntityException $e) {
            //just do nothing
        }

        return null;
    }
}
