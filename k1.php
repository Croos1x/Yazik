<?php
// Gerekli kontroller
if (!isset($_GET['isim']) || !isset($_GET['font']) || !isset($_GET['renk']) || !isset($_GET['bg'])) {
    die(json_encode(["error" => "❌ Lütfen tüm parametreleri gönderin: isim, font, renk, bg"]));
}

$isim = $_GET['isim'];
$font_kod = $_GET['font'];
$renk_kod = $_GET['renk'];
$bg_kod = $_GET['bg'];

// Font seçimi
switch ($font_kod) {
    case "1": $font = "friday13v12"; break;
    case "2": $font = "dk_face_your_fears"; break;
    case "3": $font = "october_crow"; break;
    default: $font = "dk_face_your_fears"; break;
}

// Renk
$renk = $renk_kod == "1" ? "on" : "False";

// Arka plan
$bg = $bg_kod == "1" ? "on" : "False";

// Post verisi
$postData = [
    'text' => $isim,
    'font' => $font,
    'red' => $renk,
    'mono' => $bg
];

// CURL ile Photofunia'ya POST at
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://m.photofunia.com/tr/categories/all_effects/nightmare-writing');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=t2boad50usum5i7rfc8rah1hu1');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 10; K)');
$response = curl_exec($ch);
curl_close($ch);

// Görsel linkini ayıkla
if (preg_match('/<a href="(https:\/\/u\.photofunia\.com\/.*?_r\.jpg\?download)">/', $response, $match)) {
    $link = $match[1];
    // Görseli indir ve sun
    header("Content-Type: application/json");
    echo json_encode([
        "status" => "success",
        "image_url" => $link,
        "note" => "🔗 Resminizi direkt tarayıcıda açmak için yukarıdaki bağlantıyı kullanın."
    ]);
} else {
    echo json_encode([
        "status" => "fail",
        "error" => "❌ Görsel oluşturulamadı. Metin çok uzun olabilir veya Photofunia değişmiş olabilir."
    ]);
}
?>
