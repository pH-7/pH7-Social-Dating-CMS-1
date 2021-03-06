<?php
/**
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / Admin / From
 */
namespace PH7;

use PH7\Framework\Mvc\Model\Design as DesignModel;

class ScriptForm
{

    public static function display()
    {
        if (isset($_POST['submit_script']))
        {
            if (\PFBC\Form::isValid($_POST['submit_script']))
                new ScriptFormProcessing;
            Framework\Url\HeaderUrl::redirect();
        }

        $oForm = new \PFBC\Form('form_script', '100%');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_script', 'form_script'));
        $oForm->addElement(new \PFBC\Element\Token('script'));
        $oForm->addElement(new \PFBC\Element\Textarea(t('Your custon JavaScript code'), 'code', array('value' => (new DesignModel)->customCode('js'), 'description' => t("WARNING! Here you don't have to put the %0% tags.", '<b><i>&lt;script&gt;&lt;/script&gt;</i></b>'), 'style' => 'height:450px')));
        $oForm->addElement(new \PFBC\Element\Button);
        $oForm->render();
    }

}
