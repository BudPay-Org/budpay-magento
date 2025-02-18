<?php
namespace Budpay\Payment\Model;

use Magento\Payment\Model\Method\AbstractMethod;
use Magento\Checkout\Model\Session;
use Magento\Sales\Model\Order;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Payment extends AbstractMethod
{
    protected $_code = 'budpay_payment';
    protected $_isOffline = false;
    protected $checkoutSession;
    protected $order;
    protected $curl;
    protected $urlBuilder;
    protected $scopeConfig;

    public function __construct(
        Session $checkoutSession,
        Order $order,
        Curl $curl,
        UrlInterface $urlBuilder,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->order = $order;
        $this->curl = $curl;
        $this->urlBuilder = $urlBuilder;
        $this->scopeConfig = $scopeConfig;
    }

    public function startTransaction()
    {
        $order = $this->checkoutSession->getLastRealOrder();
        $amount = $order->getGrandTotal();
        $currency = $order->getOrderCurrencyCode();
        $orderId = $order->getIncrementId();
        $email = "olaobajua@gmail.com";
        
        $apiKey = $this->scopeConfig->getValue('payment/budpay_payment/api_key', ScopeInterface::SCOPE_STORE);
        $callbackUrl = $this->urlBuilder->getUrl('budpay/payment/callback');
        
        $requestData = [
            'amount' => $amount,
            'email' => $email,
            'currency' => $currency,
            'reference' => $orderId,
            'callback' => $callbackUrl
        ];
        
        $this->curl->setHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json'
        ]);
        
        $this->curl->post('https://api.budpay.com/api/v2/transaction/initialize', json_encode($requestData));
        $response = json_decode($this->curl->getBody(), true);
        
        if (isset($response['data']['authorization_url'])) {
            return $response['data']['authorization_url'];
        }
        return false;
    }
}