<?php
$keys = $_GET['keys'];
$text = $_GET['text'];

preg_match("/(^[a-zA-Z_]+)\d/", $keys, $matches);
if (!isset($matches[1])) {
    echo "<p>A key is missing</p>";
    exit;
}
$startKey = $matches[1];
preg_match("/\d([a-zA-Z_]+)$/", $keys, $matches);
if (!isset($matches[1])) {
    echo "<p>A key is missing</p>";
    exit;
}
$endKey = $matches[1];

$pattern = "/". $startKey . "(.*?)" . $endKey . "/";

preg_match_all($pattern, $text, $matches);

$sum = 0;
foreach ($matches[1] as $match) {
    if (is_numeric($match)) {
        $sum+= $match;
    }
}

if ($sum == 0) {
    echo "<p>The total value is: <em>nothing</em></p>";
} else {
    echo "<p>The total value is: <em>$sum</em></p>";
}
?>