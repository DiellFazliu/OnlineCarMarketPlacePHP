<?php
$filename = 'blerjet.log';

// Kontrollon nëse fajlli ekziston
if (file_exists($filename)) {
    $size = filesize($filename);
    $size_kb = round($size / 1024, 2);

    echo "<h2>Historiku i Blerjeve</h2>";
    echo "<p><strong>Madhësia:</strong> $size bajte (~$size_kb KB)</p>";
    echo "<hr>";

    $handle = fopen($filename, 'r');
    if ($handle) {
        $content = fread($handle, $size);
        fclose($handle);
        echo "<pre>" . htmlspecialchars($content) . "</pre>";
    } else {
        echo "Gabim: Nuk u arrit të hapet fajlli për lexim.";
    }
} else {
    echo "Asnjë blerje nuk është regjistruar ende.";
}
?>