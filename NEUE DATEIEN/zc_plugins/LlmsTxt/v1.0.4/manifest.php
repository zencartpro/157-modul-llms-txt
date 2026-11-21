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
 */

$llmstxtReadmeUrl = 'index.php?cmd=llms_txt_readme';

$llmstxtShowReadme = false;
if (function_exists('zen_is_superuser') && defined('SUPERUSER_PROFILE')) {
    $llmstxtShowReadme = zen_is_superuser();
}
$llmstxtGithubUrl = 'https://github.com/zencartpro/llms-txt';

$llmstxtForumUrl = '';

/**
 * The Settings button: this plugin's Configuration page, shown only once the
 * plugin is installed. Its gID is assigned at install, so it differs from
 * store to store and can't be written here; it's read from the admin page the
 * installer registers (page key configLlmsTxt). The link is relative
 * ("index.php?cmd=configuration&gID=N") because Plugin Manager is an admin
 * page, so it survives a domain or admin-folder rename.
 *
 * Zen Cart reads manifests only on the Plugin Manager page, but the lookup is
 * still guarded so a manifest read anywhere else (no database, catalog side,
 * CLI) just leaves the button out. On v2.2 and later this file is re-read on
 * every Plugin Manager visit, so the button follows the install state by
 * itself; on v1.5.8, v2.0 and v2.1 the installer saves the re-read
 * description at Install, Upgrade and Uninstall
 * (llmstxtRefreshPluginDescription).
 */
$llmstxtSettingsUrl = '';
if (defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG === true && defined('TABLE_ADMIN_PAGES')
    && isset($GLOBALS['db']) && is_object($GLOBALS['db'])) {
    $llmstxtPage = $GLOBALS['db']->Execute(
        "SELECT main_page, page_params FROM " . TABLE_ADMIN_PAGES
        . " WHERE page_key = 'configLlmsTxt' LIMIT 1"
    );
    if (!$llmstxtPage->EOF && defined($llmstxtPage->fields['main_page'])) {
        $llmstxtSettingsUrl = 'index.php?cmd=' . constant($llmstxtPage->fields['main_page'])
            . '&' . $llmstxtPage->fields['page_params'];
    }
}

/**
 * One row: ReadMe | Settings | Forum Thread | GitHub. A second line would push
 * the Author line and the core buttons further down the panel. Spacing is set
 * inline, which beats any theme `.btn` margin: every gap is 4px (the wrapper
 * supplies the space before the first button, each button the space after
 * itself) and the side padding is 8px rather than Bootstrap's 12px, so all
 * four fit on one line in Plugin Manager's side panel from a 1366px-wide
 * window up. Settings opens in the same tab (it's the admin itself); the
 * others open in a new one.
 */
$llmstxtGap = '4px';
$llmstxtButtonStyle = ' style="margin:0 ' . $llmstxtGap . ' 0 0;padding-left:8px;padding-right:8px"';
$llmstxtButton = static function ($url, $label, $newTab) use ($llmstxtButtonStyle) {
    return '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"'
        . ($newTab ? ' target="_blank" rel="noopener noreferrer"' : '')
        . ' class="btn btn-primary" role="button"' . $llmstxtButtonStyle . '>' . $label . '</a>';
};

$llmstxtLinks =
    '<div style="margin:10px 0 0;padding:0 0 0 ' . $llmstxtGap . '">'
    . ($llmstxtShowReadme ? $llmstxtButton($llmstxtReadmeUrl, 'Anleitung', true) : '')
    . ($llmstxtSettingsUrl !== '' ? $llmstxtButton($llmstxtSettingsUrl, 'Einstellungen', false) : '')
    . ($llmstxtForumUrl !== '' ? $llmstxtButton($llmstxtForumUrl, 'Forum Thread', true) : '')
    . $llmstxtButton($llmstxtGithubUrl, 'GitHub', true)
    . '</div>';

return [
    'pluginVersion' => 'v1.0.4',
    'pluginName' => 'Automatic LLMs.txt Generator',
    'pluginDescription' =>
        'Erstellt eine llms.txt-Datei für Ihren Shop – den Markdown-Leitfaden, den KI-Assistenten '
        . 'lesen, um eine Website zu verstehen: Ihren Shop-Namen und eine Zusammenfassung, Seiten zu Versand und Geschäftsbedingungen, '
        . 'Kategorien, Marken, Artikel mit Preisen und EZ-Pages. Wird live unter /llms.txt bereitgestellt oder als '
        . 'eine echte Datei im Stammverzeichnis des Shops gespeichert, die automatisch neu erstellt wird, wenn sich der Shop Datenbestand ändert, nach einem '
        . 'Zeitplan oder nur auf Anfrage.'
        . $llmstxtLinks,
    'pluginAuthor' => 'My Zen Cart Host (dbltoe)',
    'pluginId' => 0,
    'zcVersions' => ['v157'],
    'changelog' => 'changelog.txt',
    'github_repo' => $llmstxtGithubUrl,
    'pluginGroups' => [],
];
