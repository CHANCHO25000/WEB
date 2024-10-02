<?php
$directory = 'C:/xampp/htdocs/prueba/Carpetas1';
$file_to_search = $_POST['n_archivo'];

function searchFile($directory, $file_to_search)
{
    $results = [];

    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $file_path = $directory . '/' . $file;

        if (is_dir($file_path)) {
            $sub_results = searchFile($file_path, $file_to_search);
            $results = array_merge($results, $sub_results);
        } else {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'html' || pathinfo($file, PATHINFO_EXTENSION) === 'js') {
                if (strpos($file, $file_to_search) !== false) {
                    $results[] = ['path' => $file_path, 'name' => $file];
                }
            }
        }
    }

    return $results;
}

$results = searchFile($directory, $file_to_search);

if (empty($results)) {
    echo "No se encontraron archivos.";
} else {
    echo "<ul>";
    foreach ($results as $result) {
        echo "<li><a href='{$result['path']}' target='_blank'>{$result['name']}</a></li>";
    }
    echo "</ul>";
}
?>