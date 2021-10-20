<?php

namespace App\Service;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class GenerateFile
{
    const TMP_DIR_PATH = "../tmp";

    private Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function createFile(): void
    {

        try {
            $this->filesystem->mkdir(self::TMP_DIR_PATH);
            $this->filesystem->touch(self::TMP_DIR_PATH . '/kody.txt');
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }
    }

    public function writeCodesToFile(array $randomCodes): bool
    {

        foreach ($randomCodes as $code) {
            $this->filesystem->appendToFile(self::TMP_DIR_PATH . '/kody.txt', $code . "\r\n");
        }
        return true;

    }
}
