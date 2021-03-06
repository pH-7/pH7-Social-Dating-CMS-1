<?php
/**
 * @title          Love Calculator
 * @desc           Controller of the Love Calculator Module.
 *
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / Love Calculator / Controller
 * @version        1.0
 */
namespace PH7;

class MainController extends Controller
{

    private $oUserModel, $oExists, $sTitle;

    public function __construct()
    {
        parent::__construct();

        $this->oUserModel = new UserCoreModel;
        $this->oExists = new ExistsCoreModel;

        $this->design->addCss(PH7_LAYOUT . PH7_SYS . PH7_MOD . $this->registry->module . PH7_DS . PH7_TPL . PH7_TPL_MOD_NAME . PH7_DS . PH7_CSS, 'common.css');
        $this->design->addJs(PH7_LAYOUT . PH7_SYS . PH7_MOD . $this->registry->module . PH7_DS . PH7_TPL . PH7_TPL_MOD_NAME . PH7_DS . PH7_JS, 'common.js');
    }

    public function index()
    {
        // Get Username
        $sUsername = $this->session->get('member_username');
        $sSecondUsername = $this->httpRequest->get('second_username');

        // Verifies that the username exists and that both user names are not the same.
        if($this->oExists->username($sSecondUsername) && $sUsername != $sSecondUsername)
        {
            // Get ID
            $iId = $this->session->get('member_id');
            $iSecondId = $this->oUserModel->getId(null, $sSecondUsername);

            // Get First Name
            $sFirstName = $this->session->get('member_first_name');
            $sSecondFirstName = $this->oUserModel->getFirstName($iSecondId);

            // Title to View
            $this->sTitle = t('Love Calculator with <span class="pH1">You</span> and <span class="pH1">%0%</span>', $this->str->upperFirst($sFirstName));
            $this->view->page_title = $this->sTitle;
            $this->view->h1_title = $this->sTitle;

            // Username to View
            $this->view->username = $sUsername;
            $this->view->second_username = $sSecondUsername;

            // First Name to View
            $this->view->first_name = $sFirstName;
            $this->view->second_first_name = $sSecondFirstName;

            // Sex to View
            $this->view->sex = $this->oUserModel->getSex($iId);
            $this->view->second_sex = $this->oUserModel->getSex($iSecondId);

            // Include the Avatar class
            $this->view->avatarDesign = new AvatarDesignCore;

            // Calculate the mutual love
            $this->view->love = (new Calculator($sFirstName, $sSecondFirstName))->get();

            // Display
            $this->output();
        }
        else
        {
            $this->displayPageNotFound(t('Not Found Name for the Love Calculator!'));
        }
    }

}
