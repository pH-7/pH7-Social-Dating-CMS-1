<?php
/**
 * @title            Core Class
 * @desc             Core Class of the CMS.
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license          GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package          PH7 / Framework / Core
 * @version          1.1
 */

namespace PH7\Framework\Core;
defined('PH7') or exit('Restricted access');

use
PH7\Framework\Session\Session,
PH7\Framework\Translate\Lang,
PH7\Framework\Layout\Html\Design,
PH7\Framework\Date\CDateTime,
PH7\Framework\Layout\Tpl\Engine\PH7Tpl\PH7Tpl;

abstract class Core extends Kernel
{

    protected $session, $lang, $design, $dateTime, $view;

    public function __construct()
    {
        parent::__construct();

        $this->session = new Session;
        $this->lang = new Lang;
        $this->design = new Design;
        $this->dateTime = new CDateTime;
        $this->view = new PH7Tpl;
    }

    public function __destruct()
    {
        parent::__destruct();

        unset(
          $this->session,
          $this->lang,
          $this->design,
          $this->dateTime,
          $this->view
        );
    }

}
