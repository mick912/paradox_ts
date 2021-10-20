<?php
namespace bin\Command\Seed;

use bin\Command\GenerateTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends Command
{
    use GenerateTrait;

    protected OutputInterface $output;

    protected InputInterface $input;

    public function getDescription()
    {
        return 'Generate seed file';
    }

    public function configure()
    {
        $this->setDefinition([
            new InputOption('file', 'f', InputOption::VALUE_REQUIRED, 'File name for generating seed'),
        ]);
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;
        $this->checkInput();

        $fileNameName = $this->getSeedFileName();

        $this->generateFile($fileNameName, $this->getFileContent(), $aParams =
            [
                'name' => $this->getUcOption('file'),
            ]);

        $this->output->writeln("<info>Seed file was successful created</info>");
        return 0;
    }

    protected function getUcOption($sName)
    {
        return ucfirst($this->input->getOption($sName));
    }

    protected function checkInput()
    {
        $fileName = $this->getSeedFileName();

        if (file_exists($fileName)) {
            $this->output->writeln("<error>Seed file\"{$this->getUcOption('file')}\" is already exists!</error>");
            exit(1);
        }
    }

    protected function getSeedFileName()
    {
        return SEEDS_DIR . $this->getUcOption('file') . 'Seeder.php';
    }

    protected function getFileContent()
    {
        return <<<'content'
<?php
namespace App\Seed;

use Core\Database\Seeder;

Class %name%Seeder extends Seeder
{

    /**
     * Run the database Seed.
     *
     * @return void
     */
    public function run()
    {
        //todo::define method logic
    }

}
content;
    }

}