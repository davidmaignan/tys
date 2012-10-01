<?php

require_once __DIR__.'/bootstrap.php.cache';
require_once __DIR__.'/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArrayInput;

use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;

use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Doctrine\Common\DataFixtures\Loader;



$kernel = new AppKernel('test', true);
$kernel->boot();

$application = new Application($kernel);

$command = new DropDatabaseDoctrineCommand();
$application->add($command);
$input = new ArrayInput(array(
    'command' =>'doctrine:database:drop',
    '--force'=>true,
));

$command->run($input, new ConsoleOutput());

$connection = $application->getKernel()->getContainer()->get('doctrine')->getConnection();
if ($connection->isConnected()) {
    $connection->close();
}

$command = new CreateDatabaseDoctrineCommand();
$application->add($command);
$input = new ArrayInput(array(
    'command'=>'doctrine:database:create',
));

$command->run($input, new ConsoleOutput());


$command = new CreateSchemaDoctrineCommand();
$application->add($command);
$input = new ArrayInput(array(
    'command'=>'doctrine:schema:create',
));
$command->run($input, new ConsoleOutput());