<?php
session_start();
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) { header('Location: index.php'); exit; }
// Security: Only allow if blog step completed
if (!isset($_SESSION['blog_'.$id])) {
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
  echo "<script>Swal.fire({icon:'error',title:'Access Denied',text:'Please start from the beginning.'}).then(()=>window.location='blog.php?id=".htmlspecialchars($id)."');</script>";
  exit;
}
// Mark that user visited the go page for this id
$_SESSION['go_'.$id] = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Continue | MovieZone</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
  <main class="flex-1 flex flex-col items-center justify-center px-2">
    <div class="w-full max-w-2xl bg-white shadow-lg rounded-xl mt-10 p-8">
      <div id="timer" class="text-center text-lg font-semibold text-blue-600 mb-4"></div>
      <div id="download-section" class="hidden text-center">
        <a id="download-btn" href="download.php?id=<?php echo htmlspecialchars($id); ?>" class="inline-block px-6 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 transition">Click to Download</a>
      </div>
    </div>
  </main>
  <script>
    let countdown = 15;
    const timerDiv = document.getElementById('timer');
    const downloadSection = document.getElementById('download-section');
    function updateTimer() {
      if (countdown > 0) {
        timerDiv.textContent = `⏳ Please wait ${countdown} seconds...`;
        countdown--;
        setTimeout(updateTimer, 1000);
      } else {
        timerDiv.textContent = '';
        downloadSection.classList.remove('hidden');
      }
    }
    updateTimer();
  </script>
</body>
</html>
