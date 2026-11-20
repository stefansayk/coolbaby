# Block-Adventskalender (Webseite)

Ein Adventskalender im Pixel-Look für eure Minecraft-Runde.
Hinter jedem Türchen steckt ein Rätsel. Die Lösung sind **Koordinaten**, an denen ihr im Spiel eine Kiste versteckt habt.

Alles steckt in **einer einzigen Datei**: `index.html`. Es braucht keinen Server, keine Datenbank und keine Installation.

## So funktioniert es
- Türchen *n* lässt sich erst ab dem *n*. Dezember öffnen. Davor wackelt es und zeigt an, wie viele Tage es noch dauert.
- Die Spieler geben X, Y und Z ein. Ist alles richtig (±2 Blöcke), erscheinen die Koordinaten und euer Zusatzhinweis zum Versteck.
- Der Browser merkt sich, welche Türchen schon offen bzw. gelöst sind (pro Gerät).

## Anpassen
Öffnet `index.html` in einem Texteditor und sucht nach **`HIER ANPASSEN`**:

- `jahr`: in welchem Dezember der Kalender läuft
- `toleranz`: wie viele Blöcke daneben noch als richtig zählen
- `vorschauCode`: Geheimcode. Unten auf der Seite gibt es den Knopf **„Code eingeben“**: Wer den Code eintippt, bekommt sofort alle Türchen frei (das Gerät merkt sich das, „Wieder sperren“ macht es rückgängig). Alternativ geht `index.html?vorschau=DEINCODE`. **Ändert den Code!**
- Pro Tag: `raetsel`, `x`, `y`, `z`, `tipp`

Tipp: Erst die Kisten im Spiel verstecken und die Koordinaten notieren (Java: `F3`), dann die Rätsel so anpassen, dass genau diese Zahlen herauskommen.

`[[bin:141]]` im Rätseltext zeigt die Zahl 141 als Reihe von Redstone-Lampen (Binärcode).

## Auf die Webseite bringen
**Variante A: als eigene Seite.** `index.html` auf euren Webspace hochladen (z. B. in einen Ordner `/adventskalender/`).

**Variante B: in eine bestehende Seite einbetten.**
```html
<iframe src="/adventskalender/index.html"
        style="width:100%; height:900px; border:0;"
        title="Adventskalender"></iframe>
```

## Gut zu wissen
Die Lösungen stehen im Quelltext der Seite. Wer im Browser „Seitenquelltext anzeigen“ benutzt, könnte schummeln.
Für eine Runde unter Freunden reicht das meistens. Wenn ihr das verhindern wollt, braucht es einen kleinen Server, der die Antworten prüft.
