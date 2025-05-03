<?php
session_start();
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) { header('Location: index.php'); exit; }
// Security: Only allow if go step completed
if (!isset($_SESSION['go_'.$id])) {
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
  echo "<script>Swal.fire({icon:'error',title:'Access Denied',text:'Please start from the beginning.'}).then(()=>window.location='blog.php?id=".htmlspecialchars($id)."');</script>";
  exit;
}
// Invalidate session for this flow to prevent repeated access
unset($_SESSION['blog_'.$id]);
unset($_SESSION['go_'.$id]);
// --- FILE SERVE LOGIC ---
// TODO: Replace with your actual file lookup logic using $id
$video_url = null;
// Example: Fetch from DB
try {
  include('config.php');
  $stmt = $pdo->prepare('SELECT url FROM videos WHERE id = :id');
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    $video_url = $row['url'];
  }
} catch (Exception $e) {}
if (!$video_url) {
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
  echo "<script>Swal.fire({icon:'error',title:'File Not Found',text:'Sorry, the download link is unavailable.'}).then(()=>window.location='blog.php?id=".htmlspecialchars($id)."');</script>";
  exit;
}
// If video_url is a remote file, redirect; if local, serve as attachment
if (filter_var($video_url, FILTER_VALIDATE_URL)) {
  header('Location: ' . $video_url);
  exit;
} else if (file_exists($video_url)) {
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="' . basename($video_url) . '"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($video_url));
  readfile($video_url);
  exit;
} else {
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
  echo "<script>Swal.fire({icon:'error',title:'File Not Found',text:'Sorry, the download link is unavailable.'}).then(()=>window.location='blog.php?id=".htmlspecialchars($id)."');</script>";
  exit;
}
