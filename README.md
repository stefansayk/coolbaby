# Mythic Legenden (Fabric-Mod für Minecraft 26.2)

Sechs einzigartige legendäre Waffen. Jede kann pro Welt nur **ein einziges Mal** geschmiedet werden.
Nur die sechs Legenden sehen besonders aus, alle normalen Waffen bleiben wie im normalen Minecraft.

## Installation
1. [Fabric Loader](https://fabricmc.net/use/) für Minecraft **26.2** installieren.
2. [Fabric API](https://modrinth.com/mod/fabric-api) (Version für 26.2) in den Ordner `.minecraft/mods` legen.
3. `mythic-legenden-1.0.0.jar` ebenfalls in `.minecraft/mods` legen.
4. Auf einem Server: Fabric + Fabric API + diese Mod auf dem Server **und** bei jedem Spieler.

Kein extra Texture Pack und kein Datapack nötig, alles steckt in der Mod.
Das alte Datapack bitte aus der Welt entfernen, damit nichts doppelt läuft.

## Steuerung
- **X**: erste aktive Fähigkeit der Legende in der Hand
- **Schleichen + X**: zweite aktive Fähigkeit
- Die Taste lässt sich unter Optionen › Steuerung › Mythic Legenden ändern.

## Befehle
- `/trigger mythic.status`: welche Legenden schon geschmiedet sind
- `/function mythic:admin/reset/<name>`: Legende wieder freigeben (Admin)
- `/function mythic:admin/test/<name>`: Testexemplar (Admin)

## Selbst bauen
`./gradlew build` (Java 25). Die fertige Datei liegt in `build/libs/`.
Bei jedem Push baut GitHub Actions die Mod automatisch (Reiter *Actions* → letzter Lauf → *Mythic-Legenden-Mod*).
