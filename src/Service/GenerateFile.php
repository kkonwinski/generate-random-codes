<?php

namespace App\Service;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class GenerateFile implements GenerateFileInterface
{

    private Filesystem $filesystem;

    private $filePath;

    public function __construct(Filesystem $filesystem, $filePath)
    {
        $this->filesystem = $filesystem;
        $this->filePath = $filePath;
    }

    public function createFile(): void
    {

        try {
            $this->filesystem->mkdir($this->getFilePathDirectory());
            $this->filesystem->touch($this->getFilePathDirectory() . '/kody.txt');
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }
    }

    public function writeCodesToFile(array $randomCodes): bool
    {

        foreach ($randomCodes as $code) {
            $this->filesystem->appendToFile($this->getFilePathDirectory() . '/kody.txt', $code . "\r\n");
        }
        return true;
    }

    public function getFilePathDirectory()
    {
        return $this->filePath;
    }
}
