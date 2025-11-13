<?php
// save_data.php
// Guarda un ZIP enviado por POST en datos/<folder>/<zip>
// Responde JSON { ok: true/false, ... }

header('Content-Type: application/json; charset=utf-8');

// --- Permitir solo POST con multipart ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
  exit;
}
if (empty($_FILES['zip'])) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Falta archivo "zip"']);
  exit;
}
if (!isset($_POST['folder'])) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Falta parámetro "folder"']);
  exit;
}

// --- Sanitizar "folder" para evitar path traversal ---
$folder = $_POST['folder'];
$folder = preg_replace('~[^a-zA-Z0-9._\-]~', '_', $folder); // solo [a-zA-Z0-9._-]
if ($folder === '' || strlen($folder) > 100) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Nombre de carpeta inválido']);
  exit;
}

// --- Validar archivo ZIP ---
$file = $_FILES['zip'];
if ($file['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Error al subir archivo', 'code' => $file['error']]);
  exit;
}

// Tamaño máx. (ajusta si quieres): 100 MB
$MAX_BYTES = 100 * 1024 * 1024;
if ($file['size'] <= 0 || $file['size'] > $MAX_BYTES) {
  http_response_code(413);
  echo json_encode(['ok' => false, 'error' => 'Archivo demasiado grande o vacío']);
  exit;
}

// Chequear extensión .zip
$origName = $file['name'];
$ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
if ($ext !== 'zip') {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'El archivo debe ser .zip']);
  exit;
}

// (Opcional) Chequear MIME declarado por PHP
$mime = mime_content_type($file['tmp_name']);
$validMimes = ['application/zip', 'application/x-zip-compressed', 'multipart/x-zip'];
// no todos los servidores reportan igual; aceptamos si extensión es .zip
// pero si quieres forzar: if (!in_array($mime, $validMimes)) { ... }

$baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'datos';
$targetDir = $baseDir . DIRECTORY_SEPARATOR . $folder;

// Crear carpetas si no existen
if (!is_dir($baseDir)) {
  if (!mkdir($baseDir, 0755, true)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'No se pudo crear carpeta base']);
    exit;
  }
}
if (!is_dir($targetDir)) {
  if (!mkdir($targetDir, 0755, true)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'No se pudo crear carpeta de destino']);
    exit;
  }
}

// Nombre de archivo destino (preservamos el nombre que manda el front)
$destName = preg_replace('~[^a-zA-Z0-9._\-]~', '_', $origName);
$destPath = $targetDir . DIRECTORY_SEPARATOR . $destName;

// Si ya existe, hacer uno único
if (file_exists($destPath)) {
  $ts = date('Ymd_His');
  $destPath = $targetDir . DIRECTORY_SEPARATOR . $ts . '_' . $destName;
}

// Mover archivo
if (!move_uploaded_file($file['tmp_name'], $destPath)) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'No se pudo guardar el archivo']);
  exit;
}

// (Opcional) Escribir un pequeño manifiesto con metadata
$manifest = [
  'saved_at'   => date('c'),
  'client_ip'  => $_SERVER['REMOTE_ADDR'] ?? null,
  'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
  'folder'     => $folder,
  'file'       => basename($destPath),
  'size_bytes' => filesize($destPath),
];
file_put_contents($targetDir . DIRECTORY_SEPARATOR . 'manifest.json', json_encode($manifest, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

echo json_encode([
  'ok' => true,
  'folder' => "datos/$folder",
  'file' => basename($destPath),
  'size_bytes' => filesize($destPath),
]);
