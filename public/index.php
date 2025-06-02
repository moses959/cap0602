<?php
// File: public/index.php
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>圖片標籤生成器</title>
  <style>
    body { font-family: sans-serif; padding: 2em; }
    img { max-width: 300px; margin-top: 1em; }
  </style>
</head>
<body>
  <h1>圖片標籤生成器</h1>
  <form id="uploadForm" enctype="multipart/form-data">
    <input type="file" name="image" id="imageInput" accept="image/*" required><br>
    <img id="preview" src="#" style="display:none;" />
    <br>
    <button type="submit">生成描述並下載 ZIP</button>
  </form>
  <p id="caption"></p>

  <script>
    document.getElementById('imageInput').addEventListener('change', function(evt) {
      const file = evt.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const img = document.getElementById('preview');
          img.src = e.target.result;
          img.style.display = 'block';
        }
        reader.readAsDataURL(file);
      }
    });

    document.getElementById('uploadForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      const response = await fetch('caption.php', {
        method: 'POST',
        body: formData
      });
      const blob = await response.blob();
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'image-caption.zip';
      a.click();
    });
  </script>
</body>
</html>
