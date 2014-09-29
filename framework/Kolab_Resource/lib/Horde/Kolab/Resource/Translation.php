<?php
/**
 * @package Kolab_Resource
 *
 * Copyright 2010-2014 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 */

/**
 * Horde_Kolab_Resource_Translation is the translation wrapper class for Horde_Kolab_Resource.
 *
 * @author  Jan Schneider <jan@horde.org>
 * @package Kolab_Resource
 */
class Horde_Kolab_Resource_Translation extends Horde_Translation_Autodetect
{
    /**
     * The translation domain
     *
     * @var string
     */
    protected static $_domain = 'Horde_Kolab_Resource';

    /**
     * The absolute PEAR path to the translations for the default gettext handler.
     *
     * @var string
     */
    protected static $_pearDirectory = '@data_dir@';
}
