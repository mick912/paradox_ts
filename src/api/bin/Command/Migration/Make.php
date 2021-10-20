<?php
namespace bin\Command\Migration;

use bin\Command\GenerateTrait;
use Illuminate\Database\Schema\Blueprint;
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
        return 'Generates migration file to module';
    }

    public function configure()
    {
        $this->setDefinition([
            new InputOption('name', 'nm', InputOption::VALUE_REQUIRED, 'File name for generating migration'),
        ]);
        parent::configure();
    }

    public function execute(InputInterface $oInput, OutputInterface $oOutput)
    {
        $this->output = $oOutput;
        $this->input = $oInput;
        $this->checkInput();

        $fileName = $this->getMigrationFileName();

        $this->generateFile($fileName, $this->getFileContent(), $aParams =
            [
                'name' => $this->getUcOption('name'),
            ]);

        $this->output->writeln("<info>Migration file was successfully created</info>");
        return 0;
    }

    protected function getUcOption($name)
    {
        return ucfirst($this->input->getOption($name));
    }

    protected function checkInput()
    {
        $sFile = $this->getMigrationFileName();

        if (file_exists($sFile)) {
            $this->output->writeln("<error>Migration file\"{$this->getUcOption('name')}\"is already exists!</error>");
            exit(1);
        }
    }

    protected function getMigrationFileName()
    {
        return MIGRATIONS_DIR . $this->getUcOption('name') . '.php';
    }

    protected function getFileContent()
    {
        return <<<'content'
<?php
namespace App\Migrations;

use Core\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

Class %name% extends Migration
{

    public function up()
    {
        //todo::define method content
        //$this->schema()->create('users', function (Blueprint $table) {
        //    $table->unique('email');
        //    $table->unique('username');
        //});
    }

    public function down()
    {
        //todo::define method content
    }

}
content;
    }
}