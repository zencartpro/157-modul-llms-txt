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
 * Automatic LLMs.txt Generator -- admin page name.
 *
 * The same constant, and the same value, as the storefront side: the admin
 * page is `admin/llms_txt.php` (reached as `index.php?cmd=llms_txt`) and the
 * storefront page is `index.php?main_page=llms_txt`. Each side loads only its
 * own extra_datafiles, so there is no double definition -- but the guard stays,
 * because it costs nothing and a future core change could load both. 
 */

if (!defined('FILENAME_LLMS_TXT')) {
    define('FILENAME_LLMS_TXT', 'llms_txt');
}
