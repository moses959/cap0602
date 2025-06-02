<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['image'])) {
  http_response_code(400);
  echo "Image is required.";
  exit;
}

$tmpFile = $_FILES['image']['tmp_name'];
$imgData = file_get_contents($tmpFile);

$apiUrl = "https://api-inference.huggingface.co/models/nlpconnect/vit-gpt2-image-captioning";
$hfToken = getenv("HF_TOKEN") ?: "hf_xxx_replace_me";

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "Authorization: Bearer $hfToken",
    "Content-Type: application/octet-stream"
  ],
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $imgData
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$caption = $data[0]['generated_text'] ?? $hfToken.'無法生成標籤';

header('Content-Type: application/json');
echo json_encode(['caption' => $caption]);
?>
