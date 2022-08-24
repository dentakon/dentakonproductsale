<?php
/**
 * @TODO LICENCE HERE
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'dentakonProductSale',
    'title'       => array(
        'de' => 'Aktionsanzeige',
        'en' => 'SalesDisplay',
    ),
    'description' => array(
        'de' => '<h2>Modul zu Präsentation von Aktionen am Artikel</h2>',
        'en' => '<h2>Module to show actions on articles</h2>',
    ),
    'thumbnail'   => 'out/pictures/',
    'version'     => '1.0.0',
    'author'      => 'David Hennig | Dentakon dentale Konzepte',
    'url'         => 'https://www.dentakon.de',
    'email'       => 'davidhennig@dentakon.de',
    'extend'      => array(
	    \OxidEsales\Eshop\Application\Controller\ArticleDetailsController::class => \dentakon\dentakonProductSale\Controller\MainController::class,
        \OxidEsales\Eshop\Application\Component\Widget\ArticleBox::class => \dentakon\dentakonProductSale\Application\Component\Widget\ArtBox::class,
    ),

    'controllers' => array(
	    'actions_main_longdesc' => \dentakon\dentakonProductSale\Controller\Admin\ActionMain::class
    ),

    'templates'   => array(
        'actions_main_longdesc.tpl' => 'dentakon/dentakonproductsale/Application/views/admin/tpl/actions_main_longdesc.tpl'
    ),
    'blocks'      => array(
	    array(
	    'template' => 'page/details/details.tpl',
		'block'    => 'details_article_action',
		'file'     => 'out/blocks/page/details/actions.tpl'
        ),

        array(
         'template'=> 'widget/product/listitem_line.tpl',
         'block'   => 'widget_product_listitem_line_titlebox',
         'file'    => 'out/blocks/widget/product/listitem_action.tpl'
        ),

        array(
            'template'=> 'widget/product/listitem_grid.tpl',
            'block'   => 'widget_product_listitem_infogrid_titlebox',
            'file'    => 'out/blocks/widget/product/listitem_action.tpl'
        ),

        array(
            'template'=> 'widget/product/listitem_infogrid.tpl',
            'block'   => 'widget_product_listitem_infogrid_titlebox',
            'file'    => 'out/blocks/widget/product/listitem_action.tpl'
        ),        


    
    ),
    'settings'    => array(),
    'events'      => array(),
);
