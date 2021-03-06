<?php
/**
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / Admin / From / Processing
 */
namespace PH7;
defined('PH7') or die('Restricted access');

use PH7\Framework\Mvc\Request\HttpRequest, PH7\Framework\Mvc\Model\Design as DesignModel;

class StyleFormProcessing extends Form
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->str->equals($this->httpRequest->post('code', HttpRequest::NO_CLEAN), (new DesignModel)->customCode('css')))
        {
            (new AdminModel)->updateCustomCode($this->httpRequest->post('code', HttpRequest::NO_CLEAN), 'css');

            /* Clean Model\Design for STATIC / customCodecss data */
            (new Framework\Cache\Cache)->start(DesignModel::CACHE_STATIC_GROUP, 'customCodecss', null)->clear();
        }
        \PFBC\Form::setSuccess('form_style', t('Your CSS code was saved successfully!'));
    }

}
