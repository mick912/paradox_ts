<?php
namespace bin\Command\Seed;

use Core\Database\Seeder;
use Illuminate\Container\Container;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Run extends \bin\Command\Migration\Run
{
    protected Container $container;

    public function __construct(string $name, Container $container)
    {
        $this->container = $container;
        parent::__construct($name);
    }

    public function getDescription()
    {
        return 'Run seeders';
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;

        $seeders = $this->getSeeders();
        foreach ($seeders as $seeder) {
            $className = get_class($seeder);
            $this->output->writeln("<comment>running seeder \"{$className}\"</comment>");
            $seeder->run();
        }

        $this->output->writeln("<info>Seeders was success complited</info>");
        return 0;
    }

    private function getSeeders()
    {
        $oDiriterator = new \DirectoryIterator(SEEDS_DIR);
        foreach ($oDiriterator as $file) {
            if (!$file->isFile() && $file->getExtension() != 'php') continue;
            $className = '\App\Seed\\' . $file->getBasename('.php');
            $object =   $this->container->make($className);
            if ($object instanceof Seeder) {
                yield $object;
            }
        }
    }
}