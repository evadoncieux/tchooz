<?php

namespace App\Service\File;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    public function __construct(private readonly Filesystem $filesystem)
    {
    }

    public function upload(UploadedFile $uploadedFile, string $directory, string $filename): string
    {
        $newFilename = $filename . '.' . $uploadedFile->guessExtension();

        $uploadedFile->move('uploads/' . $directory, $newFilename);

        return $newFilename;
    }

    public function remove(string $directory, string $filename): void
    {
        if ($this->filesystem->exists('uploads/' . $directory . '/' . $filename)) {
            $this->filesystem->remove('uploads/' . $directory . '/' . $filename);
        }
    }
}
