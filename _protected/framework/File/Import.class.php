<?php
/**
 * @title            Import Class
 * @desc             Importing the files.
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license          GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package          PH7 / Framework / File
 * @version          1.1
 */

namespace PH7\Framework\File;
defined('PH7') or exit('Restricted access');

class Import
{

    /**
     * Private constructor to prevent instantiation of class since it is a private class.
     *
     * @access private
     */
    private function __construct() {}

    /**
     * Import only Class or Interface of the "framework" pH7 (without dot).
     *
     * @access public
     * @static
     * @param string $sClassName Class path.
     * @param string $sNameSpace Namespace. Default NULL
     * @param string $sExt Optional, the file extension without the dot. Default value is "php".
     */
    public static function pH7FwkClass($sClassName, $sNameSpace = null, $sExt = 'php')
    {
        $sClassName = static::_getSlashPath($sClassName);

        static::_load(PH7_PATH_FRAMEWORK . $sClassName . '.class', $sExt, $sNameSpace);
    }

    /**
     * Import only Class or Interface in the "app" directory (without dot).
     *
     * @access public
     * @static
     * @param string $sClassName Class path.
     * @param string $sNameSpace Namespace. Default NULL
     * @param string $sExt Optional, the file extension without the dot. Default value is "php".
     */
    public static function pH7App($sClassName, $sNameSpace = null, $sExt = 'php')
    {
        $sClassName = static::_getSlashPath($sClassName);

        static::_load(PH7_PATH_APP . $sClassName, $sExt, $sNameSpace);
    }

    /**
     * Import File.
     *
     * @access public
     * @static
     * @param string $sFile File path.
     * @param string $sNameSpace Namespace. Default NULL
     * @param string $sExt Optional, the file extension without the dot. Default "php".
     */
    public static function file($sFile, $sNameSpace = null, $sExt = 'php')
    {
        static::_load($sFile, $sExt, $sNameSpace);
    }

    /**
     * Import File of the Library (without dot).
     *
     * @access public
     * @static
     * @param string $sFile File path.
     * @param string $sNameSpace Namespace. Default NULL
     * @param string $sExt Optional, the file extension without the dot. Default "php".
     */
    public static function lib($sFile, $sNameSpace = null, $sExt = 'php')
    {
        $sFile = static::_getSlashPath($sFile);

        static::_load(PH7_PATH_LIBRARY . $sFile, $sExt, $sNameSpace);
    }

    /**
     * Get path with slashes.
     *
     * @access private
     * @static
     * @param string $sFile The path.
     * @return string
     */
    private static function _getSlashPath($sFile)
    {
        return str_replace(PH7_DOT, PH7_DS, $sFile);
    }

    /**
     * Generic method to load files.
     *
     * @access private
     * @static
     * @param string $sFile File path.
     * @param string $sExt The file extension without the dot.
     * @param string $sNameSpace The namespace.
     * @return mixed (resource, string, boolean, void, ...)
     * @throws \PH7\Framework\Error\CException\PH7Exception If the file is not found.
     */
    private static function _load($sFile, $sExt, $sNameSpace)
    {
        $sFile = $sFile . PH7_DOT . $sExt;

        // Hack to remove the backslash
        if (!empty($sNameSpace))
            $sFile = str_replace($sFile . '\\', '', $sClassName);

        if (is_file($sFile))
            return require $sFile;
        else
            throw new Exception('\'' . $sFile . '\' not found!');
    }

    /**
     * Block cloning.
     *
     * @access private
     */
    private function __clone() {}

}
