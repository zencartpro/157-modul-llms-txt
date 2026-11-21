<?php
/**
 * Automatic LLMs.txt Generator for Zen Cart German 1.5.7k
 * Zen Cart German Version - www.zen-cart-pro.at
 * @requires    Zen Cart 1.5.7k German and PHP 8.4.x
 * @author      dbltoe
 * see https://github.com/dbltoe/Automatic_LLMs_Txt_Generator
 * @copyright   2026
 * @license     GNU General Public License (GPL) - https://www.gnu.org/licenses/gpl-3.0.html
 * @version     1.0.4
 * @updated     2026-11-21 - webchills for Zen Cart German 
 *
 * Automatic LLMs.txt Generator -- storefront maintenance of a published file.
 *
 * Loaded at autoload breakpoint 178 on every storefront request. All it does
 * is ask the generator whether a published llms.txt is due for a rebuild,
 * which the generator answers from a timestamp in its state file on all but
 * one request in fifteen minutes. The llms_txt page looks after itself, so it
 * is skipped here.
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

if (!isset($_GET['main_page']) || (string)$_GET['main_page'] !== 'llms_txt') {
    require_once dirname(__DIR__, 3) . '/shared/generator.php';
    llmstxt_maintain($db);
}
