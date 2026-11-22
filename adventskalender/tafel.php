<?php
/* =========================================================================
   Schilder-Tafel für den Block-Adventskalender
   -------------------------------------------------------------------------
   Speichert, was die Spieler auf die Schilder schreiben, in der Datei
   tafel-daten.json (wird automatisch angelegt). Keine Datenbank nötig.

   ★ HIER ANPASSEN ★
   ADMIN_PASSWORT: Damit kann man die ganze Tafel leeren
                   (unten auf der Seite: Code eingeben → "Tafel leeren").
   JAHR:           Schild n lässt sich erst ab dem n. Dezember beschriften.
   TESTMODUS:      true = Datumssperre aus (zum Ausprobieren). Danach wieder false!
   RICHTIG:        Was auf welches Schild gehört (= eure Puzzleteile).
                   Groß-/Kleinschreibung, Satzzeichen und ä/ae, ß/ss sind egal.
                   Diese Liste sieht nur der Server, nicht die Spieler.
   ========================================================================= */
const ADMIN_PASSWORT = 'bitte-aendern';
const JAHR = 2026;
const TESTMODUS = false;

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

const ANZAHL_SCHILDER = 23;
const MAX_WORT = 30;
const MAX_NAME = 16;
const MAX_PROTOKOLL = 60;
const WARTEZEIT_SEKUNDEN = 3;   // Schutz gegen Raten und Spam: so lange zwischen zwei Versuchen
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

/* Vergleichbar machen: klein, ohne Satzzeichen, ä→ae, ß→ss, Leerzeichen zusammenfassen */
function normal($s) {
  $s = mb_strtolower($s, 'UTF-8');
  $s = strtr($s, ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss']);
  $s = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $s);
  return trim($s);
}

function schild_frei($nr) {
  if (TESTMODUS) return true;
  return time() >= mktime(0, 0, 0, 12, $nr, JAHR);
}

function datei_lesen($fh) {
  rewind($fh);
  $inhalt = stream_get_contents($fh);
  $daten = $inhalt ? json_decode($inhalt, true) : null;
  if (!is_array($daten)) return leer();
  $daten['schilder'] = isset($daten['schilder']) && is_array($daten['schilder']) ? $daten['schilder'] : [];
  $daten['protokoll'] = isset($daten['protokoll']) && is_array($daten['protokoll']) ? $daten['protokoll'] : [];
  $daten['sperre'] = isset($daten['sperre']) && is_array($daten['sperre']) ? $daten['sperre'] : [];
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

$fh = @fopen(DATEI, 'c+');
if (!$fh) antwort(['fehler' => 'Die Datei tafel-daten.json kann nicht angelegt werden. Bitte Schreibrechte für den Ordner prüfen.'], 500);

/* ---------- Lesen ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  flock($fh, LOCK_SH);
  $daten = datei_lesen($fh);
  flock($fh, LOCK_UN);
  antwort(oeffentlich($daten));
}

/* ---------- Schreiben ---------- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') antwort(['fehler' => 'Nur GET und POST.'], 405);

$eingabe = json_decode(file_get_contents('php://input'), true);
if (!is_array($eingabe)) antwort(['fehler' => 'Ungültige Anfrage.'], 400);
$aktion = isset($eingabe['aktion']) ? $eingabe['aktion'] : '';

flock($fh, LOCK_EX);
$daten = datei_lesen($fh);
$jetzt = time();

if ($aktion === 'leeren') {
  $pw = isset($eingabe['passwort']) ? (string)$eingabe['passwort'] : '';
  if (ADMIN_PASSWORT === 'bitte-aendern' || !hash_equals(ADMIN_PASSWORT, $pw)) {
    flock($fh, LOCK_UN);
    antwort(['fehler' => 'Falsches Passwort (oder in tafel.php noch nicht geändert).'], 403);
  }
  $daten = leer();
  datei_schreiben($fh, $daten);
  flock($fh, LOCK_UN);
  antwort(oeffentlich($daten));
}

if ($aktion !== 'schreiben') { flock($fh, LOCK_UN); antwort(['fehler' => 'Unbekannte Aktion.'], 400); }

$nr = isset($eingabe['schild']) ? (int)$eingabe['schild'] : 0;
if ($nr < 1 || $nr > ANZAHL_SCHILDER) { flock($fh, LOCK_UN); antwort(['fehler' => 'Dieses Schild gibt es nicht.'], 400); }

if (!schild_frei($nr)) { flock($fh, LOCK_UN); antwort(['fehler' => "Schild $nr kann erst ab dem $nr. Dezember beschriftet werden."], 403); }

$wort = text(isset($eingabe['wort']) ? $eingabe['wort'] : '', MAX_WORT);
$name = text(isset($eingabe['name']) ? $eingabe['name'] : '', MAX_NAME);
if ($name === '') $name = 'Unbekannt';
$farbe = isset($eingabe['farbe']) && in_array($eingabe['farbe'], FARBEN, true) ? $eingabe['farbe'] : 'schwarz';

/* Spam-Schutz pro Besucher (IP wird nur gekürzt als Hash gespeichert) */
$sperre = (array)$daten['sperre'];
foreach ($sperre as $k => $t) if ($jetzt - $t > 60) unset($sperre[$k]);
$ip = substr(hash('sha256', (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '') . __FILE__), 0, 16);
if (isset($sperre[$ip]) && $jetzt - $sperre[$ip] < WARTEZEIT_SEKUNDEN) {
  flock($fh, LOCK_UN);
  antwort(['fehler' => 'Nicht so schnell! Warte kurz.'], 429);
}
$sperre[$ip] = $jetzt;
$daten['sperre'] = $sperre ?: new stdClass();

if ($wort === '' || normal($wort) !== normal(RICHTIG[$nr])) {
  datei_schreiben($fh, $daten);   /* Wartezeit gilt auch für falsche Versuche */
  flock($fh, LOCK_UN);
  antwort(['fehler' => "Das passt nicht auf Schild $nr. Schau noch mal auf dein Puzzleteil!"], 422);
}
$wort = RICHTIG[$nr];   /* immer schön geschrieben speichern */

$schilder = (array)$daten['schilder'];
$schilder[(string)$nr] = ['wort' => $wort, 'farbe' => $farbe, 'name' => $name, 'zeit' => $jetzt];
$daten['schilder'] = $schilder ?: new stdClass();

array_unshift($daten['protokoll'], ['schild' => $nr, 'wort' => $wort, 'farbe' => $farbe, 'name' => $name, 'zeit' => $jetzt]);
$daten['protokoll'] = array_slice($daten['protokoll'], 0, MAX_PROTOKOLL);

datei_schreiben($fh, $daten);
flock($fh, LOCK_UN);
antwort(oeffentlich($daten));
