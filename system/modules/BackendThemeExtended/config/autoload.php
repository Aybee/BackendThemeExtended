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


/**
 * Register the classes
 */
if(TL_MODE == 'BE')
{
  ClassLoader::addClasses(array
  (
    'BackendThemeExtended' => 'system/modules/BackendThemeExtended/classes/BackendThemeExtended.php'
  ));
}
