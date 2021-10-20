<?php
namespace bin\Command\Migration;

use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Run extends Command
{
    protected OutputInterface $output;
    /**
     * @var InputInterface
     */
    protected InputInterface $input;

    protected array $completed = [];

    public function getDescription()
    {
        return 'Run migrations';
    }

    public function execute(InputInterface $oInput, OutputInterface $oOutput)
    {
        $this->output = $oOutput;
        $this->input = $oInput;

        $this->runMigrations($this->getMigrations());
        $this->output->writeln("<info>Migrations was successfully finished</info>");
        return 0;
    }

    protected function runMigrations(iterable $migrations):void
    {
        foreach ($migrations as $migration) {
            $className = get_class($migration);
            if (in_array($className, $this->completed)) {
                continue;
            }
            $dependencies = $migration->getDependencies();
            if ($migration->getDependenciesCount() > 0) {
                $this->runMigrations($dependencies);
            }
            $this->output->writeln("<comment>running migration \"{$className}\"</comment>");
            $this->runMigration($migration);
            $this->completed[] = $className;
        }
    }

    protected function runMigration($migration)
    {
        $migration->up();
    }

    private function getMigrations(): iterable
    {
        $dirIterator = new \DirectoryIterator(MIGRATIONS_DIR);
        foreach ($dirIterator as $file) {
            if (!$file->isFile() && $file->getExtension() != 'php') continue;
            $className = '\App\Migrations\\' . $file->getBasename('.php');
            $object = new $className();
            if ($object instanceof Migration) {
                yield $object;
            }
        }
    }
}