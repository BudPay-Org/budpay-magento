<?php
namespace Budpay\Payment\Controller\Payment;

use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Magento\Checkout\Model\Session;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface;

class Callback extends \Magento\Framework\App\Action\Action
{
    protected $orderFactory;
    protected $checkoutSession;
    protected $jsonFactory;
    protected $logger;
    protected $request;

    public function __construct(
        Context $context,
        OrderFactory $orderFactory,
        Session $checkoutSession,
        JsonFactory $jsonFactory,
        LoggerInterface $logger,
        RequestInterface $request
    ) {
        parent::__construct($context);
        $this->orderFactory = $orderFactory;
        $this->checkoutSession = $checkoutSession;
        $this->jsonFactory = $jsonFactory;
        $this->logger = $logger;
        $this->request = $request;
    }

    public function execute()
    {
        $data = $this->request->getParams();
        $this->logger->info('Budpay Callback Data: ' . json_encode($data));

        if (isset($data['reference']) && isset($data['status'])) {
            $order = $this->orderFactory->create()->loadByIncrementId($data['reference']);

            if ($order->getId()) {
                if ($data['status'] === 'successful') {
                    $order->setState(Order::STATE_PROCESSING)
                          ->setStatus(Order::STATE_PROCESSING);
                    $order->save();
                } else {
                    $order->setState(Order::STATE_CANCELED)
                          ->setStatus(Order::STATE_CANCELED);
                    $order->save();
                }
            }
        }

        $result = $this->jsonFactory->create();
        return $result->setData(['success' => true]);
    }
}
