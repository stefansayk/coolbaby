<?php
/* =========================================================================
   Server für den Block-Adventskalender
   -------------------------------------------------------------------------
   Hier steht alles, was die Spieler NICHT vorher sehen dürfen:
   die Rätsel, die Koordinaten der Kisten, die Verstecke, die Wörter für die
   Schilder-Tafel und der Freischalt-Code. Die Webseite (index.html) fragt
   den Server und bekommt immer nur das, was heute schon dran ist.

   Gespeichert wird in tafel-daten.json (legt der Server selbst an).
   Keine Datenbank nötig.

   ★★★ HIER ANPASSEN ★★★
   ADMIN_PASSWORT: Damit kann man die ganze Schilder-Tafel leeren
                   (unten auf der Seite: Code eingeben → "Admin: Tafel leeren").
   VORSCHAU_CODE:  Wer diesen Code unten auf der Seite eingibt, kann ALLE
                   Türchen und Schilder sofort benutzen (zum Testen).
   JAHR:           In welchem Dezember der Kalender läuft.
   TOLERANZ:       Wie viele Blöcke daneben noch als richtig zählen.
   TAGE:           Pro Türchen: Rätsel (HTML erlaubt), Koordinaten, Versteck.
                   [[bin:141]] zeigt die Zahl 141 als Redstone-Lampen.
   RICHTIG:        Was auf welches Schild der Tafel gehört (= Puzzleteile).
                   Groß-/Kleinschreibung, Satzzeichen, ä/ae und ß/ss sind egal.
   ========================================================================= */
const ADMIN_PASSWORT = 'bitte-aendern';
const VORSCHAU_CODE  = 'schneemann42';
const JAHR = 2026;
const TOLERANZ = 2;

const TAGE = [
  1 => [
    'art'  => 'Minecraft-Wissen',
    'x' => 64, 'y' => 36, 'z' => -16,
    'tipp' => 'Unter einer Fackel, einen Block tief.',
    'raetsel' => '<p><b>X</b> ist ein voller Stapel Erde.</p>
    <p><b>Y</b> liegt so tief wie der Grundgestein-Boden der Welt, plus 100.</p>
    <p><b>Z</b> ist ein voller Stapel Enderperlen, aber negativ.</p>',
  ],
  2 => [
    'art'  => 'Tierische Mathematik',
    'x' => 40, 'y' => 70, 'z' => 28,
    'tipp' => 'Hinter einem Heuballen.',
    'raetsel' => '<p><b>X:</b> Zähle die Beine von 5 Spinnen.</p>
    <p><b>Y:</b> So viele Herzen hat ein Spieler, mal 7.</p>
    <p><b>Z:</b> Die Tage einer Woche mal die Beine eines Creepers.</p>',
  ],
  3 => [
    'art'  => 'Altes Schild',
    'x' => 250, 'y' => 70, 'z' => -90,
    'tipp' => 'Neben einem Schild mit römischen Zahlen.',
    'raetsel' => '<p>Ein uraltes Schild im Schnee. Darauf steht:</p>
    <p><code>X: CCL</code> &nbsp; <code>Y: LXX</code> &nbsp; <code>Z: −XC</code></p>',
  ],
  4 => [
    'art'  => 'Bauanleitung',
    'x' => 135, 'y' => 63, 'z' => -120,
    'tipp' => 'In einem kleinen Schuppen.',
    'raetsel' => '<p><b>X:</b> Wie viele Felder hat eine Werkbank? Mal 15.</p>
    <p><b>Y:</b> Wie viele Wollblöcke braucht ein Bett? Mal 21.</p>
    <p><b>Z:</b> Wie viele Rahmenblöcke hat ein Endportal? Mal −10.</p>',
  ],
  5 => [
    'art'  => 'Redstone-Lampen',
    'x' => 141, 'y' => 68, 'z' => -52,
    'tipp' => 'Unter einer Redstone-Lampe.',
    'raetsel' => '<p>Leuchtende Lampe = 1, dunkle Lampe = 0. Von links nach rechts: 128, 64, 32, 16, 8, 4, 2, 1.</p>
    <p><b>X:</b> [[bin:141]]</p>
    <p><b>Y:</b> [[bin:68]]</p>
    <p><b>Z:</b> minus [[bin:52]]</p>',
  ],
  6 => [
    'art'  => 'Spiegelschrift',
    'x' => 380, 'y' => 70, 'z' => -15,
    'tipp' => 'Auf einem Eisblock.',
    'raetsel' => '<p>Ein Zettel, falsch herum geschrieben:</p>
    <p><b>X:</b> <i>gizthcatrednuhierd</i></p>
    <p><b>Y:</b> <i>gizbeis</i></p>
    <p><b>Z:</b> <i>nhezfnüf sunim</i></p>',
  ],
  7 => [
    'art'  => 'Ausflug in den Nether',
    'x' => 200, 'y' => 70, 'z' => -80,
    'tipp' => 'In der Oberwelt, neben einem Netherportal-Rahmen.',
    'raetsel' => '<p>Ein Nether-Reisender schreibt: „Im Nether stand ich bei <b>X = 25</b> und <b>Z = −10</b>.“</p>
    <p>Die Kiste liegt an der passenden Stelle <b>in der Oberwelt</b>, auf Höhe <b>Y = 70</b>.</p>
    <p><i>Tipp: Ein Block im Nether …</i></p>',
  ],
  8 => [
    'art'  => 'Die Uhr tickt',
    'x' => 120, 'y' => 64, 'z' => -240,
    'tipp' => 'Neben einer Uhr im Rahmen.',
    'raetsel' => '<p>Ein Minecraft-Tag dauert 20 echte Minuten.</p>
    <p><b>X:</b> Wie viele Minuten dauern 6 Minecraft-Tage?</p>
    <p><b>Y:</b> Sekunden einer Minute, plus 4.</p>
    <p><b>Z:</b> An welchem Dezembertag ist Heiligabend? Mal −10.</p>',
  ],
  9 => [
    'art'  => 'Zahlendetektiv',
    'x' => 150, 'y' => 66, 'z' => -300,
    'tipp' => 'Unter einem Kürbis.',
    'raetsel' => '<p><b>X</b> hat die Ziffern 1, 5 und 0. Sie ist größer als 100, kleiner als 200 und durch 50 teilbar.</p>
    <p><b>Y</b> ist die Hälfte von 132.</p>
    <p><b>Z</b> ist doppelt so groß wie X, aber negativ.</p>',
  ],
  10 => [
    'art'  => 'Mob-Steckbrief',
    'x' => 300, 'y' => 70, 'z' => -100,
    'tipp' => 'In einem Schafgehege.',
    'raetsel' => '<p><b>X:</b> Wie viele Köpfe hat der Wither? Mal 100.</p>
    <p><b>Y:</b> Ein Stapel Eier plus ein Stapel Erde, minus 10.</p>
    <p><b>Z:</b> Die Beine eines Schafs, mal −25.</p>',
  ],
  11 => [
    'art'  => 'Buchstaben-Code',
    'x' => 280, 'y' => 64, 'z' => -165,
    'tipp' => 'Hinter einem Schneemann.',
    'raetsel' => '<p>A = 1, B = 2, C = 3 … Z = 26. Addiere die Buchstaben.</p>
    <p><b>X:</b> ENDE, mal 10.</p>
    <p><b>Y:</b> SCHNEE, plus 10.</p>
    <p><b>Z:</b> EIS, mal −5.</p>',
  ],
  12 => [
    'art'  => 'Kompass-Wanderung',
    'x' => 70, 'y' => 72, 'z' => -30,
    'tipp' => 'Am Fuß einer großen Fichte.',
    'raetsel' => '<p>Starte genau bei X = 0 und Z = 0.</p>
    <p>Geh <b>100</b> Blöcke nach Osten, <b>50</b> nach Norden, <b>30</b> nach Westen und <b>20</b> nach Süden.</p>
    <p>Die Kiste liegt auf Höhe <b>Y = 72</b>.</p>',
  ],
  13 => [
    'art'  => 'Zahlenfolgen',
    'x' => 160, 'y' => 65, 'z' => -81,
    'tipp' => 'Zwischen zwei Laternen.',
    'raetsel' => '<p>Wie geht es weiter?</p>
    <p><b>X:</b> 5, 10, 20, 40, 80, …</p>
    <p><b>Y:</b> 81, 77, 73, 69, …</p>
    <p><b>Z:</b> −1, −3, −9, −27, …</p>',
  ],
  14 => [
    'art'  => 'Schmiede',
    'x' => 240, 'y' => 70, 'z' => -160,
    'tipp' => 'Neben einem Amboss.',
    'raetsel' => '<p><b>X:</b> Wie viele Eisenbarren braucht eine komplette Eisenrüstung? Mal 10.</p>
    <p><b>Y:</b> Wie viele Blöcke braucht man, um einen Eisengolem zu bauen? Mal 14.</p>
    <p><b>Z:</b> Wie viel Bruchstein braucht ein Ofen? Mal −20.</p>',
  ],
  15 => [
    'art'  => 'Morse-Funk',
    'x' => 200, 'y' => 71, 'z' => -39,
    'tipp' => 'Unter einem Notenblock.',
    'raetsel' => '<p>Ein Notenblock piept Morsezeichen:</p>
    <p><b>X:</b> <code>..--- ----- -----</code></p>
    <p><b>Y:</b> <code>--... .----</code></p>
    <p><b>Z:</b> minus <code>...-- ----.</code></p>',
  ],
  16 => [
    'art'  => 'Kopfrechnen',
    'x' => 180, 'y' => 65, 'z' => -280,
    'tipp' => 'In einer kleinen Höhle.',
    'raetsel' => '<p><b>X</b> = (12 × 12) + 36</p>
    <p><b>Y</b> = 1000 ÷ 8 − 60</p>
    <p><b>Z</b> = −(7 × 7 × 7 − 63)</p>',
  ],
  17 => [
    'art'  => 'Weihnachtswörter',
    'x' => 280, 'y' => 70, 'z' => -210,
    'tipp' => 'Neben einem geschmückten Baum.',
    'raetsel' => '<p>Zähle die Buchstaben.</p>
    <p><b>X:</b> WEIHNACHTSMANN, mal 20.</p>
    <p><b>Y:</b> TANNENBAUM, mal 7.</p>
    <p><b>Z:</b> RENTIER, mal −30.</p>',
  ],
  18 => [
    'art'  => 'Zeigerwinkel',
    'x' => 90, 'y' => 63, 'z' => -180,
    'tipp' => 'Hinter einem Glockenturm.',
    'raetsel' => '<p>Wie groß ist der Winkel zwischen den beiden Zeigern einer Uhr?</p>
    <p><b>X:</b> um 3:00 Uhr.</p>
    <p><b>Y:</b> um 2:00 Uhr, plus 3.</p>
    <p><b>Z:</b> um 6:00 Uhr, aber negativ.</p>',
  ],
  19 => [
    'art'  => 'Redstone-Lampen II',
    'x' => 222, 'y' => 66, 'z' => -111,
    'tipp' => 'In einem Redstone-Raum.',
    'raetsel' => '<p>Du kennst das schon: Leuchtend = 1, dunkel = 0 (128 … 1).</p>
    <p><b>X:</b> [[bin:222]]</p>
    <p><b>Y:</b> [[bin:66]]</p>
    <p><b>Z:</b> minus [[bin:111]]</p>',
  ],
  20 => [
    'art'  => 'Kalenderrechnung',
    'x' => 300, 'y' => 72, 'z' => -260,
    'tipp' => 'Auf einem Hügel unter Schnee.',
    'raetsel' => '<p><b>X:</b> Die Jahreszahl 2026, halbiert, minus 713.</p>
    <p><b>Y:</b> Die Monate eines Jahres, mal 6.</p>
    <p><b>Z:</b> Die Wochen eines Jahres, mal −5.</p>',
  ],
  21 => [
    'art'  => 'Spiegelzahlen',
    'x' => 240, 'y' => 67, 'z' => -135,
    'tipp' => 'Hinter einem Spiegel aus Glas.',
    'raetsel' => '<p>Lies die Zahlen rückwärts.</p>
    <p><b>X:</b> 42 gespiegelt, mal 10.</p>
    <p><b>Y:</b> 76 gespiegelt.</p>
    <p><b>Z:</b> 531 gespiegelt, aber negativ.</p>',
  ],
  22 => [
    'art'  => 'Redstone-Meister',
    'x' => 225, 'y' => 69, 'z' => -180,
    'tipp' => 'Am Ende einer Redstone-Leitung.',
    'raetsel' => '<p>Ein Redstone-Signal reicht 15 Blöcke weit.</p>
    <p><b>X:</b> 15 mal 15.</p>
    <p><b>Y:</b> Die volle Signalstärke mal 4, plus 9.</p>
    <p><b>Z:</b> Vier volle Signalweiten hintereinander, mal −3.</p>',
  ],
  23 => [
    'art'  => 'Fast geschafft',
    'x' => 276, 'y' => 72, 'z' => -248,
    'tipp' => 'Unter einer Glocke.',
    'raetsel' => '<p><b>X:</b> Zähle alle Türchennummern von 1 bis 23 zusammen.</p>
    <p><b>Y:</b> Wie viele Türchen hat dieser Kalender? Mal 3.</p>
    <p><b>Z:</b> Wieder alle Türchen, mal 10, plus 8, aber negativ.</p>',
  ],
  24 => [
    'art'  => 'Die große Bescherung',
    'x' => 24, 'y' => 90, 'z' => -24,
    'tipp' => 'Ihr habt es geschafft! Viel Spaß mit der Bescherung.',
    'raetsel' => '<p>In jeder der 23 Kisten lag ein Puzzleteil.</p>
    <p>Legt alle Teile der Reihe nach zusammen: Erst mit dem letzten Teil kennt ihr die Koordinaten der <b>großen Weihnachtskiste</b>.</p>
    <p>Frohe Weihnachten! 🎄</p>',
  ],
];

const RICHTIG = [
  1  => 'Die',
  2  => 'große',
  3  => 'Kiste',
  4  => 'liegt',
  5  => 'bei X',
  6  => 'vierundzwanzig,',
  7  => 'versteckt',
  8  => 'im',
  9  => 'geheimen',
  10 => 'Geschenkeraum',
  11 => 'auf Höhe Y',
  12 => 'neunzig.',
  13 => 'Frohe',
  14 => 'Weihnachten',
  15 => 'und',
  16 => 'ganz',
  17 => 'viel',
  18 => 'Spaß,',
  19 => 'ihr',
  20 => 'alle!',
  21 => 'Ach ja:',
  22 => 'Z ist minus',
  23 => 'vierundzwanzig.',
];

/* =========================================================================
   AB HIER: TECHNIK (muss man nicht anfassen)
   ========================================================================= */
const ANZAHL_SCHILDER = 23;
const MAX_WORT = 30;
const MAX_NAME = 16;
const MAX_PROTOKOLL = 60;
const WARTEZEIT_SEKUNDEN = 3;   // Schutz gegen Raten: so lange zwischen zwei Versuchen
const DATEI = __DIR__ . '/tafel-daten.json';

const FARBEN = [
  'schwarz', 'weiss', 'hellgrau', 'grau', 'braun', 'rot', 'orange', 'gelb',
  'hellgruen', 'gruen', 'tuerkis', 'hellblau', 'blau', 'lila', 'magenta', 'pink',
];

date_default_timezone_set('Europe/Berlin');
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function antwort($daten, $status = 200) {
  global $fh;
  if (!empty($fh)) { flock($fh, LOCK_UN); }
  http_response_code($status);
  echo json_encode($daten, JSON_UNESCAPED_UNICODE);
  exit;
}

function leer() {
  return ['schilder' => new stdClass(), 'protokoll' => [], 'sperre' => new stdClass()];
}

function oeffentlich($daten) {
  return ['schilder' => $daten['schilder'], 'protokoll' => $daten['protokoll']];
}

function text($wert, $max) {
  $s = is_string($wert) ? $wert : '';
  $s = preg_replace('/[\x00-\x1F\x7F]/u', '', $s);
  if ($s === null) $s = '';
  $s = trim(preg_replace('/\s+/u', ' ', $s));
  return mb_substr($s, 0, $max, 'UTF-8');
}

/* Vergleichbar machen: klein, ohne Satzzeichen, ä→ae, ß→ss */
function normal($s) {
  $s = mb_strtolower($s, 'UTF-8');
  $s = strtr($s, ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss']);
  $s = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $s);
  return trim($s);
}

function code_ok($eingabe) {
  $c = isset($eingabe['code']) && is_string($eingabe['code']) ? mb_strtolower(trim($eingabe['code']), 'UTF-8') : '';
  return $c !== '' && hash_equals(mb_strtolower(VORSCHAU_CODE, 'UTF-8'), $c);
}

/* Tag n ist ab dem n. Dezember frei (oder sofort mit dem Vorschau-Code) */
function frei($n, $eingabe) {
  return code_ok($eingabe) || time() >= mktime(0, 0, 0, 12, $n, JAHR);
}

function datei_lesen($fh) {
  rewind($fh);
  $inhalt = stream_get_contents($fh);
  $daten = $inhalt ? json_decode($inhalt, true) : null;
  if (!is_array($daten)) return leer();
  foreach (['schilder', 'protokoll', 'sperre'] as $k) {
    $daten[$k] = isset($daten[$k]) && is_array($daten[$k]) ? $daten[$k] : [];
  }
  if (!$daten['schilder']) $daten['schilder'] = new stdClass();
  if (!$daten['sperre']) $daten['sperre'] = new stdClass();
  return $daten;
}

function datei_schreiben($fh, $daten) {
  rewind($fh);
  ftruncate($fh, 0);
  fwrite($fh, json_encode($daten, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
  fflush($fh);
}

/* Bremse gegen Raten: pro Besucher ein Versuch alle WARTEZEIT_SEKUNDEN.
   Die IP wird nur als gekürzter Hash gespeichert. */
function bremse(&$daten, $fh) {
  $jetzt = time();
  $sperre = (array)$daten['sperre'];
  foreach ($sperre as $k => $t) if ($jetzt - $t > 60) unset($sperre[$k]);
  $ip = substr(hash('sha256', (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '') . __FILE__), 0, 16);
  if (isset($sperre[$ip]) && $jetzt - $sperre[$ip] < WARTEZEIT_SEKUNDEN) {
    antwort(['fehler' => 'Nicht so schnell! Warte kurz und versuch es dann noch mal.'], 429);
  }
  $sperre[$ip] = $jetzt;
  $daten['sperre'] = $sperre ?: new stdClass();
  datei_schreiben($fh, $daten);
}

$fh = @fopen(DATEI, 'c+');
if (!$fh) antwort(['fehler' => 'Die Datei tafel-daten.json kann nicht angelegt werden. Bitte Schreibrechte für den Ordner prüfen.'], 500);

/* ---------- Tafel lesen ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  flock($fh, LOCK_SH);
  $daten = datei_lesen($fh);
  antwort(oeffentlich($daten));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') antwort(['fehler' => 'Nur GET und POST.'], 405);

$eingabe = json_decode(file_get_contents('php://input'), true);
if (!is_array($eingabe)) antwort(['fehler' => 'Ungültige Anfrage.'], 400);
$aktion = isset($eingabe['aktion']) ? $eingabe['aktion'] : '';

/* ---------- Rätsel holen (nur wenn der Tag schon dran ist) ---------- */
if ($aktion === 'raetsel') {
  $tag = isset($eingabe['tag']) ? (int)$eingabe['tag'] : 0;
  if (!isset(TAGE[$tag])) antwort(['fehler' => 'Dieses Türchen gibt es nicht.'], 400);
  if (!frei($tag, $eingabe)) antwort(['fehler' => "Türchen $tag ist noch verschlossen."], 403);
  antwort(['tag' => $tag, 'art' => TAGE[$tag]['art'], 'raetsel' => TAGE[$tag]['raetsel']]);
}

flock($fh, LOCK_EX);
$daten = datei_lesen($fh);

/* ---------- Vorschau-Code prüfen ---------- */
if ($aktion === 'code') {
  if (code_ok($eingabe)) antwort(['ok' => true]);
  bremse($daten, $fh);   /* nur falsche Codes bremsen */
  antwort(['fehler' => 'Falscher Code.'], 403);
}

/* ---------- Koordinaten prüfen ---------- */
if ($aktion === 'pruefen') {
  $tag = isset($eingabe['tag']) ? (int)$eingabe['tag'] : 0;
  if (!isset(TAGE[$tag])) antwort(['fehler' => 'Dieses Türchen gibt es nicht.'], 400);
  if (!frei($tag, $eingabe)) antwort(['fehler' => "Türchen $tag ist noch verschlossen."], 403);
  foreach (['x', 'y', 'z'] as $k) {
    if (!isset($eingabe[$k]) || !is_numeric($eingabe[$k])) antwort(['fehler' => 'Bitte drei ganze Zahlen eingeben.'], 400);
  }
  bremse($daten, $fh);
  $d = TAGE[$tag];
  $treffer = 0;
  foreach (['x', 'y', 'z'] as $k) {
    if (abs((int)$eingabe[$k] - $d[$k]) <= TOLERANZ) $treffer++;
  }
  if ($treffer === 3) {
    antwort(['richtig' => true, 'x' => $d['x'], 'y' => $d['y'], 'z' => $d['z'], 'tipp' => $d['tipp']]);
  }
  antwort(['richtig' => false, 'treffer' => $treffer]);
}

/* ---------- Tafel leeren (Admin) ---------- */
if ($aktion === 'leeren') {
  $pw = isset($eingabe['passwort']) ? (string)$eingabe['passwort'] : '';
  if (ADMIN_PASSWORT === 'bitte-aendern' || !hash_equals(ADMIN_PASSWORT, $pw)) {
    bremse($daten, $fh);
    antwort(['fehler' => 'Falsches Passwort (oder in server.php noch nicht geändert).'], 403);
  }
  $daten = leer();
  datei_schreiben($fh, $daten);
  antwort(oeffentlich($daten));
}

/* ---------- Schild beschriften ---------- */
if ($aktion !== 'schreiben') antwort(['fehler' => 'Unbekannte Aktion.'], 400);

$nr = isset($eingabe['schild']) ? (int)$eingabe['schild'] : 0;
if ($nr < 1 || $nr > ANZAHL_SCHILDER) antwort(['fehler' => 'Dieses Schild gibt es nicht.'], 400);
if (!frei($nr, $eingabe)) antwort(['fehler' => "Schild $nr kann erst ab dem $nr. Dezember beschriftet werden."], 403);

$wort = text(isset($eingabe['wort']) ? $eingabe['wort'] : '', MAX_WORT);
$name = text(isset($eingabe['name']) ? $eingabe['name'] : '', MAX_NAME);
if ($name === '') $name = 'Unbekannt';
$farbe = isset($eingabe['farbe']) && in_array($eingabe['farbe'], FARBEN, true) ? $eingabe['farbe'] : 'schwarz';

bremse($daten, $fh);

if ($wort === '' || normal($wort) !== normal(RICHTIG[$nr])) {
  antwort(['fehler' => "Das passt nicht auf Schild $nr. Schau noch mal auf dein Puzzleteil!"], 422);
}
$wort = RICHTIG[$nr];   /* immer schön geschrieben speichern */

$schilder = (array)$daten['schilder'];
$schilder[(string)$nr] = ['wort' => $wort, 'farbe' => $farbe, 'name' => $name, 'zeit' => time()];
$daten['schilder'] = $schilder ?: new stdClass();

array_unshift($daten['protokoll'], ['schild' => $nr, 'wort' => $wort, 'farbe' => $farbe, 'name' => $name, 'zeit' => time()]);
$daten['protokoll'] = array_slice($daten['protokoll'], 0, MAX_PROTOKOLL);

datei_schreiben($fh, $daten);
antwort(oeffentlich($daten));
