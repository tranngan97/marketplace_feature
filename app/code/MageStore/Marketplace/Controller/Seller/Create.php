<?php

namespace MageStore\Marketplace\Controller\Seller;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\ScopeInterface;

class Create extends \Magento\Framework\App\Action\Action {

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute() {
        return $this->resultPageFactory->create();
    }

}
