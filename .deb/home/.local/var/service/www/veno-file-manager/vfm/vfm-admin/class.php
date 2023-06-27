<?php
/**
 * VFM - Veno File Manager - main classes
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013-2022 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @version   4.0.2
 * @link      http://filemanager.veno.it/
 */
$vfm_version = '4.0.2';

require_once 'class/class.utils.php';

require_once 'class/class.setup.php';

require_once 'class/class.gatekeeper.php';

require_once 'class/class.logger.php';

require_once 'class/class.location.php';

require_once 'class/class.actions.php';

require_once 'class/class.downloader.php';

require_once 'class/class.uploader.php';

require_once 'class/class.updater.php';

require_once 'class/class.resetter.php';

require_once 'class/class.imageserver.php';

require_once 'class/class.template.php';
