<?php
/**
 * $Id$
 *
 * sofortueberweisung Module
 *
 * Copyright (c) 2009 touchDesign
 *
 * @category Payment
 * @version 0.8
 * @copyright 19.08.2009, touchDesign
 * @author Christoph Gruber, <www.touchdesign.de>
 * @link http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm
 * @link http://www.homepage-community.de/index.php?topic=555.0
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * Description:
 *
 * Payment module directebanking
 *
 * --
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@touchdesign.de so we can send you a copy immediately.
 *
 */

$useSSL = true;

require_once dirname(__FILE__).'/../../config/config.inc.php';
require_once dirname(__FILE__).'/sofortueberweisung.php';
include_once dirname(__FILE__).'/../../header.php';

if (!$cookie->isLogged()){
  Tools::redirect('authentication.php?back=order.php');
}

$sofortueberweisung = new sofortueberweisung();

echo $sofortueberweisung->execPayment($cart);

include_once dirname(__FILE__).'/../../footer.php';

?>