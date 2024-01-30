<?php

$folder = __DIR__ . "/Parts";

function elencaFile($cartella) {
    $files = array();
    $cartella = rtrim($cartella, '/\\');

    if (is_dir($cartella) && $handle = opendir($cartella)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $filePath = $cartella . '/' . $file;
                if (is_dir($filePath)) {
                    $files = array_merge($files, elencaFile($filePath));
                } else {
                    $fileInfo = pathinfo($filePath);
                    $id = $fileInfo['filename'];
		    $img = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filePath);
		    $category = substr($cartella,strrpos($cartella,'/')+1);
                    $files[] = array(
                        'id' => $id,
			'img' => $img,
			'cat' => $category

		    );
                }
            }
        }
        closedir($handle);
    }

    return $files;
}

$contenuto = elencaFile($folder);
// Stampa il risultato in formato JSON
header('Content-Type: application/json');
echo json_encode($contenuto, JSON_UNESCAPED_SLASHES);

?>

