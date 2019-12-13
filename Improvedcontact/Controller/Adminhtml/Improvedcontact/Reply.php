<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Sapiha\Improvedcontact\Sender\Email;

/**
 * Class represent action responsible for message replying
 */
class Reply extends Action
{
    const ADMIN_RESOURCE = 'Sapiha_Improvedcontact::contact';

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Email $sender
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Email $sender
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->sender = $sender;

        parent::__construct($context);
    }

    /**
     * @return Json
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $result = $this->resultJsonFactory->create();

        try {
            $this->sender->sendMail($params);
        } catch (\Exception $e) {
            $result->setData(['error' => 1, 'message' => $e->getMessage()]);
        }

        return $result;
    }
}
