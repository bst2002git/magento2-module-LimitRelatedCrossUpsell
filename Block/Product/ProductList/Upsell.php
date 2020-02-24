<?php

namespace IDEC\LimitRelatedCrossUpsell\Block\Product\ProductList;

class Upsell extends \Magento\Catalog\Block\Product\ProductList\Upsell
{

   /**
    * We can now set our limit here
    */
   const UPSELL_LIMIT = 20;

   /**
    * Upsell constructor.
    * @param \Magento\Catalog\Block\Product\Context $context
    * @param \Magento\Checkout\Model\ResourceModel\Cart $checkoutCart
    * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
    * @param \Magento\Checkout\Model\Session $checkoutSession
    * @param \Magento\Framework\Module\Manager $moduleManager
    * @param array $data
    */
   public function __construct(
       \Magento\Catalog\Block\Product\Context $context,
       \Magento\Checkout\Model\ResourceModel\Cart $checkoutCart,
       \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
       \Magento\Checkout\Model\Session $checkoutSession,
       \Magento\Framework\Module\Manager $moduleManager,
       array $data = []
   )
   {
       $this->_checkoutCart = $checkoutCart;
       $this->_catalogProductVisibility = $catalogProductVisibility;
       $this->_checkoutSession = $checkoutSession;
       $this->moduleManager = $moduleManager;
       parent::__construct(
           $context,
           $checkoutCart,
           $catalogProductVisibility,
           $checkoutSession,
           $moduleManager,
           $data
       );
   }

   /**
    * Prepare data
    * added limit for collection
    *
    * @return $this
    */
   protected function _prepareData()
   {
       $product = $this->getProduct();
       /* @var $product \Magento\Catalog\Model\Product */
       $this->_itemCollection = $product->getUpSellProductCollection()->setPositionOrder()->addStoreFilter();

       //limit number of products
       $this->_itemCollection->setPageSize(self::UPSELL_LIMIT);

       if ($this->moduleManager->isEnabled('Magento_Checkout')) {
           $this->_addProductAttributesAndPrices($this->_itemCollection);
       }
       $this->_itemCollection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());

       $this->_itemCollection->load();

       /**
        * Updating collection with desired items
        */
       $this->_eventManager->dispatch(
           'catalog_product_upsell',
           ['product' => $product, 'collection' => $this->_itemCollection, 'limit' => null]
       );

       foreach ($this->_itemCollection as $product) {
           $product->setDoNotUseCategoryId(true);
       }

       return $this;
   }
}