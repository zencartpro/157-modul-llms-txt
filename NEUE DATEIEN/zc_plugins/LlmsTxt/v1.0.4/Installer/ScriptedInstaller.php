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

use Zencart\PluginSupport\ScriptedInstaller as ScriptedInstallBase;

class ScriptedInstaller extends ScriptedInstallBase
{
    /**
     * plugin_control.unique_key: the zc_plugins directory name.
     */
    public const PLUGIN_KEY = 'LlmsTxt';

    /**
     * Title of the configuration group this plugin owns.
     */
    public const CONFIG_GROUP_TITLE = 'Automatic LLMs.txt Generator';

    /**
     * admin_pages.page_key values this plugin owns.
     */
    public const ADMIN_PAGE_KEYS = ['configLlmsTxt', 'toolsLlmsTxt'];

    /**
     * Configuration keys from earlier builds that no longer exist. Empty for
     * a first release; kept so an upgrade path has somewhere to put them.
     */
    public const RETIRED_KEYS = [];

    protected function executeInstall()
    {
        $groupId = $this->llmstxtGetOrCreateConfigGroup();
        if ($groupId === 0) {
            return false;
        }

        $this->llmstxtRemoveRetiredKeys();
        if ($this->llmstxtAddConfigurationKeys($groupId) === false) {
            return false;
        }
        $this->llmstxtRegisterAdminPages($groupId);
        $this->llmstxtFirstBuild();
        $this->llmstxtRefreshPluginDescription();

        return true;
    }

    protected function executeUpgrade($oldVersion = null)
    {
        return $this->executeInstall();
    }

    protected function executeUninstall()
    {
        zen_deregister_admin_pages(self::ADMIN_PAGE_KEYS);

        // The generated files are the owner's to keep or remove; the admin
        // page offers Remove. What must go is the cache and state, since
        // nothing of ours is left to read them.
        $this->llmstxtRemoveCache();

        $groupId = $this->llmstxtGetConfigGroupId();
        if ($groupId > 0) {
            $this->executeInstallerSql(
                "DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = " . $groupId
            );
            $this->executeInstallerSql(
                "DELETE FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_id = " . $groupId
            );
            $this->executeInstallerSql(
                "DELETE FROM " . TABLE_CONFIGURATION_LANGUAGE . " WHERE configuration_key LIKE '%LLMSTXT_%'"
            );            
        }

        $this->llmstxtRefreshPluginDescription();

        return true;
    }

    /* ------------------------------------------------------------------ */

    /**
     * Save the manifest's description again, now that the Settings page has
     * been registered (install, upgrade) or removed (uninstall).
     *
     * Needed on v1.5.7k German, which store plugin_control.description
     * only when Plugin Manager first sees the plugin, before Install, so the
     * Settings button (built in manifest.php from the registered admin page)
     * would never appear there. v2.2 and later rewrite the description from
     * the manifest on every Plugin Manager visit, so this is a no-op there in
     * effect. Core's own install/uninstall step changes only status and
     * version, so this description stays.
     *
     * executeUpgrade() re-runs executeInstall(), so an upgrade reaches this too.
     *
     * @return bool
     */
    protected function llmstxtRefreshPluginDescription()
    {
        if (!defined('TABLE_PLUGIN_CONTROL')) {
            return true;
        }
        $manifest = require dirname(__DIR__) . '/manifest.php';
        if (!is_array($manifest) || !isset($manifest['pluginDescription'])) {
            return true;
        }

        return $this->executeInstallerSql(
            "UPDATE " . TABLE_PLUGIN_CONTROL . "
                SET description = '" . $this->dbConn->prepare_input($manifest['pluginDescription']) . "'
              WHERE unique_key = '" . $this->dbConn->prepare_input(self::PLUGIN_KEY) . "'
              LIMIT 1"
        );
    }

    protected function llmstxtGetConfigGroupId()
    {
        $check = $this->dbConn->Execute(
            "SELECT configuration_group_id
               FROM " . TABLE_CONFIGURATION_GROUP . "
              WHERE configuration_group_title = '" . $this->dbConn->prepare_input(self::CONFIG_GROUP_TITLE) . "'
              LIMIT 1"
        );
        return ($check->EOF) ? 0 : (int)$check->fields['configuration_group_id'];
    }

    protected function llmstxtGetOrCreateConfigGroup()
    {
        $groupId = $this->llmstxtGetConfigGroupId();
        if ($groupId > 0) {
            return $groupId;
        }

        $this->executeInstallerSql(
            "INSERT INTO " . TABLE_CONFIGURATION_GROUP . "
                (configuration_group_title, configuration_group_description, sort_order, visible, language_id)
             VALUES
                ('" . $this->dbConn->prepare_input(self::CONFIG_GROUP_TITLE) . "',
                 'Settings for the llms.txt file that describes this store to AI assistants.',
                 1, 1, 43)"
        );
        $groupId = (int)$this->dbConn->Insert_ID();
        if ($groupId > 0) {
            $this->executeInstallerSql(
                "UPDATE " . TABLE_CONFIGURATION_GROUP . "
                    SET sort_order = configuration_group_id
                  WHERE configuration_group_id = " . $groupId
            );
        }
        return $groupId;
    }

    protected function llmstxtRemoveRetiredKeys()
    {
        if (self::RETIRED_KEYS === []) {
            return true;
        }
        $db = $this->dbConn;
        $list = implode("','", array_map(static function ($key) use ($db) {
            return $db->prepare_input($key);
        }, self::RETIRED_KEYS));

        return $this->executeInstallerSql(
            "DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key IN ('" . $list . "')"
        );
    }

    /**
     * Every setting, in the order the Configuration page shows them.
     *
     * @param int $groupId
     * @return array
     */
    protected function llmstxtConfigurationKeys($groupId)
    {
        $yesNo = "zen_cfg_select_option(array('true', 'false'),";

        return [
            [
                'key' => 'LLMSTXT_STATUS',
                'title' => 'Enable LLMs.txt',
                'value' => 'true',
                'description' => 'Switch the whole plugin on or off. Off: the live page answers 404 and no file is written or updated. A file already at the store root is left as it is.',
                'set_function' => $yesNo,
                'sort_order' => 10,
            ],
            [
                'key' => 'LLMSTXT_OUTPUT',
                'title' => 'Publish as',
                'value' => 'file',
                'description' => '<strong>file</strong>: write a real llms.txt at the store root, next to robots.txt. Works with no other setup, as long as the store root is writable.<br><strong>dynamic</strong>: serve it from the live page index.php?main_page=llms_txt. Add the one-line rewrite rule shown on the Tools page to answer at /llms.txt.<br><strong>both</strong>: write the file and keep the live page as a fallback.',
                'set_function' => "zen_cfg_select_option(array('file', 'dynamic', 'both'),",
                'sort_order' => 20,
            ],
            [
                'key' => 'LLMSTXT_REBUILD',
                'title' => 'Rebuild',
                'value' => 'change',
                'description' => '<strong>change</strong>: rebuild when a product, category or EZ-Page is saved in the admin, and whenever a storefront check (at most every fifteen minutes) finds the catalog has changed.<br><strong>daily</strong>, <strong>weekly</strong>, <strong>monthly</strong>: rebuild on that schedule, plus after an admin save.<br><strong>manual</strong>: only when you press Regenerate on the Tools page.<br>A settings change always triggers a rebuild.',
                'set_function' => "zen_cfg_select_option(array('change', 'daily', 'weekly', 'monthly', 'manual'),",
                'sort_order' => 30,
            ],
            [
                'key' => 'LLMSTXT_SUMMARY',
                'title' => 'Store summary',
                'value' => '',
                'description' => 'One or two sentences saying what the store sells and who it\'s for. It\'s the first thing an AI assistant reads, so it matters more than anything else on this page. Left empty, "<em>Store Name</em> is an online store." is used.',
                'set_function' => 'zen_cfg_textarea(',
                'sort_order' => 40,
            ],
            [
                'key' => 'LLMSTXT_NOTES',
                'title' => 'Additional notes',
                'value' => '',
                'description' => 'Optional paragraphs placed after the summary: where you ship, typical delivery times, minimum orders, anything a shopper would ask first. Markdown is allowed and passed through as written.',
                'set_function' => 'zen_cfg_textarea(',
                'sort_order' => 50,
            ],
            [
                'key' => 'LLMSTXT_INFO_PAGES',
                'title' => 'Information pages',
                'value' => 'shippinginfo,privacy,conditions,contact_us,site_map',
                'description' => 'Comma-separated page names to list under "Shopping information", in order. Built-in pages get a sensible label; add your own after a colon, for example <code>about_us:About Our Company</code>. Leave empty to drop the section.',
                'set_function' => 'zen_cfg_textarea_small(',
                'sort_order' => 60,
            ],
            [
                'key' => 'LLMSTXT_INCLUDE_CATEGORIES',
                'title' => 'List categories',
                'value' => 'true',
                'description' => 'Include the category tree, each as "Parent > Child" with a link and its description.',
                'set_function' => $yesNo,
                'sort_order' => 70,
            ],
            [
                'key' => 'LLMSTXT_CATEGORY_DEPTH',
                'title' => 'Category depth',
                'value' => '0',
                'description' => 'How many levels of the tree to list. 0 = every level, 1 = top-level categories only, 2 = two levels, and so on.',
                'set_function' => '',
                'sort_order' => 80,
            ],
            [
                'key' => 'LLMSTXT_EXCLUDE_CATEGORIES',
                'title' => 'Exclude categories',
                'value' => '',
                'description' => 'Comma-separated category ids to leave out, along with everything beneath them and every product whose master category is one of them. The id is shown in the admin category listing.',
                'set_function' => '',
                'sort_order' => 90,
            ],
            [
                'key' => 'LLMSTXT_INCLUDE_PRODUCTS',
                'title' => 'List products',
                'value' => 'true',
                'description' => 'Include products, each with a link and a one-line description. Only enabled products in reachable categories are listed.',
                'set_function' => $yesNo,
                'sort_order' => 100,
            ],
            [
                'key' => 'LLMSTXT_MAX_PRODUCTS',
                'title' => 'Maximum products',
                'value' => '200',
                'description' => 'How many products to list at most. 0 = all of them. A few hundred keeps the file the size assistants read comfortably; the order below decides which ones make the cut.',
                'set_function' => '',
                'sort_order' => 110,
            ],
            [
                'key' => 'LLMSTXT_PRODUCT_ORDER',
                'title' => 'Product order',
                'value' => 'sort',
                'description' => '<strong>sort</strong>: the sort order set on each product, then name.<br><strong>newest</strong>: most recently added first.<br><strong>bestsellers</strong>: most ordered first.<br><strong>name</strong>: alphabetical.<br><strong>viewed</strong>: most viewed first.',
                'set_function' => "zen_cfg_select_option(array('sort', 'newest', 'bestsellers', 'name', 'viewed'),",
                'sort_order' => 120,
            ],
            [
                'key' => 'LLMSTXT_INCLUDE_PRICES',
                'title' => 'Show prices',
                'value' => 'true',
                'description' => 'Add each product\'s base price, in the store\'s default currency, to its line. Specials and tax are not applied.',
                'set_function' => $yesNo,
                'sort_order' => 130,
            ],
            [
                'key' => 'LLMSTXT_DESCRIPTION_LENGTH',
                'title' => 'Description length',
                'value' => '160',
                'description' => 'Longest one-line description for a category or product in llms.txt, in characters. The meta-tag description is used when one has been written; otherwise the start of the product description, with HTML removed.',
                'set_function' => '',
                'sort_order' => 140,
            ],
            [
                'key' => 'LLMSTXT_INCLUDE_BRANDS',
                'title' => 'List brands',
                'value' => 'true',
                'description' => 'Include each manufacturer that has an enabled product, linked to its product listing with a count. A brand whose products all sit in hidden or excluded categories is left out.',
                'set_function' => $yesNo,
                'sort_order' => 145,
            ],
            [
                'key' => 'LLMSTXT_INCLUDE_EZPAGES',
                'title' => 'List EZ-Pages',
                'value' => 'true',
                'description' => 'Include published EZ-Pages that appear in the header, a sidebox, the footer or the table of contents.',
                'set_function' => $yesNo,
                'sort_order' => 150,
            ],
            [
                'key' => 'LLMSTXT_SITEMAP_URL',
                'title' => 'Sitemap address',
                'value' => '',
                'description' => 'The full address of your XML sitemap, if you have one. Left empty, a sitemap.xml at the store root is linked automatically when it exists.',
                'set_function' => '',
                'sort_order' => 160,
            ],
            [
                'key' => 'LLMSTXT_LANGUAGE',
                'title' => 'Language',
                'value' => '',
                'description' => 'Two-letter code of the language to write the file in, for example <code>en</code>. Left empty, the store\'s default language is used.',
                'set_function' => '',
                'sort_order' => 170,
            ],
            [
                'key' => 'LLMSTXT_FULL',
                'title' => 'Also publish llms-full.txt',
                'value' => 'false',
                'description' => 'Publish a second, longer file with the same sections but complete descriptions and model numbers, and link it from llms.txt. Useful for a store whose product pages carry the detail; large for a big catalog.',
                'set_function' => $yesNo,
                'sort_order' => 180,
            ],
            [
                'key' => 'LLMSTXT_FULL_LENGTH',
                'title' => 'Full description length',
                'value' => '1200',
                'description' => 'Longest description per item in llms-full.txt, in characters.',
                'set_function' => '',
                'sort_order' => 190,
            ],
        ];
    }

    /**
     * Insert every configuration key. INSERT IGNORE keeps this idempotent --
     * configuration_key carries a UNIQUE index in every supported release, so
     * a value the store owner has already changed is never overwritten. The
     * label, help text, order and input type belong to the plugin and are
     * refreshed to the current version afterwards.
     *
     * @param int $groupId
     * @return bool
     */
    protected function llmstxtAddConfigurationKeys($groupId)
    {
        $db = $this->dbConn;
        foreach ($this->llmstxtConfigurationKeys($groupId) as $key) {
            $setFunction = ($key['set_function'] === '') ? 'NULL' : "'" . $db->prepare_input($key['set_function']) . "'";

            $ok = $this->executeInstallerSql(
                "INSERT IGNORE INTO " . TABLE_CONFIGURATION . "
                    (configuration_title, configuration_key, configuration_value, configuration_description,
                     configuration_group_id, sort_order, date_added, use_function, set_function)
                 VALUES
                    ('" . $db->prepare_input($key['title']) . "',
                     '" . $db->prepare_input($key['key']) . "',
                     '" . $db->prepare_input($key['value']) . "',
                     '" . $db->prepare_input($key['description']) . "',
                     " . (int)$groupId . ",
                     " . (int)$key['sort_order'] . ",
                     now(),
                     NULL,
                     " . $setFunction . ")"
            );
            if ($ok === false) {
                return false;
            }

            $ok = $this->executeInstallerSql(
                "UPDATE " . TABLE_CONFIGURATION . "
                    SET configuration_title = '" . $db->prepare_input($key['title']) . "',
                        configuration_description = '" . $db->prepare_input($key['description']) . "',
                        configuration_group_id = " . (int)$groupId . ",
                        sort_order = " . (int)$key['sort_order'] . ",
                        set_function = " . $setFunction . "
                  WHERE configuration_key = '" . $db->prepare_input($key['key']) . "'
                  LIMIT 1"
            );
            if ($ok === false) {
                return false;
            }
            
            $ok = $this->executeInstallerSql(
                "INSERT IGNORE INTO ".TABLE_CONFIGURATION_LANGUAGE." 
        (configuration_title, configuration_key, configuration_description, configuration_language_id)
        VALUES
				('LLMs.txt - Wann neu Generieren?', 'LLMSTXT_REBUILD', '<strong>change (Änderung)</strong>:<br>Neuerstellung, wenn ein Artikel, eine Kategorie oder eine EZ-Page im Admin-Bereich gespeichert wird, sowie immer dann, wenn eine Frontend-Prüfung (maximal alle fünfzehn Minuten) feststellt, dass sich der Datenbestand geändert hat.<br><strong>daily (täglich)</strong>, <strong>weekly (wöchentlich)</strong>, <strong>monthly (monatlich)</strong>:<br>Neuerstellung nach diesem Zeitplan sowie nach dem Speichern im Admin-Bereich. <br><strong>manual (manuell)</strong>: Nur, wenn Sie auf der Seite <code>Tools > Automatischer LLMs.txt Generator</code> auf <code>Jetzt neu generieren</code> klicken.<br>Eine Änderung der Einstellungen löst immer eine Neuerstellung aus.', 43),
				('LLMs.txt - Shop Zusammenfassung', 'LLMSTXT_SUMMARY', 'Ein oder zwei Sätze, in denen beschrieben wird, was der Shop verkauft und an wen er sich richtet. Das ist das Erste, was ein KI-Assistent liest, daher ist dieser Text wichtiger als alles andere auf dieser Seite. Wird das Feld leer gelassen, wird folgender Text verwendet: „<em>Shopname</em> ist ein Online-Shop.“', 43),
				('LLMs.txt - Aktivieren?', 'LLMSTXT_STATUS', 'Das gesamte Plugin ein- oder ausschalten<br><br>false (Aus):<br>Die Live-Seite gibt einen 404-Fehler zurück, und es wird keine Datei geschrieben oder aktualisiert. Eine Datei, die sich bereits im Stammverzeichnis des Shops befindet, bleibt unverändert.', 43),
				('LLMs.txt - Art der Veröffentlichung', 'LLMSTXT_OUTPUT', '<b>file (Datei)</b><br>Im Stammverzeichnis des Shops wird neben der robots.txt eine llms.txt erstellt. Dies funktioniert ohne weitere Konfiguration, solange das Stammverzeichnis des Shops beschreibbar ist. <br><strong>dynamic (dynamisch)</strong>:<br>Die Datei wird über die Live-Seite <code>index.php?main_page=llms_txt</code> bereitgestellt. Dazu müssen Sie in Ihrer .htaccess die auf der Seite <code>Tools > Automatischer LLMs.txt Generator</code> angezeigte einzeilige Rewrite-Regel hinzu, um unter /llms.txt zu antworten.<br><strong>both (beides)</strong>:<br>Die Datei wird im Shopverzeichnis erstellt und die Live-Seite wird als Fallback beibehalten.', 43),
				('LLMs.txt - Zusätzliche Anmerkungen', 'LLMSTXT_NOTES', 'Optionale Absätze im Anschluss an die Zusammenfassung: Versandgebiete, typische Lieferzeiten, Mindestbestellmengen – alles, was ein Käufer als Erstes wissen möchte. Markdown ist zulässig und wird unverändert übernommen.', 43),
				('LLMs.txt - Infoseiten', 'LLMSTXT_INFO_PAGES', 'Durch Kommata getrennte Seitennamen, die unter „Shopinformationen“ in der angegebenen Reihenfolge aufgelistet werden sollen. Systemseitige Seiten erhalten eine sinnvolle Bezeichnung; fügen Sie Ihre eigenen nach einem Doppelpunkt hinzu, zum Beispiel <code>about_us:Über unser Unternehmen</code>. Lassen Sie das Feld leer, um den Abschnitt wegzulassen.', 43),
				('LLMs.txt - Kategorien aufnehmen?', 'LLMSTXT_INCLUDE_CATEGORIES', 'Soll der Kategoriebaum aufgenommen werden, jeweils im Format <code>Hauptkategorie > Unterkategorie</code> mit einem Link und der entsprechenden Beschreibung.', 43),
				('LLMs.txt - Kategorietiefe', 'LLMSTXT_CATEGORY_DEPTH', 'Wie viele Ebenen der Baumstruktur sollen aufgelistet werden?<br>0 = alle Ebenen<br>1 = nur Kategorien der obersten Ebene<br>2 = zwei Ebenen usw.', 43),
				('LLMs.txt - Ausgeschlossenene Kategorien', 'LLMSTXT_EXCLUDE_CATEGORIES', 'Durch Kommata getrennte Kategorie-IDs, die ausgeschlossen werden sollen, zusammen mit allen darunter liegenden Kategorien und allen Artikeln, deren Hauptkategorie eine dieser IDs ist. Die ID wird in der Kategorieübersicht des Administrationsbereichs angezeigt.', 43),
				('LLMs.txt - Artikel aufnehmen?', 'LLMSTXT_INCLUDE_PRODUCTS', 'Sollen die Artikel aufgenommen werden, jeweils mit einem Link und einer einzeiligen Beschreibung?<br>Es werden nur aktivierte Artikel aus zugänglichen Kategorien aufgelistet.', 43),
				('LLMs.txt - Maximale Artikelanzahl', 'LLMSTXT_MAX_PRODUCTS', 'Wie viele Artikel sollen maximal aufgelistet werden?<br>0 = alle<br>Bei einigen Hundert bleibt die Datei so groß, dass sie von den Assistenten problemlos gelesen werden kann; die Reihenfolge unten bestimmt, welche Artikel berücksichtigt werden.', 43),
				('LLMs.txt - Artikel Sortierreihenfolge', 'LLMSTXT_PRODUCT_ORDER', '<strong>sort (Sortierung)</strong>:<br>Die für jeden Artikel festgelegte Sortierreihenfolge, gefolgt vom Namen.<br><strong>newest (Neueste)</strong>:<br>Zuletzt hinzugefügte Artikel zuerst.<br><strong>bestsellers</strong>:<br>Meistbestellte Artikel zuerst.<br><strong>name</strong>:<br>Alphabetisch.<br><strong>viewed</strong>:<br>Meistangesehene Artikel zuerst.', 43),
				('LLMs.txt - Preise aufnehmen?', 'LLMSTXT_INCLUDE_PRICES', 'Der Grundpreis jedes Artikels in der Standardwährung des Shops wird zur entsprechenden Zeile hinzugefügt. Sonderangebote und Steuern werden nicht berücksichtigt.', 43),
				('LLMs.txt - Länge der Beschreibungen', 'LLMSTXT_DESCRIPTION_LENGTH', 'Längste einzeilige Beschreibung für eine Kategorie oder einen Artikel in der Datei <code>llms.txt</code>, angegeben in Zeichen. Es wird die Meta-Tag-Beschreibung verwendet, sofern eine vorhanden ist; andernfalls der Anfang der Produktbeschreibung, wobei HTML-Code entfernt wurde.', 43),
				('LLMs.txt - Hersteller aufnehmen?', 'LLMSTXT_INCLUDE_BRANDS', 'Es werden alle Hersteller berücksichtigt, die über ein aktiviertes Produkt verfügen, wobei ein Link zu ihrem Produktangebot mit der entsprechenden Stückzahl angegeben wird. Eine Marke, deren Produkte sich ausschließlich in ausgeblendeten oder ausgeschlossenen Kategorien befinden, wird nicht berücksichtigt.', 43),
				('LLMs.txt - EZ Pages aufnehmen?', 'LLMSTXT_INCLUDE_EZPAGES', 'Es werden veröffentlichte EZ-Seiten eingefügt, die in der Kopfzeile, einer Seitenleiste, der Fußzeile oder im Inhaltsverzeichnis erscheinen.', 43),
				('LLMs.txt - XML Sitemap URL', 'LLMSTXT_SITEMAP_URL', 'Die vollständige Adresse Ihrer XML-Sitemap, falls Sie eine haben. Wird dieses Feld leer gelassen, wird automatisch eine <code>sitemap.xml</code> Datei im Stammverzeichnis des Shops verlinkt, sofern diese vorhanden ist.', 43),
				('LLMs.txt - Sprache', 'LLMSTXT_LANGUAGE', 'Zweibuchstabiger Code der Sprache, in der die Datei geschrieben werden soll, zum Beispiel <code>de</code>. Wird dieses Feld leer gelassen, wird die Standardsprache des Shops verwendet.', 43),
				('LLMs.txt - llms-full.txt Datei generieren?', 'LLMSTXT_FULL', 'Es wird eine zweite, umfangreichere Datei mit denselben Abschnitten, jedoch mit vollständigen Beschreibungen und Artikelnummern erstellt und aus der Datei <code>llms.txt</code> verlinkt. Nützlich für einen Shop, dessen Produktseiten viele Details enthalten.<br>kann in grossen Shops sehr umfangreich werden', 43),
				('LLMs.txt - llms-full.txt Länge der Beschreibungen', 'LLMSTXT_FULL_LENGTH', 'Längste Beschreibung pro Eintrag in der Datei <code>llms-full.txt</code> in Zeichen.', 43);
				"
            );
            if ($ok === false) {
                return false;
            }
        }
        return true;
    }

    protected function llmstxtRegisterAdminPages($groupId)
    {
        // zen_register_admin_page() performs a plain INSERT, so clear first.
        zen_deregister_admin_pages(self::ADMIN_PAGE_KEYS);

        zen_register_admin_page(
            'configLlmsTxt',
            'BOX_CONFIGURATION_LLMS_TXT',
            'FILENAME_CONFIGURATION',
            'gID=' . (int)$groupId,
            'configuration',
            'Y',
            (int)$groupId
        );

        zen_register_admin_page(
            'toolsLlmsTxt',
            'BOX_TOOLS_LLMS_TXT',
            'FILENAME_LLMS_TXT',
            '',
            'tools',
            'Y',
            80
        );
    }

    /**
     * Write the first llms.txt straight away, so a store that installs and
     * walks off already has one. The configuration constants are not defined
     * yet in this request (they were inserted a moment ago), so the generator
     * sees its defaults, which is exactly what a fresh install has.
     *
     * A failure here is reported, never fatal: the storefront's own check
     * writes the file on the next visit anyway.
     *
     * @return void
     */
    protected function llmstxtFirstBuild()
    {
        global $messageStack;

        try {
            require_once dirname(__DIR__) . '/shared/generator.php';
            $result = llmstxt_publish($this->dbConn, 'install');
        } catch (Throwable $e) {
            $result = ['ok' => false, 'wrote' => [], 'skipped' => [], 'error' => $e->getMessage()];
        }

        if (!isset($messageStack) || !is_object($messageStack)) {
            return;
        }
        if (!empty($result['wrote'])) {
            $messageStack->add_session('Automatischer LLMs.txt Generator: geschrieben ' . implode(', ', array_map('basename', $result['wrote'])) . ' im Shopverzeichnis.', 'success');
        }
        foreach ((array)$result['skipped'] as $note) {
            $messageStack->add_session('Automatischer LLMs.txt Generator: ' . $note, 'caution');
        }
        if (!$result['ok'] && $result['error'] !== '') {
            $messageStack->add_session('Automatischer LLMs.txt Generator: ' . $result['error'] . ' Die Ifoseite unter Tools erklärt die Funktionen.', 'warning');
        }
    }

    /**
     * @return void
     */
    protected function llmstxtRemoveCache()
    {
        try {
            require_once dirname(__DIR__) . '/shared/generator.php';
            foreach ([llmstxt_cache_path(false), llmstxt_cache_path(true), llmstxt_state_path()] as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        } catch (Throwable $e) {
            // Nothing to do; the cache directory is the store's to clear.
        }
    }
}
