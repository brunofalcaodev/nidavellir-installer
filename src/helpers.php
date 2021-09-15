<?php

if (! function_exists('remove_directory')) {
    function remove_directory($path)
    {
        if (is_dir($path)) {
            $files = glob($path.'/*');
            foreach ($files as $file) {
                is_dir($file) ? remove_diretory($file) : unlink($file);
            }
            rmdir($path);
        }
    }
}
