<?php
session_start();
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) { header('Location: index.php'); exit; }
// Mark that user visited the blog for this id
$_SESSION['blog_'.$id] = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog | MovieZone</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
  <main class="flex-1 flex flex-col items-center justify-center px-2">
    <div class="w-full max-w-2xl bg-white shadow-lg rounded-xl mt-10 p-8">
      <div id="timer" class="text-center text-lg font-semibold text-blue-600 mb-4"></div>
      <div id="blog-content"><?php include 'blog_content.html'; ?></div>
      <div id="continue-section" class="hidden mt-8 text-center">
        <p class="mb-4 text-base">👉 Scroll down and click Continue to get your download.</p>
        <a id="continue-btn" href="go.php?id=<?php echo htmlspecialchars($id); ?>" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">Continue</a>
      </div>
    </div>
  </main>
  <script>
    let countdown = 15;
    const timerDiv = document.getElementById('timer');
    const continueSection = document.getElementById('continue-section');
    function updateTimer() {
      if (countdown > 0) {
        timerDiv.textContent = `⏳ Please wait ${countdown} seconds...`;
        countdown--;
        setTimeout(updateTimer, 1000);
      } else {
        timerDiv.textContent = '';
        continueSection.classList.remove('hidden');
      }
    }
    updateTimer();
  </script>
</body>
</html>
