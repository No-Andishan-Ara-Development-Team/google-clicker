<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = urlencode($_POST['query']);
    $count = intval($_POST['count']);
    $position = intval($_POST['position']) - 1; // چون index آرایه‌ها از 0 شروع می‌شه

    $searchUrl = "http://google.com/search?q=$query";

    echo "<h2>شروع کلیک‌ها...</h2>";

    for ($i = 0; $i < $count; $i++) {
        $html = @file_get_contents($searchUrl);

        if ($html === false) {
            echo "❌ خطا در دریافت نتایج جستجو!<br>";
            continue;
        }

        // استخراج لینک‌ها
        preg_match_all('/<a href="([^"]+)"/', $html, $matches);

        if (!empty($matches[1]) && isset($matches[1][$position])) {
            $targetLink = $matches[1][$position];
            echo "[$i] ✅ کلیک روی نتیجه شماره " . ($position + 1) . ": <a href='$targetLink' target='_blank'>$targetLink</a><br>";
            @file_get_contents($targetLink);
            sleep(rand(1, 3));
        } else {
            echo "[$i] ⚠️ نتیجه مورد نظر پیدا نشد!<br>";
        }
    }

    echo "<br><a href='?'>🔁 بازگشت به فرم</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>کلیک خودکار روی نتایج</title>
</head>
<body style="direction: rtl; font-family: sans-serif;">

    <h2>ارسال کلیک خودکار به موتور جستجو</h2>

    <form action="" method="POST">
        <label>🔍 کلمه کلیدی جستجو:</label><br>
        <input type="text" name="query" required><br><br>

        <label>🔢 تعداد کلیک:</label><br>
        <input type="number" name="count" value="5" min="1" required><br><br>

        <label>🎯 کلیک روی نتیجه چندم؟ (مثلاً 1 برای اول):</label><br>
        <input type="number" name="position" value="1" min="1" required><br><br>

        <button type="submit">🚀 شروع کلیک</button>
    </form>

</body>
</html>
