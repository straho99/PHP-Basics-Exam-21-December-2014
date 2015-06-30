<?php
$jsonTable = $_GET['jsonTable'];
//var_dump($jsonTable);
$inputArray = json_decode($jsonTable);
//var_dump($inputArray);

$k = $inputArray[1][0];
$s = $inputArray[1][1];
//var_dump($k);
//var_dump($s);


$columns = 1;
foreach ($inputArray[0] as $sentence) {
    if (strlen($sentence) > $columns) {
        $columns = strlen($sentence);
    }
}

for ($i = 0; $i < count($inputArray[0]); $i++) {
    for ($j = 0; $j < strlen($inputArray[0][$i]); $j++) {
        if (preg_match("/[a-zA-Z]/", $inputArray[0][$i][$j])) {
            $char = strtoupper($inputArray[0][$i][$j]);
            $x = getX($char);
            $encoding = ($k * $x + $s) % 26 + 1;
            $inputArray[0][$i][$j] = getChar($encoding);
        }
    }
}
//var_dump($inputArray);

echo "<table border='1' cellpadding='5'>";
foreach ($inputArray[0] as $sentence) {
    echo "<tr>";
    for ($i = 0; $i < $columns; $i++) {
        if ($i > strlen($sentence) - 1) {
            echo "<td></td>";
        } else {
            $encodedChar = htmlspecialchars($sentence[$i]);
            echo "<td style='background:#CCC'>$encodedChar</td>";
        }
    }
    echo "</tr>";
}
echo "</table>";

function getX($char)
{
    return ord($char) - 65;
}

function getChar($code)
{
    return chr($code + 65 - 1);
}
?>