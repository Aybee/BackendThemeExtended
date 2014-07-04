<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   BackendThemeExtended
 * @author    Andreas Burg info@andreasburg.de
 * @license   LGPL
 * @copyright Andreas Burg 2013
 */

class BackendThemeExtended extends Backend
{

  public function __construct()
  {
    parent::__construct();
    $this->import('BackendUser', 'User');
  }


  /**
   * Add css classes to the body element in be_main template
   */
  public function addCssClasses($objTemplate)
  {

    if($objTemplate->getName() == 'be_main' && !$objTemplate->isPopup)
    {
      $objTemplate->stylesheets .= "\n".'  <link rel="stylesheet" href="system/modules/BackendThemeExtended/assets/bte.css">';
      $objTemplate->mootools    .= "\n".'  <script src="system/modules/BackendThemeExtended/assets/bte.js"></script>';

      if($this->User->bteFixLeft)
      {
        $objTemplate->ua .= ' bte_fixLeft';
      }
      if($this->User->bteFixHeader)
      {
        $objTemplate->ua .= ' bte_fixHeader';
      }
      if($this->User->bteFixButtons == 'bteBottom')
      {
        $objTemplate->ua .= ' bte_fixBottom';
      }
      elseif($this->User->bteFixButtons == 'bteTop')
      {
        $objTemplate->ua .= ' bte_fixTop';
      }
      if($this->User->bteSmallCePreview)
      {
        $objTemplate->ua .= ' bte_smallCe';
      }
      if($this->User->bteStyling)
      {
        $objTemplate->ua .= ' bte_style';
      }
      if($this->User->bteTips == 'bteMove')
      {
        $objTemplate->ua .= ' bte_moveTips';
      }
      if($this->User->bteTips == 'bteHide')
      {
        $objTemplate->ua .= ' bte_moveTips bte_hideTips';
      }

      return $objTemplate;
    }
  }
}
