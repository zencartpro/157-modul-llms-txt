# 157-modul-llms-txt
Automatischer LLMs.txt-Generator für die deutsche Zen Cart Version 1.5.7k

## Hinweis: 
Freigegebene getestete Versionen für den Einsatz in Livesystemen ausschließlich unter Releases herunterladen:
* https://github.com/zencartpro/157-modul-llms-txt/releases

## Credits:
* Dieses Modul ist eine Übersetzung und Anpassung des amerikanischen LLMs.txt-Generator Moduls von dbltoe für die deutsche Zen Cart Version
* Grundlage war das entsprechende Github Repository:
* https://github.com/dbltoe/Automatic_LLMs_Txt_Generator

## Sinn und Zweck

Veröffentlichen Sie eine „llms.txt“-Datei für Ihren Shop: die kurze Markdown-Anleitung, die KI-Assistenten lesen, um eine Website zu verstehen – erstellt aus Ihrem eigenen Shop und automatisch auf dem neuesten Stand gehalten.

Eine `llms.txt`-Datei ist für KI-Assistenten das, was `sitemap.xml` für Suchmaschinen ist: eine einfache Textdatei im Stammverzeichnis Ihrer Website, die in Markdown und gemäß der Konvention von llmstxt.org (https://llmstxt.org/) beschreibt, worum es auf der Website geht und wo sich die wichtigen Seiten befinden. Dieses Plugin erstellt eine solche Datei für Ihren Shop auf Basis der bereits in Zen Cart vorhandenen Daten und hält sie auf dem neuesten Stand.

Die erzeugte Datei sieht wie folgt aus:

```
# Demoshop

> Demoshop verkauft Ersatzteile und Werkzeuge für Vintage-Küchenmixer
> und versendet von Wien aus in alle EU-Staaten.

- [Website](https://www.meinshop.de/)
- Preise in: EUR
- [Sitemap](https://www.meinshop.de/sitemap.xml)
- [Robots](https://www.meinshop.de/robots.txt)

## Shopinformationen

- [Versandkosten](https://www.meinshop.de/index.php?main_page=shippinginfo)
- [Datenschutzerklärung](https://www.meinshop.de/index.php?main_page=privacy)
- [AGB](https://www.meinshop.de/index.php?main_page=conditions)
- [Kontakt](https://www.meinshop.de/index.php?main_page=contact_us)

## Kategorien

- [Mixer-Ersatzteile](https://www.meinshop.de/index.php?main_page=index&cPath=1): Zahnräder, Dichtungen und Rührbesen für alle Modelle seit 1937.
- [Mixer-Ersatzteile > Dichtungen](https://www.meinshop.de/index.php?main_page=index&cPath=1_4)

## Marken

- [Hobart](https://www.meinshop.de/index.php?main_page=index&manufacturers_id=2): 14 Artikel

## Artikel

- [Planetengetriebe, Modell K](https://www.meinshop.de/index.php?main_page=product_info&products_id=12): Ersatzzahnrad aus Bronze für das Modell K. Passend für die Baujahre 1948 bis 1962. (24,95 €)

## Weitere Seiten

- [Über uns](https://www.meinshop.de/index.php?main_page=page&id=3)
```

Jeder Teil davon stammt aus einem Bereich, den Sie bereits pflegen: der Shop-Name, die Seiten zu Versand und AGB, die Kategoriehierarchie, Ihre Marken mit der jeweiligen Artikelanzahl, aktivierte Artikel mit ihren Meta-Tags oder Textbeschreibungen und Grundpreisen sowie Ihre veröffentlichten EZ-Seiten. Die Sitemap und die `robots.txt` werden verlinkt, sofern der Shop über diese verfügt. Das Einzige, was es sich lohnt, von Hand zu schreiben, ist die Zusammenfassung im Blockzitat, da dies der erste Satz ist, den ein Assistent liest. Dafür gibt es eine entsprechende Einstellung.

Namen und Beschreibungen werden beim Ausgeben mit Markdown-Escape-Zeichen versehen, sodass ein Artikel namens „50 % Rabatt [Sale]“ oder eine Marke namens „Model_K“ so angezeigt wird, wie es geschrieben wurde, anstatt zu einem defekten Link oder ungewollter Kursivschrift zu werden. Deine eigene Zusammenfassung und deine Notizen bilden hier eine Ausnahme: Sie werden so weitergegeben, wie du sie geschrieben hast – einschließlich Markdown.

Optional wird auch die Datei `llms-full.txt` erstellt, die dieselben Abschnitte mit vollständigen Beschreibungen enthält – für Assistenten, die detaillierte Informationen benötigen.

## Voraussetzungen

*Dieses Modul kann nur in Zen Cart 1.5.7k deutsch verwendet werden. 
*Stellen Sie sicher, dass Sie Ihren Shop auf die neueste 1.5.7k Version aktualisiert haben, bevor Sie dieses Modul installieren.


## Installation

1. Laden Sie das Verzeichnis `zc_plugins/LlmsTxt/` so hoch, dass es unter `<Stammverzeichnis Ihres Shops>/zc_plugins/LlmsTxt/v1.0.4/` abgelegt wird. Nichts wird an einem anderen Ort abgelegt: keine Dateien in `admin/`, `includes/` oder Ihrem Template.
2. Gehen Sie in Ihrem Admin-Bereich zu **Module → Plugin-Manager**, wählen Sie **Automatic LLMs.txt Generator** aus und klicken Sie auf **Installieren**.

Das Installationsprogramm erstellt eine Konfigurationsgruppe unter **Konfiguration → Automatischer LLMs.txt Generator**, fügt **Automatischer LLMs.txt Generator** zum Menü **Tools** hinzu und legt sofort eine erste `llms.txt` im Stammverzeichnis des Shops an, sofern dies möglich ist. Sollte das Stammverzeichnis nicht beschreibbar sein, wird dies angezeigt, und auf der Seite „Tools“ wird die Alternative erläutert.

Nach der Installation kann ein Superuser diese Anleitung über die Schaltfläche **Anleitung** im Plugin-Manager öffnen.

## Schnellstart

1. Öffnen Sie **Konfiguration → Automatischer LLMs.txt-Generator** und schreiben Sie ein oder zwei Sätze in **Shop-Zusammenfassung**: Was Sie verkaufen und für wen es bestimmt ist.
2. Öffnen Sie **Tools → Automatischer LLMs.txt-Generator**. Die Statustabelle zeigt an, ob die Datei vorhanden ist, und die Vorschau zeigt genau, was veröffentlicht wird. Klicken Sie auf **Jetzt neu generieren**.
3. Öffnen Sie `https://www.meinshop.de/llms.txt` in einem Browser. Das ist der Text, den ein Assistent lesen wird.

Das ist alles, was ein typischer Shop benötigt. Die Standardeinstellungen listen alle erreichbaren Kategorien, die ersten 200 Artikel in ihrer Sortierreihenfolge mit Preisen, die Standard-Informationsseiten sowie Ihre EZ-Pages auf und werden bei jeder Änderung des Datenbestands neu generiert.

## Zwei Möglichkeiten zum Veröffentlichen

Die Einstellung **Art der Veröffentlichung** legt fest, woher die Datei stammt.

| Einstellung | Was passiert | Voraussetzungen |
| --- | --- | --- |
| Datei | Eine echte `llms.txt`-Datei wird im Stammverzeichnis des Shops neben `robots.txt` geschrieben. Dies ist die Standardeinstellung und funktioniert ohne weitere Konfiguration. | Das Stammverzeichnis des Shops muss für den Webserver beschreibbar sein. Bei einem cPanel-Host ist dies in der Regel der Fall. |
| dynamisch | Die Datei wird live über die Shop-Startseite `index.php?main_page=llms_txt` bereitgestellt. Im Stammverzeichnis wird nichts geschrieben. | Drei Zeilen müssen dazu in die Datei `.htaccess`, damit `/llms.txt` zu dieser Seite führt. Diese werden auf der Seite „Tools“ angezeigt. |
| beides | Die Datei wird geschrieben, und die Live-Seite bleibt als Fallback verfügbar. | Beides wie oben beschrieben. |

Die Live-Seite ist immer vorhanden, wenn das Plugin aktiviert ist, unabhängig von dieser Einstellung. Sie können also jederzeit unter `index.php?main_page=llms_txt` die aktuelle Ausgabe einsehen. Es wird eine gerenderte Kopie im Verzeichnis `cache/` des Shops gespeichert und nach denselben Regeln wie die Datei neu erstellt, sodass ein Crawler nie auf einen Build warten muss.

### Die Rewrite Regel

Für **dynamische** Inhalte (oder als Fallback bei **beiden**) fügen Sie diese Zeilen in die Datei `.htaccess` im Stammverzeichnis Ihres Shops ein, nach `RewriteEngine On`, falls dort bereits eine vorhanden ist:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^llms\.txt$ index.php?main_page=llms_txt [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^llms-full\.txt$ index.php?main_page=llms_txt&full=1 [L]
```

Die Bedingung `!-f` bedeutet, dass eine tatsächlich vorhandene Datei im Stammverzeichnis immer Vorrang hat, sodass ein späterer Wechsel zwischen den Modi keine Änderung an diesen Zeilen erfordert. Befindet sich Ihr Shop in einem Unterverzeichnis, funktioniert die Regel dennoch, da `.htaccess`-Regeln relativ zu ihrem eigenen Verzeichnis gelten.

## Wann erfolgt die Neuerstellung?

Die Einstellung **„Wann neu generieren“** ermöglicht es, die Datei immer auf dem neuesten Stand zu halten, ohne dass jemand daran denken muss, einen Knopf zu drücken.

| Einstellung | Wann neu generieren |
| --- | --- |
| Änderung | Wenn ein Artikel, eine Kategorie oder eine EZ-Page im Admin-Bereich gespeichert wird. Der Shop vergleicht außerdem alle fünfzehn Minuten einen Fingerabdruck des Katalogs (Anzahlen und Zeitpunkte der letzten Änderung) und führt eine Neugenerierung durch, falls sich dieser verschoben hat; dadurch werden Löschungen und Statusänderungen erfasst, die an den Angeboten vorgenommen wurden. Dies ist die Standardeinstellung. |
| täglich / wöchentlich / monatlich | In diesem Zeitraum nach dem letzten Neuaufbau sowie nach einer Speicherung im Admin-Bereich. |
| manuell | Nur, wenn Sie auf der Seite „Tools“ auf **Jetzt neu generieren** klicken. |

Für jede Einstellung gilt Folgendes: Das Ändern einer beliebigen Einstellung in dieser Gruppe löst eine Neuerstellung aus, und die eigentliche Arbeit erfolgt beim nächsten Besuch des *Shop-Frontends* und nicht im Admin-Bereich, höchstens einmal alle fünfzehn Minuten. Ein Speichern im Admin-Bereich setzt lediglich ein Flag, sodass das Speichern eines Artikels so schnell ist wie eh und je. Wenn niemand das Frontend besucht, benötigt auch niemand eine neue Datei.

Zen Cart verfügt über keinen eigenen Scheduler, weshalb dies über den Shop-Bereich erfolgt. Wenn Sie den Vorgang lieber über einen echten Cron-Job steuern möchten, rufen Sie `index.php?main_page=llms_txt` über Cron mit `curl` oder `wget` auf; diese Anfrage führt dieselbe Überprüfung durch.

## Einstellungen

Alle Einstellungen befinden sich unter **Konfiguration → Automatischer LLMs.txt-Generator**.

| Einstellung | Standard | Anmerkungen |
| --- | --- | --- |
| LLMs.txt aktivieren | true | Aus: Die Live-Seite gibt einen 404-Fehler zurück und es wird keine Datei geschrieben oder aktualisiert. Eine bereits im Stammverzeichnis vorhandene Datei bleibt unverändert. |
| Veröffentlichen als | Datei | Siehe „Zwei Möglichkeiten zum Veröffentlichen“. |
| Neu erstellen | Änderung | Siehe „Wann wird neu erstellt?“. |
| Zusammenfassung speichern | leer | Das Zitat. Fügen Sie diesen Eintrag ein. Bleibt er leer, wird „*Shop-Name* ist ein Online-Shop.“ verwendet. |
| Zusätzliche Hinweise | leer | Absätze nach der Zusammenfassung: Versandgebiete, Lieferzeiten, Mindestbestellwert. Markdown ist erlaubt und wird unverändert übernommen. |
| Informationsseiten | shippinginfo, privacy, conditions, contact_us, site_map | Seitennamen, durch Kommas getrennt, in der angegebenen Reihenfolge. Integrierte Seiten erhalten automatisch eine Bezeichnung; geben Sie nach einem Doppelpunkt eine eigene an: `about_us:Über unser Unternehmen`. Wenn das Feld leer bleibt, wird der Abschnitt weggelassen. |
| Kategorien auflisten | true | Jede Kategorie als „Übergeordnete > Untergeordnete“ mit ihrer Beschreibung. Deaktivierte Kategorien und alles darunter werden übersprungen. |
| Kategorietiefe | 0 | 0 listet jede Ebene auf; 1 listet nur Kategorien der obersten Ebene auf; und so weiter. |
| Kategorien ausschließen | leer | Kategorie-IDs, die zusammen mit ihren Unterkategorien und allen Produkten, deren Hauptkategorie eine davon ist, ausgelassen werden sollen. Praktisch für eine Kategorie für Geschenkgutscheine oder Ausverkaufsartikel. |
| Produkte auflisten | true | Nur aktivierte Produkte, deren übergeordnete Kategorie erreichbar ist. |
| Maximale Anzahl an Produkten | 200 | 0 bedeutet alle. Die Sortiereinstellung entscheidet, welche Produkte berücksichtigt werden. |
| Produktreihenfolge | sort | sort (die Produktsortierreihenfolge, dann Name), neueste, Bestseller, Name, angesehen. |
| Preise anzeigen | true | Der Grundpreis in der Standardwährung. Sonderangebote und Steuern werden nicht berücksichtigt. |
| Länge der Beschreibung | 160 | Zeichen pro Zeile. Es wird die Meta-Tag-Beschreibung verwendet, sofern vorhanden; andernfalls der Anfang des Fließtextes ohne HTML-Code. |
| Marken auflisten | true | Hersteller mit mindestens einem aktivierten Produkt, jeweils verlinkt auf ihre Produktliste mit einer Stückzahl. Eine Marke, deren Produkte sich alle in versteckten oder ausgeschlossenen Kategorien befinden, wird ausgelassen. |
| EZ-Seiten auflisten | true | Veröffentlichte Seiten, die in der Kopfzeile, einer Seitenleiste, der Fußzeile oder im Inhaltsverzeichnis erscheinen. Seiten mit externen Links verweisen auf die jeweiligen Ziele. |
| Sitemap-Adresse | leer | Wird leer gelassen, wird automatisch auf eine `sitemap.xml` im Stammverzeichnis verlinkt, sofern vorhanden. Eine `robots.txt` im Stammverzeichnis wird auf dieselbe Weise verlinkt; hierfür gibt es keine eigene Einstellung. |
| Sprache | leer | Zweibuchstiger Code. Wenn das Feld leer ist, wird die Shop-Standardeinstellung verwendet. |
| Auch „llms-full.txt“ veröffentlichen | false | Eine zweite, längere Datei mit vollständigen Beschreibungen und Modellnummern, die von „llms.txt“ aus verlinkt wird. |
| Länge der vollständigen Beschreibung | 1200 | Zeichen pro Eintrag in „llms-full.txt“. |

## Die Seite „Tools“

**Tools → Automatischer LLMs.txt-Generator** zeigt in einer Tabelle an: ob das Plugin aktiviert ist, wie es veröffentlicht, wann es neu erstellt wird, ob die Datei im Stammverzeichnis vorhanden ist und von diesem Plugin geschrieben wurde, wann der letzte Build lief und was dabei festgestellt wurde, ob ein Neuaufbau ansteht und warum sowie ob das Cache-Verzeichnis beschreibbar ist. Darunter:

- **Jetzt neu generieren** erstellt und veröffentlicht sofort.
- **Vorhandene Datei ersetzen** erscheint nur, wenn sich im Stammverzeichnis eine `llms.txt` befindet, die nicht von diesem Plugin erstellt wurde. Siehe den nächsten Abschnitt.
- **Generierte Dateien entfernen** löscht `llms.txt` und `llms-full.txt` aus dem Stammverzeichnis, sofern sie von diesem Plugin erstellt wurden.
- **Einstellungen**, **Live-Seite öffnen** und **/llms.txt öffnen** führen dorthin, was die Bezeichnungen vermuten lassen.

Die Vorschau unten wird bei jedem Laden der Seite neu aus dem aktuellen Katalog und den aktuellen Einstellungen erstellt, sodass sie immer anzeigt, was beim nächsten Build veröffentlicht wird.

## Wenn Sie bereits eine `llms.txt` haben

Eine manuell erstellte `llms.txt` im Stammverzeichnis des Shops wird niemals überschrieben. Das Plugin erkennt seine eigenen Dateien anhand einer Markierungszeile am Ende und anhand des Hash-Werts, den es beim Schreiben aufgezeichnet hat; alles andere bleibt unberührt – dies wird auf der Seite „Tools“ angegeben –, und die automatischen Neuerstellungen überspringen die Datei, bis Sie eine Entscheidung treffen. Klicken Sie auf **„Vorhandene Datei ersetzen“**, damit die generierte Datei die alte ablöst, oder stellen Sie **„Veröffentlichen als“** auf **„dynamisch“** um und behalten Sie Ihre Datei bei, da eine tatsächlich vorhandene Datei Vorrang vor der Umschreibungsregel hat.

## SEO-URL-Plugins

Wenn die Datei über die Shop-Oberfläche erstellt wird – wo jeder automatische Neuaufbau stattfindet –, werden Links mit `zen_href_link()` erstellt, sodass ein SEO-URL-Plugin diese genauso gestaltet wie jeden anderen Link auf der Website. Ein vom Admin-Bereich aus ausgelöster Aufbau (über „Neu generieren“ oder die Installation) verwendet einfache Adressen im Format `index.php?main_page=`, da die eigene Linkfunktion des Admin-Bereichs Admin-Adressen erstellt. Beide Formen werden in einem Shop mit einem solchen Plugin aufgelöst, und der nächste Storefront-Neuaufbau ersetzt die einfachen Adressen.

## robots.txt

Es muss nichts hinzugefügt werden, und falls vorhanden, verweist `llms.txt` darauf. Wenn Ihre `robots.txt` für bestimmte Crawler den Zugriff auf `index.php` oder Query-Strings verbietet, dürfen diese möglicherweise die Live-Seite nicht abrufen; eine echte Datei im Stammverzeichnis ist von solchen Regeln nicht betroffen, was ein Grund dafür ist, dass **Datei** die Standardeinstellung ist.

## Übersetzung

Die Wörter, die in der generierten Datei erscheinen (Abschnittsüberschriften, „Website“, „Preise in“, die Bezeichnungen für die integrierten Informationsseiten), stammen aus zwei Sprachdateien, eine pro Seite, da die Datei aus beiden erstellt werden kann:

```
catalog/includes/languages/german/extra_definitions/lang.llms_txt.php
admin/includes/languages/german/extra_definitions/lang.llms_txt_names.php
```

Kopieren Sie jede Datei in das entsprechende Verzeichnis für Ihre Sprache innerhalb dieses Plugins und übersetzen Sie die Werte. Die eigenen Strings der Admin-Seite befinden sich in `admin/includes/languages/english/lang.llms_txt.php`. Jede Datei verwendet das Array-Format, das seit Zen Cart v1.5.7k deutsch verstanden wird.

## Aktualisieren

Laden Sie das Verzeichnis der neuen Version neben das alte hoch und klicken Sie im Plugin-Manager auf **Aktualisieren**. Von Ihnen geänderte Einstellungen bleiben erhalten; nur Bezeichnungen, Hilfetexte und Standardwerte für neue Einstellungen werden aktualisiert. Entfernen Sie anschließend das Verzeichnis der alten Version.

## Deinstallation

Die Funktion **Deinstallieren** im Plugin-Manager entfernt die Konfigurationsgruppe, die Menüeinträge und den Cache. Die im Stammverzeichnis des Shops generierte Datei `llms.txt` bleibt absichtlich erhalten: Es handelt sich um eine öffentliche Datei, die Assistenten möglicherweise bereits kennen, und sie funktioniert auch ohne das Plugin weiter. Klicken Sie zunächst auf der Seite „Extras“ auf **Generierte Dateien entfernen**, wenn Sie diese Datei löschen möchten.

## Fehlerbehebung

### Auf der Seite „Tools“ wird angezeigt, dass das Stammverzeichnis des Shops nicht beschreibbar ist

Der Webserver kann keine Dateien in dem Verzeichnis erstellen, in dem sich `index.php` befindet. Auf einem cPanel-Host mit suPHP oder LSAPI ist dies normalerweise möglich; auf anderen Hosts müssen Sie das Verzeichnis für die Gruppe beschreibbar machen oder Ihren Host anfragen. Oder stellen Sie **Veröffentlichen als** auf **dynamisch** um und fügen Sie die Rewrite-Regel hinzu: Dann wird keine Datei benötigt.

### /llms.txt liefert im dynamischen Modus einen 404-Fehler

Die Rewrite-Regel fehlt oder steht vor `RewriteEngine On`. Überprüfen Sie zunächst, ob `index.php?main_page=llms_txt` funktioniert; wenn ja, ist die Regel das einzige, was noch fehlt.

### Die Datei wird nie aktualisiert

Stellen Sie sicher, dass **Neu erstellen** nicht auf **manuell** eingestellt ist, und sehen Sie sich dann die Zeile **Ausstehend** auf der Seite „Tool“ an. Wenn dort steht, dass eine Neuerstellung fällig ist, wurde das Frontend seitdem einfach nicht mehr aufgerufen; öffnen Sie eine beliebige Seite des Shops und schauen Sie erneut nach. Wenn die Zeile **Cache-Verzeichnis** rot ist, kann das Plugin nicht erfassen, wann es zuletzt geprüft hat; machen Sie daher `cache/` beschreibbar, was Zen Cart ohnehin benötigt.

### Ein Artikel fehlt

Er ist deaktiviert, seine Hauptkategorie oder eine der übergeordneten Kategorien dieser Kategorie ist deaktiviert oder ausgeschlossen, es hat keinen Namen in der ausgewählten Sprache oder es überschreitet die **maximale Produktanzahl** in der ausgewählten Reihenfolge. Die Vorschau auf der Seite „Tools“ zeigt all diese Fälle sofort an.

### Die Links sind „index.php“-Adressen, obwohl der Shop SEO-URLs verwendet

Der letzte Build wurde über den Admin-Bereich ausgeführt. Siehe SEO-URL-Plugins; der nächste Neuaufbau des Shops behebt das Problem, oder Sie unternehmen gar nichts und warten auf einen solchen.

