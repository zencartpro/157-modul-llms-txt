<?php
/**
 * Automatic LLMs.txt Generator -- admin menu labels and generated-file wording (English).
 *
 * The BOX_* entries are the `language_key` values the installer writes into
 * admin_pages, so they must exist before the menus are drawn -- hence
 * extra_definitions, which every supported release loads for the admin.
 *
 * The LLMSTXT_HEADING_* and LLMSTXT_LABEL_* entries are the words that appear
 * in the generated file itself. They live in extra_definitions on BOTH sides
 * (this file, and the storefront's) because the file can be built from either.
 * The generator falls back to the same English if a key is missing, so a
 * translation may override any subset.
 *
 * @package  LlmsTxt
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License v2.0
 */

$define = [
    'BOX_CONFIGURATION_LLMS_TXT' => 'Automatischer LLMs.txt Generator',
    'BOX_TOOLS_LLMS_TXT' => 'Automatischer LLMs.txt Generator',

    'LLMSTXT_DEFAULT_SUMMARY' => '%s ist ein Onlineshop.',
    'LLMSTXT_HEADING_INFO' => 'Informationen zum Shop',
    'LLMSTXT_HEADING_CATEGORIES' => 'Kategorien',
    'LLMSTXT_HEADING_BRANDS' => 'Marken',
    'LLMSTXT_HEADING_PRODUCTS' => 'Artikel',
    'LLMSTXT_HEADING_PAGES' => 'Mehr Seiten',
    'LLMSTXT_LABEL_WEBSITE' => 'Website',
    'LLMSTXT_LABEL_CURRENCY' => 'Preise sind in',
    'LLMSTXT_LABEL_SITEMAP' => 'Sitemap',
    'LLMSTXT_LABEL_ROBOTS' => 'Robots',
    'LLMSTXT_LABEL_FULL' => 'Vollständiger Katalog',
    'LLMSTXT_NOTE_FULL' => 'dieselben Abschnitte mit vollständigen Beschreibungen',
    'LLMSTXT_NOTE_BRAND_ONE' => '1 Artikel',
    'LLMSTXT_NOTE_BRAND_MANY' => '%d Artikel',
    'LLMSTXT_LABEL_MODEL' => 'Artikelnummer',
    'LLMSTXT_LABEL_SHIPPINGINFO' => 'Versandkosten',
    'LLMSTXT_LABEL_PRIVACY' => 'Datenschutz',
    'LLMSTXT_LABEL_CONDITIONS' => 'AGB',
    'LLMSTXT_LABEL_CONTACT_US' => 'Kontakt',
    'LLMSTXT_LABEL_SITE_MAP' => 'Sitemap',
    'LLMSTXT_LABEL_GV_FAQ' => 'Geschenkgutschein FAQ',
    'LLMSTXT_LABEL_DISCOUNT_COUPON' => 'Discount Coupons',
    'LLMSTXT_LABEL_SPECIALS' => 'Sonderangebote',
    'LLMSTXT_LABEL_PRODUCTS_NEW' => 'Neue Artikel',
    'LLMSTXT_LABEL_PRODUCTS_ALL' => 'Alle Artikel',
    'LLMSTXT_LABEL_FEATURED_PRODUCTS' => 'Empfohlene Artikel',
    'LLMSTXT_LABEL_REVIEWS' => 'Kundenbewertungen',
];

return $define;
