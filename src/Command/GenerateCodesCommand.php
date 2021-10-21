<?php

namespace App\Command;

use App\Service\GenerateCode;
use App\Service\GenerateFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class GenerateCodesCommand extends Command
{
    protected static $defaultName = 'app:generate-codes';
    protected static $defaultDescription = 'Command CLI to generates random codes';



    private Filesystem $filesystem;
    private $filePath;
    private GenerateFile $generateFile;
    private GenerateCode $code;

    public function __construct(
        string $name = null,
        Filesystem   $filesystem,
        $filePath,
        GenerateFile $generateFile,
        GenerateCode $code
    ) {

        parent::__construct($name);
        $this->filesystem = $filesystem;

        $this->filePath = $filePath;
        $this->generateFile = $generateFile;
        $this->code = $code;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command generate random codes...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the lenght of codes: ');


        $question2 = new Question('Please enter the number of codes: ');


        $this->getHelper('question');

        $len = $helper->ask($input, $output, $question);
        $num = $helper->ask($input, $output, $question2);
        $io = new SymfonyStyle($input, $output);


        if ($len !== null && $num !== null) {
            $codes = $this->code->generate((int)$num, (int)$len);
            $this->filesystem->mkdir($this->getFilePathDirectory());
            $this->filesystem->touch($this->getFilePathDirectory() . '/kody.txt');

            $this->generateFile->writeCodesToFile($codes);


            $io->createProgressBar($num);

            $io->info(sprintf(
                'You create file in path %s with code: Lenght of codes: %s and number of codes: %s',
                $this->getFilePathDirectory(),
                $len,
                $num
            ));
            return Command::SUCCESS;
        }

        $io->error("Number of codes and lenght cannot be empty!");
        return  Command::FAILURE;
    }

    public function getFilePathDirectory()
    {
        return $this->filePath;
    }
}
