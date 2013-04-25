<?php
/**
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / Admin / From / Processing
 */
namespace PH7;
defined('PH7') or exit('Restricted access');

use
PH7\Framework\Mvc\Router\UriRoute,
PH7\Framework\Url\HeaderUrl;

class AddFieldFormProcessing extends Form
{

    public function __construct()
    {
        parent::__construct();

        HeaderUrl::redirect(UriRoute::get(PH7_ADMIN_MOD, 'field', 'all'), t('The field has been added.'));
    }

}