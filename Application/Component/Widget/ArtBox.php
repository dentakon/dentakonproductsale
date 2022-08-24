<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace dentakon\dentakonProductSale\Application\Component\Widget;

use oxRegistry;
use oxArticle;

/**
 * Article box widget
 */
class ArtBox extends \OxidEsales\Eshop\Application\Component\Widget\ArticleBox
{
    var $oActionList;

    /**
     * Names of components (classes) that are initiated and executed
     * before any other regular operation.
     * User component used in template.
     *
     * @var array
     */
    protected $_aComponentNames = ['oxcmp_user' => 1, 'oxcmp_basket' => 1, 'oxcmp_cur' => 1];

    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sTemplate = 'widget/product/boxproduct.tpl';

    /**
     * Current article
     *
     * @var \OxidEsales\Eshop\Application\Model\Article|null
     */
    protected $_oArticle = null;
    
    /**
     * Renders template based on widget type or just use directly passed path of template
     *
     * @return string
     */
    public function render()
    {    
	    $this->oActionList = $this->_getActionList();

        parent::render();

        $sWidgetType = $this->getViewParameter('sWidgetType');
        $sListType = $this->getViewParameter('sListType');

        if ($sWidgetType && $sListType) {
            $this->_sTemplate = "widget/" . $sWidgetType . "/" . $sListType . ".tpl";
        }

        $sForceTemplate = $this->getViewParameter('oxwtemplate');
        if ($sForceTemplate) {
            $this->_sTemplate = $sForceTemplate;
        }

        return $this->_sTemplate;
    }

    /**
     * Get product article
     *
     * @return \OxidEsales\Eshop\Application\Model\Article
     */
    public function getProduct()
    {

        if (is_null($this->_oArticle)) {
            if ($this->getViewParameter('_object')) {
                $oArticle = $this->getViewParameter('_object');
            } else {
                $sAddDynParams = $this->getConfig()->getTopActiveView()->getAddUrlParams();

                $sAddDynParams = $this->updateDynamicParameters($sAddDynParams);

                $oArticle = $this->_getArticleById($this->getViewParameter('anid'));
                $this->_addDynParamsToLink($sAddDynParams, $oArticle);
            }
            

            if($oAction = $this->_getActionByProduct($oArticle))
            {
                $oArticle->__set('action',$oAction->oxactions__oxtitle->value);
            }

           $this->setProduct($oArticle);
        }

        return $this->_oArticle;
    }

    /*
     *
    */
    private function _getActionByProduct($oArticle)
    {
        foreach($this->oActionList as $oAction)
        {
            $oArticleList = oxNew("oxarticlelist");
            $oArticleList->loadActionArticles( $oAction->getId() );

            foreach( $oArticleList as $ListArticle )
            {
                if($ListArticle->oxarticles__oxid == $oArticle->getId() && substr($oAction->getId(),0,2) != 'ox')
                {
                    return $oAction;	
                }
            }
        }

        return false;
    }

    /**
     * loads whole Actions
     */
    private function _getActionList()
    {
	$oActionList = oxNew("oxactionlist");
	return $oActionList->getList();
    }


}
