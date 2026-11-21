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
 * Automatic LLMs.txt Generator -- storefront autoloader configuration 
 * Breakpoint 178 runs after `init_observers.php` (175) and before
 * `init_header.php` (180). By then the database, the configuration constants,
 * the general function library and the language files are all loaded, and
 * nothing has produced output yet -- so the init script can keep a published
 * llms.txt file up to date without touching the page being served. 
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$autoLoadConfig[178][] = [
    'autoType' => 'init_script',
    'loadFile' => 'init_llms_txt.php',
];
