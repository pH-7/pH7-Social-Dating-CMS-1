<?php
/**
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Global / View / Base / Other
 */
namespace PH7;
defined('PH7') or exit('Restricted access');
use PH7\Framework\Layout\Html\Design;

$oDesign = new Design;
$oDesign->htmlHeader();
$aMeta = [
    'title' => t('Maintenance of website') . ' - ' . Core::SOFTWARE_NAME . ' | ' . Core::SOFTWARE_COMPANY,
    'description' => t('Maintenance of website') . ' ' . Core::SOFTWARE_DESCRIPTION,
    'keywords' => t('dating site,free dating site,online dating site,social dating')
];
?>
<!-- Begin Header -->
<?php $oDesign->usefulHtmlHeader($aMeta, true); ?>
<!-- End Header -->

<!-- Begin Content -->
<div id="content" class="s_padd">
<br />
<h1><?php echo t('Site Maintenance') ?></h1>
<p><?php echo t('Whoops! Our website is currently down for maintenance.') ?><br />
<?php echo t('Please come back later!') ?><br /><br />
<span class="small italic"><?php echo t('Kind regards, The Team.') ?></span></p>
</div>
<!-- End Content -->

<!-- Begin Footer -->
<footer>
<?php $oDesign->link(); ?>
</footer>
<?php $oDesign->htmlFooter(); ?>
<!-- End Footer -->
