<?php
/**
 * Automatic LLMs.txt Generator -- admin page strings (German).
 *
 * @package  LlmsTxt
 * @license  https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License v2.0
 */

$define = [
    'HEADING_TITLE' => 'Automatischer LLMs.txt Generator',

    'LLMSTXT_ADMIN_LEAD' => '„llms.txt“ ist eine kurze Markdown-Anleitung für Ihren Shop, die von KI-Assistenten gelesen wird – ähnlich wie Suchmaschinen die Datei „sitemap.xml“ lesen. Diese Seite zeigt an, was veröffentlicht ist, erstellt die Datei auf Anfrage neu und bietet eine Vorschau auf die aktuelle Ausgabe. Der Text stammt aus Ihren Einstellungen unter „Konfiguration“.',

    'LLMSTXT_ADMIN_SECTION_STATUS' => 'Status',
    'LLMSTXT_ADMIN_SECTION_ACTIONS' => 'Aktionen',
    'LLMSTXT_ADMIN_SECTION_REWRITE' => 'Bereitstellen in /llms.txt ohne Datei',
    'LLMSTXT_ADMIN_SECTION_PREVIEW' => 'Vorschau',

    'LLMSTXT_ADMIN_ROW_ENABLED' => 'Plugin',
    'LLMSTXT_ADMIN_ROW_OUTPUT' => 'Veröffentlicht als',
    'LLMSTXT_ADMIN_ROW_REBUILD' => 'Neugenerierungen',
    'LLMSTXT_ADMIN_ROW_FILE' => 'llms.txt Datei',
    'LLMSTXT_ADMIN_ROW_FULL' => 'llms-full.txt Datei',
    'LLMSTXT_ADMIN_ROW_DYNAMIC' => 'Live Seite',
    'LLMSTXT_ADMIN_ROW_LAST_BUILT' => 'zuletzt generiert',
    'LLMSTXT_ADMIN_ROW_CONTENTS' => 'Inhalte',
    'LLMSTXT_ADMIN_ROW_PENDING' => 'Ausstehend',
    'LLMSTXT_ADMIN_ROW_CACHE' => 'Cache Verzeichnis',

    'LLMSTXT_ADMIN_ENABLED' => 'Aktiviert',
    'LLMSTXT_ADMIN_DISABLED' => 'Deaktiviert. Es wird nichts bereitgestellt und keine Datei geschrieben, bis diese Option unter „Konfiguration“ aktiviert wird.',
    'LLMSTXT_ADMIN_OUTPUT_FILE' => 'eine Datei im Shopverzeichnis',
    'LLMSTXT_ADMIN_OUTPUT_DYNAMIC' => 'nur die Live Seite',
    'LLMSTXT_ADMIN_OUTPUT_BOTH' => 'eine Datei im Shopverzeichnis und die Live Seite',
    'LLMSTXT_ADMIN_REBUILD_CHANGE' => 'bei Artikeländerungen',
    'LLMSTXT_ADMIN_REBUILD_DAILY' => 'täglich',
    'LLMSTXT_ADMIN_REBUILD_WEEKLY' => 'wöchentlich',
    'LLMSTXT_ADMIN_REBUILD_MONTHLY' => 'monatlich',
    'LLMSTXT_ADMIN_REBUILD_MANUAL' => 'nur wenn Sie Neu Generieren anclicken',
    'LLMSTXT_ADMIN_REBUILD_NOTE' => 'Automatische Neugenerierungen finden bei einem Besuch des Shop Frontends statt, höchstens einmal alle fünfzehn Minuten, sodass niemand im Admin-Bereich darauf warten muss.',

    'LLMSTXT_ADMIN_FILE_PRESENT' => 'Derzeit, %s bytes, geschrieben %s.',
    'LLMSTXT_ADMIN_FILE_ABSENT' => 'Nicht vorhanden.',
    'LLMSTXT_ADMIN_FILE_ABSENT_EXPECTED' => 'Noch nicht vorhanden. Clicken Sie auf Neu Generieren oder rufen Sie das Shop Frontend auf.',
    'LLMSTXT_ADMIN_FILE_NOT_WANTED' => 'Wird bei dieser Ausgabeeinstellung nicht verwendet.',
    'LLMSTXT_ADMIN_FILE_FOREIGN' => 'Eine Datei, die dieses Plugin nicht erstellt hat, ist bereits vorhanden. Sie wurde unverändert belassen. Verwenden Sie „Ersetzen“, wenn Sie lieber die generierte Datei haben möchten.',
    'LLMSTXT_ADMIN_FILE_UNWRITABLE' => 'Das Stammverzeichnis des Shops ist für den Webserver nicht beschreibbar, daher kann die Datei nicht geschrieben werden. Machen Sie es entweder beschreibbar oder wechseln Sie zur Live-Seite in den Ausgabeeinstellungen und fügen Sie die folgende Rewrite-Regel hinzu.',
    'LLMSTXT_ADMIN_FILE_STALE' => 'Es steht eine Änderung an; die Datei wird bei der nächsten Frontend-Prüfung neu erstellt – oder sofort, wenn Sie auf „Neu generieren“ klicken.',

    'LLMSTXT_ADMIN_DYNAMIC_ON' => 'Wird unter %s bereitgestellt. Mit der folgenden Umschreibungsregel wird die Anfrage auch unter %s beantwortet.',
    'LLMSTXT_ADMIN_DYNAMIC_OFF' => 'Verfügbar unter %s, sobald das Plugin aktiviert ist, unabhängig von den Ausgabeeinstellungen.',

    'LLMSTXT_ADMIN_NEVER' => 'Nie.',
    'LLMSTXT_ADMIN_BUILT_AT' => '%s (%s).',
    'LLMSTXT_ADMIN_COUNTS' => '%d Infoseiten, %d Kategorien, %d Marken, %d Artikel, %d EZ-Pages.',
    'LLMSTXT_ADMIN_PENDING_NONE' => 'Nichts. Die veröffentlichte Ausgabe stimmt mit dem Katalog und den Einstellungen überein.',
    'LLMSTXT_ADMIN_PENDING_SOME' => 'Es ist Zeit für eine Überholung: %s.',
    'LLMSTXT_ADMIN_CACHE_OK' => '%s ist beschreibbar.',
    'LLMSTXT_ADMIN_CACHE_BAD' => '%s ist nicht beschreibbar. Die Live-Seite funktioniert zwar noch, aber jede Anfrage wird neu generiert, und der Zeitplan für die Neugenerierung lässt sich nicht nachverfolgen.',
    'LLMSTXT_ADMIN_LAST_ERROR' => 'Die zuletzt gemeldete Version: %s',

    'LLMSTXT_ADMIN_BUTTON_REGENERATE' => 'Jetzt neu generieren',
    'LLMSTXT_ADMIN_BUTTON_REPLACE' => 'Bestehende Datei ersetzen',
    'LLMSTXT_ADMIN_BUTTON_REMOVE' => 'Generierte Dateien entfernen',
    'LLMSTXT_ADMIN_BUTTON_SETTINGS' => 'Einstellungen',
    'LLMSTXT_ADMIN_BUTTON_OPEN' => 'Liveseite anzeigen',
    'LLMSTXT_ADMIN_BUTTON_OPEN_FILE' => 'Öffne /llms.txt',
    'LLMSTXT_ADMIN_CONFIRM_REPLACE' => 'Soll die Datei „llms.txt“, die sich bereits im Stammverzeichnis des Shops befindet, durch die generierte Datei ersetzt werden? Die vorhandene Datei wird dabei überschrieben.',
    'LLMSTXT_ADMIN_CONFIRM_REMOVE' => 'Sollen „llms.txt“ und „llms-full.txt“ aus dem Stammverzeichnis des Shops entfernt werden? Es werden nur Dateien entfernt, die von diesem Plugin geschrieben wurden.',

    'LLMSTXT_ADMIN_REWRITE_INTRO' => 'Wenn Sie lieber keine Datei im Stammverzeichnis des Shops haben möchten oder das Stammverzeichnis nicht beschreibbar ist, sorgt eine Zeile in der .htaccess-Datei des Shops dafür, dass /llms.txt (und /llms-full.txt) stattdessen von der Live-Seite aus bereitgestellt werden. Fügen Sie diese Zeile nach <code>RewriteEngine On</code> ein; die shop-eigenen Regeln, sofern vorhanden, bleiben davon unberührt.',
    'LLMSTXT_ADMIN_REWRITE_NOTE' => 'Eine Datei im Stammverzeichnis hat auf den meisten Servern Vorrang vor der Umschreibungsregel. Wenn die Ausgabe also auf „beides“ eingestellt ist, wird den Besuchern die Datei angezeigt, und die Live-Seite dient als Ausweichlösung.',

    'LLMSTXT_ADMIN_PREVIEW_INTRO' => 'Wurde anhand des aktuellen Katalogs und der aktuellen Einstellungen speziell für diese Seite neu erstellt. Dies ist der Inhalt, der beim nächsten Neuaufbau veröffentlicht wird; es handelt sich nicht um die veröffentlichte Version selbst.',
    'LLMSTXT_ADMIN_PREVIEW_SIZE' => '%s Zeichen.',

    'LLMSTXT_ADMIN_SUCCESS_REBUILT' => 'Neu generiert: %s',
    'LLMSTXT_ADMIN_SUCCESS_WROTE' => 'Geschrieben: %s.',
    'LLMSTXT_ADMIN_SUCCESS_REMOVED' => 'Entfernt: %s.',
    'LLMSTXT_ADMIN_NOTHING_REMOVED' => 'Nichts zu entfernen.',
    'LLMSTXT_ADMIN_SKIPPED' => 'Übersprungen: %s.',
    'LLMSTXT_ADMIN_ERROR_BUILD' => 'Das Generieren wurde nicht abgeschlossen: %s',
    'LLMSTXT_ADMIN_ERROR_DISABLED' => 'Das Plugin ist unter „Konfiguration“ deaktiviert, daher wurde nichts veröffentlicht. Die Vorschau unten zeigt dennoch, wie das Ergebnis aussehen würde.',
];

return $define;
