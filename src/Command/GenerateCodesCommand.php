<?php

namespace App\Command;

use App\Service\GenerateCode;
use App\Service\GenerateFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class GenerateCodesCommand extends Command
{
    protected static $defaultName = 'app:generate-codes';
    protected static $defaultDescription = 'Command CLI to generates random codes';
    private Filesystem $filesystem;

    public function __construct(string $name = null,Filesystem $filesystem)
{
    $this->filesystem = $filesystem;

    parent::__construct($name);
}

    protected function configure(): void
    {
        $this
//            ->addArgument('lengthOfCodes', InputArgument::REQUIRED,'Lenght of codes')
//            ->addArgument('numberOfCodes', InputArgument::REQUIRED,'Number of Codes')
            ->setHelp('This command generate random codes...')
        ;
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
//        $arg1 = $input->getArgument('lengthOfCodes');
//        $arg2 = $input->getArgument('numberOfCodes');
//
        if ($len && $num) {
            $code = new GenerateCode();
            $codes = $code->generate((int)$num, (int)$len);
            $file = new GenerateFile($this->filesystem);
            $file->createFile();
            $file->writeCodesToFile($codes);
            $io->success(sprintf('You passed an argument: %s and %s', $len, $num));
        }

//        if ($input->getOption('option1')) {
//            // ...
//        }

       // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
