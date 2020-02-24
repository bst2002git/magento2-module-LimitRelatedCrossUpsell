<?php

namespace IDEC\LimitRelatedCrossUpsell\Block\Cart;

class Crosssell extends \Magento\Checkout\Block\Cart\Crosssell
{

   /**
    * We can now set our limit here
    */
   const CROSSSELL_LIMIT = 8;

   /**
    * Crosssell constructor.
    * @param \Magento\Catalog\Block\Product\Context $context
    * @param \Magento\Checkout\Model\Session $checkoutSession
    * @param \Magento\Catalog\Model\Product\Visibility $productVisibility
    * @param \Magento\Catalog\Model\Product\LinkFactory $productLinkFactory
    * @param \Magento\Quote\Model\Quote\Item\RelatedProducts $itemRelationsList
    * @param \Magento\CatalogInventory\Helper\Stock $stockHelper
    * @param array $data
    */
   public function __construct(
       \Magento\Catalog\Block\Product\Context $context,
       \Magento\Checkout\Model\Session $checkoutSession,
       \Magento\Catalog\Model\Product\Visibility $productVisibility,
       \Magento\Catalog\Model\Product\LinkFactory $productLinkFactory,
       \Magento\Quote\Model\Quote\Item\RelatedProducts $itemRelationsList,
       \Magento\CatalogInventory\Helper\Stock $stockHelper,
       array $data = []
   ) {
       parent::__construct(
           $context,
           $checkoutSession,
           $productVisibility,
           $productLinkFactory,
           $itemRelationsList,
           $stockHelper,
           $data
       );

       $this->_maxItemCount = self::CROSSSELL_LIMIT; //limit number of products
   }
}