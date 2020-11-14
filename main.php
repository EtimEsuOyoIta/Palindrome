function shortestPalSuper($word) {
  $prefix = $suffix = "";
  $letters = str_split($word);
  $ls = [];
  $len = 0;
  $prev = "";
  for ($index = 0; $index < strlen($word); $index++) {
    if (isset($prev) && strlen($prev) == 2) $index++;
    $letter = $letters[$index];
    $next = array_key_exists($index + 1, $letters) ? $letters[$index + 1] : null;
    $doubleFound = isset($next) && ($letter == $next);
    if ($doubleFound) {
      $letter .= $next;
      $ls[] = $letter;
    } else {
      $ls[] = $letter;
    }
    $len += strlen($letter);
    if ($len == strlen($word)) break;
    $prev = $letter;
  }
  $letters = $ls;

  $short = "_";

  $containsAll = function($word) use ($letters) {
    $strikes = 0;
    $pos = -1;
    foreach ($letters as $letter) {
      $pos = strpos($word, $letter, $pos + 1);
      if ($pos === false) {
        $strikes++;
        break;
      }
    }
    return ($strikes == 0);
  };

  $prev = "";
  foreach ($letters as $letter) {
    $fill = $letter. "_". $letter;
    $short = str_ireplace("_", $fill, $short);
    if ($containsAll($short)) {
      $jim = $letter. (($prev == $letter) ? $letter : "");
      $short = str_ireplace($fill, $jim, $short);
    }
    $prev = $letter;
  }
  return $short;
}

function run() {
  echo "\nY: Run\nOther: Quit\n\n";
  $opt = readline("Mode?");
  switch (strtolower($opt)) {
    case "y":
      $args = readline("word: ");
      echo "Shortest palindrome supersequence is: ". shortestPalSuper($args);
      run();
      break;

    default:
      die();
      exit();
  }
}

run();
