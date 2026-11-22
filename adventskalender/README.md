# Block-Adventskalender (Webseite)

Ein Adventskalender im Pixel-Look für eure Minecraft-Runde.
Hinter jedem Türchen steckt ein Rätsel. Die Lösung sind **Koordinaten**, an denen ihr im Spiel eine Kiste versteckt habt.

Die Seite besteht aus **zwei Dateien**:
- `index.html`: der Kalender mit allen Rätseln
- `tafel.php`: speichert die Schilder-Tafel, damit alle Spieler dasselbe sehen (braucht einen Webspace mit PHP, keine Datenbank)

## So funktioniert es
- Türchen *n* lässt sich erst ab dem *n*. Dezember öffnen. Davor wackelt es und zeigt an, wie viele Tage es noch dauert.
- Die Spieler geben X, Y und Z ein. Ist alles richtig (±2 Blöcke), erscheinen die Koordinaten und euer Zusatzhinweis zum Versteck.
- Der Browser merkt sich, welche Türchen schon offen bzw. gelöst sind (pro Gerät).

## Die Schilder-Tafel
Unter dem Kalender hängen 23 Schilder, eins für jedes Puzzleteil. Wer ein Teil gefunden hat, klickt auf das Schild mit der Nummer, schreibt das Wort drauf und wählt eine von 16 Farben.
- Alle Besucher sehen die Schilder nach wenigen Sekunden, ohne neu zu laden.
- Darunter steht der ganze Satz, so weit er schon bekannt ist, und eine Liste, wer zuletzt was geschrieben hat.
- Gespeichert wird in `tafel-daten.json`. Die Datei legt `tafel.php` beim ersten Eintrag selbst an.
- **Admin-Passwort** in `tafel.php` ändern (`ADMIN_PASSWORT`). Damit kann man unten auf der Seite über „Code eingeben“ → „Admin: Tafel leeren“ alle Schilder löschen. Solange es `bitte-aendern` heißt, ist Leeren gesperrt.

## Anpassen
Öffnet `index.html` in einem Texteditor und sucht nach **`HIER ANPASSEN`**:

- `jahr`: in welchem Dezember der Kalender läuft
- `toleranz`: wie viele Blöcke daneben noch als richtig zählen
- `vorschauCode`: Geheimcode. Unten auf der Seite gibt es den Knopf **„Code eingeben“**: Wer den Code eintippt, bekommt sofort alle Türchen frei (das Gerät merkt sich das, „Wieder sperren“ macht es rückgängig). Alternativ geht `index.html?vorschau=DEINCODE`. **Ändert den Code!**
- Pro Tag: `raetsel`, `x`, `y`, `z`, `tipp`

Tipp: Erst die Kisten im Spiel verstecken und die Koordinaten notieren (Java: `F3`), dann die Rätsel so anpassen, dass genau diese Zahlen herauskommen.

`[[bin:141]]` im Rätseltext zeigt die Zahl 141 als Reihe von Redstone-Lampen (Binärcode).

## Auf die Webseite bringen
**Variante A: als eigene Seite.** `index.html` **und** `tafel.php` zusammen in denselben Ordner auf euren Webspace hochladen (z. B. `/adventskalender/`). Der Ordner muss beschreibbar sein, damit `tafel-daten.json` angelegt werden kann (bei den meisten Webspaces ist das automatisch so).

**Variante B: in eine bestehende Seite einbetten.**
```html
<iframe src="/adventskalender/index.html"
        style="width:100%; height:900px; border:0;"
        title="Adventskalender"></iframe>
```

## Gut zu wissen
Die Lösungen stehen im Quelltext der Seite. Wer im Browser „Seitenquelltext anzeigen“ benutzt, könnte schummeln.
Für eine Runde unter Freunden reicht das meistens. Wenn ihr das verhindern wollt, braucht es einen kleinen Server, der die Antworten prüft.
