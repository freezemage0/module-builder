<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */


use Shfm\ModuleBuilder\CodeGenerator\Builder;
use Shfm\ModuleBuilder\CodeGenerator\ModuleGenerator;
use Shfm\ModuleBuilder\CreateModuleItem;
use Shfm\ModuleBuilder\Menu;
use Shfm\ModuleBuilder\MenuCommand;
use Shfm\ModuleBuilder\Question\Factory;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$builder = new Builder();
$moduleGenerator = new ModuleGenerator($builder);
$questionFactory = new Factory();

$command = new MenuCommand();
$menu = new Menu('Module Builder');

$newModule = new CreateModuleItem(1, 'Create new module');
$newModule->setCodeGenerator($moduleGenerator);
$newModule->setQuestionFactory($questionFactory);

$menu->addItem($newModule);
$command->setMenu($menu);

$app = new Application('Module Builder', '0.0.0');
$app->add($command);
$app->run();