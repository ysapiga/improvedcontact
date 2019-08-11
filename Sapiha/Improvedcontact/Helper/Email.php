<?php

namespace Sapiha\Improvedcontact\Helper;

use Magento\Framework\App\Area as Area;
use Magento\Framework\App\Helper\AbstractHelper as AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Api\Data\StoreInterface as StoreInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Custom Module Email helper
 */
class Email extends AbstractHelper
{
    private const XML_PATH_EMAIL_TEMPLATE_FIELD = 'improvedcontact/improvedcontact_email/email_template_field_id';
    private const XML_PATH_TO_SENDER = 'improvedcontact/improvedcontact_email/identity';

    /** @var Context */
    protected $_scopeConfig;

    /** @var StoreManagerInterface */
    protected $_storeManager;

    /** @var StateInterface */
    protected $inlineTranslation;

    /** @var TransportBuilder */
    protected $_transportBuilder;

    /** @var string */
    protected $temp_id;

    /**
     * Email constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param SenderResolverInterface $senderResolver
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        SenderResolverInterface $senderResolver
    ) {
        parent::__construct($context);

        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->senderResolver = $senderResolver;
    }

    /** @var array */
    private $requiredParams = [
        'customer_email',
        'message_to_customer',
    ];

    /**
     * Send Mail
     *
     * @param array $data
     * @throws \Exception is required parameters missed
     * @return void
     */
    public function sendMail($data)
    {
        if ($this->validateParams($data)) {
            $receiverInfo = [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
            ];
            $senderInfo = $this->getSender();
            $emailTempVariables['message'] = $data['message_to_customer'];
            $emailTempVariables['customer'] = $data['customer_name'];

            $this->sendMessage(
                $emailTempVariables,
                $senderInfo,
                $receiverInfo
            );
        } else {
            throw new \Exception('Required params misssed');
        }
    }

    /**
     * Validate parameters
     *
     * @param $params
     * @return bool
     */
    private function validateParams($params)
    {
        foreach ($this->requiredParams as $param) {
            if (!array_key_exists($param, $params) || $params[$param] == '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Return store configuration value of your template field that which id you set for template
     *
     * @param string $path
     * @param int $storeId
     * @return mixed
     */
    private function getConfigValue($path, $storeId)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get sender from configuration
     *
     * @return array|string
     */
    private function getSender()
    {
        return $this->senderResolver->resolve(
            $this->getConfigValue(self::XML_PATH_TO_SENDER, $this->getStore()->getId())
        );
    }

    /**
     * Return store
     *
     * @return StoreInterface
     */
    private function getStore()
    {
        return $this->_storeManager->getStore();
    }

    /**
     * Return template id according to store
     *
     * @return mixed
     */
    private function getTemplateId()
    {
        return $this->getConfigValue(self::XML_PATH_EMAIL_TEMPLATE_FIELD, $this->getStore()->getStoreId());
    }

    /**
     * Generate template
     *
     * @param $emailTemplateVariables
     * @param $senderInfo
     * @param $receiverInfo
     * @return $this
     */
    private function generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->_transportBuilder->setTemplateIdentifier($this->temp_id)
            ->setTemplateOptions(
                [
                    'area' => Area::AREA_FRONTEND,
                    'store' => $this->_storeManager->getStore()->getId(),
                ]
            )
            ->setTemplateVars($emailTemplateVariables)
            ->setFrom($senderInfo)
            ->addTo($receiverInfo['email'], $receiverInfo['name']);

        return $this;
    }

    /**
     * Send message to user
     *
     * @param $emailTemplateVariables
     * @param $senderInfo
     * @param $receiverInfo
     */
    private function sendMessage($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->temp_id = $this->getTemplateId();
        $this->inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }
}
