<?php
$list = $_GET['list'];
$minLength = intval(trim($_GET['length']));
if (isset($_GET['show'])) {
    $show = true;
} else {
    $show = false;
}

//var_dump($list);
//var_dump($minLength);
//var_dump($show);

$names = preg_split("/\s*\r?\n\s*/", $list, -1, PREG_SPLIT_NO_EMPTY);
for ($i = 0; $i < count($names); $i++) {
    $names[$i] = trim($names[$i]);
    if ($names[$i]=='') {
        unset($names[$i]);
    }
}

//var_dump($names);

echo "<ul>";
foreach ($names as $name) {
    $processedName = htmlspecialchars($name);
    if (strlen($name) >= $minLength) {
        echo "<li>$processedName</li>";
    } else {
        if ($show) {
            echo "<li style=\"color: red;\">$processedName</li>";
        }
    }
}
echo "</ul>";
?>