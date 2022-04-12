<?php

$regex = "/([2-9]|[1-4][0-9]|50)\s([2-9]|[1-4][0-9]|50)\s([3-9]|[0-9][0-9]{1,2}|[1-4][0-9]{1,3}|5000)\n[a-zA-Z0-9]{2,50}\n[a-zA-Z0-9]{2,50}\n[a-zA-Z0-9]{3,5000}/";

$fileStr = file_get_contents("in.txt");

if (!preg_match($regex, $fileStr)) {
    die("Problema en la estructura del archivo" . PHP_EOL);
}

$content = explode("\n", $fileStr);
$x =  explode(" ", $content[0]);

for ($i = 0 ; $i < 3; $i++){
    $lenght[] = intval($x[$i]);

    if ($lenght[$i] != strlen($content[$i + 1])) {
        die("Numero '$lenght[$i]' no concuerda con la longitud de la cadena '" . $content[$i + 1] . "'" . PHP_EOL);
    }
}

for ($i = 1 ; $i < $lenght[2]; $i++) {
    while (substr($content[3], $i - 1, 1) == substr($content[3], $i, 1)) {
        $content[3] = substr_replace($content[3], "", $i, 1);
        $lenght[2] --;

        if ($lenght[2] == $i) {
            break;
        }
    }
}

$outFile = fopen("out.txt", "w");

for ($i = 0;$i + $lenght[0] < strlen($content[3]); $i++){
    if ($content[1] === substr($content[3], $i, $lenght[0])) {
        fwrite($outFile, "Si");
        break;
    } else {
        if (($i + $lenght[0]) == (strlen($content[3]) - 1)) {
            fwrite($outFile, "No");
        }
    }
}

for ($i = 0;$i + $lenght[1] < strlen($content[3]); $i++){
    if ($content[2] === substr($content[3], $i, $lenght[1])) {
        fwrite($outFile, "\nSi");
        break;
    } else {
        if (($i + $lenght[1]) == (strlen($content[3]) - 1)) {
            fwrite($outFile, "\nNo");
        }
    }
}

fclose($outFile);



