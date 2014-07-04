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


// Check users backend theme
if(Input::get(id))
{
  $userBackendTheme = UserModel::findById(Input::get(id))->backendTheme;
}
else
{
  $userBackendTheme = BackendUser::getInstance()->backendTheme;
}

// Update on theme change
$GLOBALS['TL_DCA']['tl_user']['fields']['backendTheme']['eval']['submitOnChange'] = true;


// Backend-Theme-Extended works only with default and oxygen backend theme
if(in_array($userBackendTheme, array('default', 'oxygen')) || Input::get(update) == 'database')
{

  // Palettes
  $btePalette = '{bte_legend},bteStyling,bteFixLeft,bteFixHeader,bteFixButtons,bteSmallCePreview,bteTips;';

  foreach($GLOBALS['TL_DCA']['tl_user']['palettes'] as $key => $value)
  {
    if($key == "__selector__")
    {
      continue;
    }
    $GLOBALS['TL_DCA']['tl_user']['palettes'][$key] = str_replace(',backendTheme;', ',backendTheme;'.$btePalette, $value);
  }

  // Fields
  $GLOBALS['TL_DCA']['tl_user']['fields']['bteFixLeft'] = array
  (
    'label'     => &$GLOBALS['TL_LANG']['tl_user']['bteFixLeft'],
    'inputType' => 'checkbox',
    'default'   => 1,
    'eval'      => array('tl_class'=>'w50'),
    'sql'       => "char(1) NOT NULL default ''"
  );
  $GLOBALS['TL_DCA']['tl_user']['fields']['bteFixHeader'] = array
  (
    'label'     => &$GLOBALS['TL_LANG']['tl_user']['bteFixHeader'],
    'inputType' => 'checkbox',
    'default'   => 1,
    'eval'      => array('tl_class'=>'w50'),
    'sql'       => "char(1) NOT NULL default ''"
  );
  $GLOBALS['TL_DCA']['tl_user']['fields']['bteFixButtons'] = array
  (
    'label'     => &$GLOBALS['TL_LANG']['tl_user']['bteFixButtons'],
    'inputType' => 'select',
    'options'   => array('bteBottom', 'bteTop', 'bteNone'),
    'default'   => 'bteBottom',
    'eval'      => array('tl_class'=>'w50'),
    'reference' => &$GLOBALS['TL_LANG']['tl_user'],
    'sql'       => "varchar(32) NOT NULL default ''"
  );
  $GLOBALS['TL_DCA']['tl_user']['fields']['bteStyling'] = array
  (
    'label'     => &$GLOBALS['TL_LANG']['tl_user']['bteStyling'],
    'inputType' => 'checkbox',
    'default'   => 1,
    'eval'      => array('tl_class'=>'w50'),
    'sql'       => "char(1) NOT NULL default ''"
  );
  $GLOBALS['TL_DCA']['tl_user']['fields']['bteSmallCePreview'] = array
  (
    'label'     => &$GLOBALS['TL_LANG']['tl_user']['bteSmallCePreview'],
    'inputType' => 'checkbox',
    'default'   => 1,
    'eval'      => array('tl_class'=>'w50'),
    'sql'       => "char(1) NOT NULL default ''"
  );
  $GLOBALS['TL_DCA']['tl_user']['fields']['bteTips'] = array
  (
    'label'     => &$GLOBALS['TL_LANG']['tl_user']['bteTips'],
    'default'   => 'bteShowTips',
    'inputType' => 'select',
    'options'   => array('bteShowTips', 'bteMove', 'bteHide'),
    'default'   => 'bteMove',
    'eval'      => array('tl_class'=>'w50'),
    'reference' => &$GLOBALS['TL_LANG']['tl_user'],
    'sql'       => "varchar(32) NOT NULL default ''"
  );
}
