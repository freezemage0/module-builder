<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class AjaxControllerItem implements MenuItemInterface
{
    private int $index;
    private string $description;

    public function __construct(int $index, string $description)
    {
        $this->index = $index;
        $this->description = $description;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function __toString(): string
    {
        return $this->description;
    }

    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet): int
    {
        /** @var QuestionHelper $question */
        $question = $helperSet->get('question');

        $moduleName = $question->ask($input, $output, new Question('Module ID:'));
        if (empty($moduleName) || count(explode('.', $moduleName)) != 2) {
            $output->writeln('Invalid module ID');
            return 1;
        }

        $controllerName = $question->ask($input, $output, new Question('Controller name:'));
        if (empty($controllerName)) {
            $output->writeln('Invalid controller name');
            return 1;
        }

        $methods = array();
        do {
            $methodName = $question->ask($input, $output, new Question('Method name (empty line to start generation): '));
            $methods[] = $methodName;
        } while (!empty($methodName));


    }
}