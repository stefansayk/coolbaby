# Block-Adventskalender (Webseite)

Ein Adventskalender im Pixel-Look für eure Minecraft-Runde.
Hinter jedem Türchen steckt ein Rätsel. Die Lösung sind **Koordinaten**, an denen ihr im Spiel eine Kiste versteckt habt.
In jeder Kiste liegt ein Puzzleteil (ein Wort), das die Spieler auf der **Schilder-Tafel** eintragen.

## Die zwei Dateien
- `index.html`: die Seite (Aussehen, Kalender, Tafel). Hier steht **nichts Geheimes**.
- `server.php`: alles Geheime: Rätsel, Koordinaten, Verstecke, Schilder-Wörter, Vorschau-Code, Admin-Passwort.
  Die Seite fragt den Server und bekommt immer nur, was heute schon dran ist.

Ihr braucht einen Webspace mit PHP, aber keine Datenbank. Gespeichert wird in `tafel-daten.json`, die der Server selbst anlegt.

## So funktioniert es
- **Türchen:** Türchen *n* geht ab dem *n*. Dezember auf. Erst dann gibt der Server das Rätsel heraus. Wer vorher im Quelltext nachschaut, findet nichts.
- **Lösen:** Die Spieler geben X, Y und Z ein. Der Server prüft die Antwort (±2 Blöcke). Ist sie richtig, kommen die Koordinaten und ein Tipp (`TIPP_STANDARD` in `server.php`): Ist auf der Höhe kein Block, liegt die Kiste beim nächsten Block weiter unten. Der Browser merkt sich gelöste Türchen.
- **Schilder-Tafel:** 23 Schilder, eins pro Puzzleteil. Nur das richtige Wort passt auf das richtige Schild, und alle sehen es nach wenigen Sekunden. Schild *n* lässt sich erst ab dem *n*. Dezember beschriften.
- **Gegen Raten:** Nach jedem Versuch (Koordinaten, Schild oder falscher Code) muss man 3 Sekunden warten.
- **Vorschau-Code:** Unten auf der Seite gibt es „Code eingeben“. Mit dem richtigen Code sind alle Türchen und Schilder sofort benutzbar, gut zum Testen. „Wieder sperren“ macht es rückgängig.
- **Admin:** Unter „Code eingeben“ → „Admin: Tafel leeren“ löscht ihr mit dem Admin-Passwort alle Schilder, z. B. nach dem Testen.

## Anpassen
In **`server.php`** ganz oben (`HIER ANPASSEN`):
- `ADMIN_PASSWORT` **ändern**. Solange es `bitte-aendern` heißt, ist Leeren gesperrt.
- `VORSCHAU_CODE` **ändern**.
- `JAHR`, `TOLERANZ`
- `TIPP_STANDARD`: der Tipp nach jeder richtigen Lösung
- `TAGE`: pro Türchen `art`, `x`, `y`, `z`, `tipp` (leer = Standard-Tipp) und `raetsel` (HTML erlaubt, `[[bin:141]]` zeigt 141 als Redstone-Lampen)
- `RICHTIG`: welches Wort auf welches Schild gehört

In **`index.html`** (`HIER ANPASSEN`) stehen nur noch Titel, Untertitel und das Jahr. Das Jahr muss zu `server.php` passen.

Tipp: Erst die Kisten im Spiel verstecken und die Koordinaten notieren (Java: `F3`), dann die Rätsel so anpassen, dass genau diese Zahlen herauskommen.

## Auf die Webseite bringen
`index.html` **und** `server.php` zusammen in denselben Ordner auf euren Webspace hochladen (z. B. `/adventskalender/`).
Der Ordner muss beschreibbar sein, damit `tafel-daten.json` angelegt werden kann (bei den meisten Webspaces ist das automatisch so).

In eine bestehende Seite einbetten:
```html
<iframe src="/adventskalender/index.html"
        style="width:100%; height:900px; border:0;"
        title="Adventskalender"></iframe>
```

Wer die `index.html` einfach am PC doppelklickt, sieht nur die verschlossenen Türen. Rätsel und Tafel brauchen den Server.
