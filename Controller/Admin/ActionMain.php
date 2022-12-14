<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace dentakon\dentakonProductSale\Controller\Admin;

use stdClass;
use OxidEsales\Eshop\Application\Model\Actions;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

/**
 * Admin article main actions manager.
 * There is possibility to change actions description, assign articles to
 * this actions, etc.
 * Admin Menu: Manage Products -> actions -> Main.
 */
class ActionMain extends \OxidEsales\Eshop\Application\Controller\Admin\ActionsMain
{
    /**
     * Loads article actionss info, passes it to Smarty engine and
     * returns name of template file "actions_main.tpl".
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $soxId = $this->_aViewData["oxid"] = $this->getEditObjectId();

        if ($this->isNewEditObject() !== true) {
            $oAction = oxNew(Actions::class);
            $oAction->loadInLang($this->_iEditLang, $soxId);

            $oOtherLang = $oAction->getAvailableInLangs();
            if (!isset($oOtherLang[$this->_iEditLang])) {
                $oAction->loadInLang(key($oOtherLang), $soxId);
            }

            $this->_aViewData["edit"] = $oAction;

            // remove already created languages
            $aLang = array_diff(Registry::getLang()->getLanguageNames(), $oOtherLang);

            if (count($aLang)) {
                $this->_aViewData["posslang"] = $aLang;
            }

            foreach ($oOtherLang as $id => $language) {
                $oLang = new stdClass();
                $oLang->sLangDesc = $language;
                $oLang->selected = ($id == $this->_iEditLang);
                $this->_aViewData["otherlang"][$id] = clone $oLang;
            }
        }

        if (Registry::getConfig()->getRequestParameter("aoc")) {
            // generating category tree for select list
            $this->_createCategoryTree("artcattree", $soxId);

            $oActionsMainAjax = oxNew(\OxidEsales\Eshop\Application\Controller\Admin\ActionsMainAjax::class);
            $this->_aViewData['oxajax'] = $oActionsMainAjax->getColumns();

            return "popups/actions_main_longdesc.tpl";
        }


	if (($oPromotion = $this->getViewDataElement("edit"))) {

            if (($oPromotion->oxactions__oxtype->value == 2) || ($oPromotion->oxactions__oxtype->value == 3)) {
                if ($iAoc = Registry::getConfig()->getRequestParameter("oxpromotionaoc")) {
                    $sPopup = false;
                    switch ($iAoc) {
                        case 'article':
                            // generating category tree for select list
                            $this->_createCategoryTree("artcattree", $soxId);

                            if ($oArticle = $oPromotion->getBannerArticle()) {
                                $this->_aViewData['actionarticle_artnum'] = $oArticle->oxarticles__oxartnum->value;
                                $this->_aViewData['actionarticle_title'] = $oArticle->oxarticles__oxtitle->value;
                            }

                            $sPopup = 'actions_article';
                            break;
                        case 'groups':
                            $sPopup = 'actions_groups';
                            break;
                    }

                    if ($sPopup) {
                        $oActionsArticleAjax = oxNew($sPopup . '_ajax');
                        $this->_aViewData['oxajax'] = $oActionsArticleAjax->getColumns();

                        return "popups/{$sPopup}.tpl";
                    }
                } else {
                    if ($oPromotion->oxactions__oxtype->value == 2) {
                        $this->_aViewData["editor"] = $this->_generateTextEditor(
                            "100%",
                            300,
                            $oPromotion,
                            "oxactions__oxlongdesc",
                            "details.tpl.css"
                        );
                    }
                }
	    }
	    elseif($oPromotion->oxactions__oxtype->value == 1)
	    {
		$this->_aViewData["editor"] = $this->_generateTextEditor(
			"100%",
			300,
			$oPromotion,
			"oxactions__oxlongdesc",
			"details.tpl.css"
		);

            }
        }

        return "actions_main_longdesc.tpl";
    }

}
