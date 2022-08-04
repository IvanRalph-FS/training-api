<?php

namespace App\Services;

class FileService
{
    public function storeFile($file, $folder = 'files', $fileName = null): string
    {
        if ($fileName) {
            return $file->storeAs($folder, $fileName);
        }

        return $file->store('public/' . $folder);
    }
}
