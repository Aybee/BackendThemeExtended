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


if(TL_MODE == 'BE' && TL_SCRIPT != 'contao/install.php')
{
  $objBackendUser = BackendUser::getInstance();
  $objBackendUser->authenticate();

  if(in_array($objBackendUser->backendTheme, array('default', 'oxygen')))
  {
    $GLOBALS['TL_HOOKS']['parseTemplate'][] = array('BackendThemeExtended', 'addCssClasses');
  }
}
