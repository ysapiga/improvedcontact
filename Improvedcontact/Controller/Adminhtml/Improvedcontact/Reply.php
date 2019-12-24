<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\LayoutFactory;
use Sapiha\Improvedcontact\Sender\Email;

/**
 * Class represent action responsible for message replying
 */
class Reply extends Action
{
    const ADMIN_RESOURCE = 'Sapiha_Improvedcontact::contact';

    /** @var Email */
    private $sender;

    /** @var LayoutFactory */
    private $layoutFactory;

    /**
     * @param Context $context
     * @param Email $sender
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Context $context,
        Email $sender,
        LayoutFactory $layoutFactory
    ) {
        $this->sender = $sender;
        $this->layoutFactory = $layoutFactory;

        parent::__construct($context);
    }

    /**
     * @return Json|Redirect
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();

        try {
            $this->sender->sendMail($params);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->returnResult('*/*/edit', ['_current' => true], ['error' => true]);
        }

        return $this->returnResult('*/*/edit', [], ['error' => false]);
    }

    /**
     * Provides an initialized Result object.
     *
     * @param string $path
     * @param array $params
     * @param array $response
     * @return Json|Redirect
     */
    private function returnResult($path = '', array $params = [], array $response = [])
    {
        if ($this->isAjax()) {
            $layout = $this->layoutFactory->create();
            $layout->initMessages();

            $response['messages'] = [$layout->getMessagesBlock()->getGroupedHtml()];
            $response['params'] = $params;
            return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($response);
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath($path, $params);
    }
}
