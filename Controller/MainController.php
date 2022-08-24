<?php
/**
 * @TODO LICENCE
 */
namespace dentakon\dentakonProductSale\Controller;

/**
 * Class LinslinSliderMain.
 */
class MainController extends \OxidEsales\Eshop\Application\Controller\ArticleDetailsController
{
    var $oActionList;
    var $oAction;

    public function __construct()
    {
	    $this->oActionList = $this->_getActionList();
	    $this->oAction = $this->_getActionByProduct();
    }	    


    /**
    *
    * @return string
    */
    public function render()
    {
	    if( $this->oAction )
	    {
        $sTitle = $this->oAction->oxactions__oxtitle->value;
		$sTimeLeft = ceil($this->oAction->getTimeLeft() / 86400);	
		$sLongDesc = $this->oAction->getLongDesc();

		$this->_aViewData["Action"] = array(
            'title' => $sTitle,
			'longdesc' => $sLongDesc,
		    'timeleft' => $sTimeLeft,
		);
            }

	parent::render();

        return $this->_sThisTemplate;
    }
	
    /*
     *
    */
    private function _getActionByProduct()
    {
	foreach($this->oActionList as $oAction)
	{
		$oArticleList = oxNew("oxarticlelist");
		$oArticleList->loadActionArticles( $oAction->getId() );

		foreach( $oArticleList as $oArticle )
		{
			if($oArticle->oxarticles__oxid == $this->getProduct()->getId() && substr($oAction->getId(),0,2) != 'ox')
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
