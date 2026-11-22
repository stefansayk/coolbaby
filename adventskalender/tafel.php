<?php
/* =========================================================================
   Schilder-Tafel für den Block-Adventskalender
   -------------------------------------------------------------------------
   Speichert, was die Spieler auf die Schilder schreiben, in der Datei
   tafel-daten.json (wird automatisch angelegt). Keine Datenbank nötig.

   ★ HIER ANPASSEN ★
   ADMIN_PASSWORT: Damit kann man die ganze Tafel leeren
                   (unten auf der Seite: Code eingeben → "Tafel leeren").
   ========================================================================= */
const ADMIN_PASSWORT = 'bitte-aendern';
const ANZAHL_SCHILDER = 23;
const MAX_WORT = 30;
const MAX_NAME = 16;
const MAX_PROTOKOLL = 60;
const WARTEZEIT_SEKUNDEN = 2;   // Schutz gegen Spam: so lange zwischen zwei Einträgen
const DATEI = __DIR__ . '/tafel-daten.json';

const FARBEN = [
  'schwarz', 'weiss', 'hellgrau', 'grau', 'braun', 'rot', 'orange', 'gelb',
  'hellgruen', 'gruen', 'tuerkis', 'hellblau', 'blau', 'lila', 'magenta', 'pink',
];

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

$schilder = (array)$daten['schilder'];
if ($wort === '') {
  unset($schilder[(string)$nr]);
} else {
  $schilder[(string)$nr] = ['wort' => $wort, 'farbe' => $farbe, 'name' => $name, 'zeit' => $jetzt];
}
$daten['schilder'] = $schilder ?: new stdClass();

array_unshift($daten['protokoll'], ['schild' => $nr, 'wort' => $wort, 'farbe' => $farbe, 'name' => $name, 'zeit' => $jetzt]);
$daten['protokoll'] = array_slice($daten['protokoll'], 0, MAX_PROTOKOLL);

datei_schreiben($fh, $daten);
flock($fh, LOCK_UN);
antwort(oeffentlich($daten));
