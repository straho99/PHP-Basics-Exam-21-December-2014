<?php
date_default_timezone_set('Europe/Sofia');
$text = $_GET['text'];
$minPrice = doubleval(trim($_GET['min-price']));
$maxPrice = doubleval(trim($_GET['max-price']));
$sortBy = $_GET['sort'];
$order = $_GET['order'];

if ($sortBy == 'publish-date') {
    $sortBy = 'date';
}

$lines = preg_split("/\s*\r?\n\s*/", $text, -1, PREG_SPLIT_NO_EMPTY);

$books = [];
foreach ($lines as $line) {
    if ($line == '') {
        continue;
    }
    $tokens = preg_split("/\s*[\/]\s*/", $line, -1, PREG_SPLIT_NO_EMPTY);
    $price = floatval($tokens[3]);

    if ($price < $minPrice || $price > $maxPrice) {
        continue;
    }

    $newBook = [
        'author' => $tokens[0],
        'name' => $tokens[1],
        'genre' => $tokens[2],
        'price' => $price,
        'date' => new DateTime($tokens[4]),
        'info' => $tokens[5]
    ];
    $books[] = $newBook;
}

usort($books, function($a, $b) use ($sortBy, $order) {
    $sign = 1;
    if ($order == 'descending') {
        $sign = -1;
    }
    if (is_object($a[$sortBy])) {
        if ($a['date'] > $b['date']) {
            return 1 * $sign;
        } else if ($a['date'] < $b['date']  ) {
            return -1 * $sign;
        } else {
            return 0;
        }
    } else {
        $result = strcmp($a[$sortBy], $b[$sortBy]);

        if ($result == 0) {
            if ($a['date'] > $b['date']) {
                return 1;
            } else if ($a['date' < $b['date']]) {
                return -1;
            } else {
                return 0;
            }
        } else {
            return $result * $sign;
        }
    }
});

printHTML($books);

function printHTML($books) {
    foreach ($books as $book) {
        $author = htmlspecialchars($book['author']);
        $name = htmlspecialchars($book['name']);
        $genre = htmlspecialchars($book['genre']);
        $price = number_format($book['price'], 2, '.', '');
        $price = htmlspecialchars($price);
        $info = htmlspecialchars($book['info']);
        $date = date("Y-m-d", $book['date']->getTimestamp());
        echo "<div>";
        echo "<p>$name</p>";
        echo "<ul><li>$author</li><li>$genre</li><li>$price</li><li>$date</li><li>$info</li></ul>";
        echo "</div>";
    }
}
?>