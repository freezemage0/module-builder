<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder;

use Shfm\ModuleBuilder\CodeGenerator\Context;
use Shfm\ModuleBuilder\CodeGenerator\ModuleGenerator;
use Shfm\ModuleBuilder\Question\Factory;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function str_replace;
use function var_dump;

final class CreateModuleItem implements MenuItemInterface
{
    private Factory $questionFactory;
    private ModuleGenerator $generator;

    private int $index;
    private string $description;

    public function __construct(int $index, string $description)
    {
        $this->index = $index;
        $this->description = $description;
    }

    public function setQuestionFactory(Factory $factory): void
    {
        $this->questionFactory = $factory;
    }

    public function setCodeGenerator(ModuleGenerator $generator): void
    {
        $this->generator = $generator;
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
        /** @var QuestionHelper $helper */
        $helper = $helperSet->get('question');

        $moduleId = $helper->ask($input, $output, $this->questionFactory->moduleId());
        $localPath = $helper->ask($input, $output, $this->questionFactory->localPath());

        $context = new Context();
        $context->add('LOCAL_PATH', $localPath);
        $context->add('MODULE_ID', $moduleId);
        $context->add('MODULE_CLASS_NAME', str_replace('.', '_', $moduleId));

        $this->generator->generate($context);
        $output->writeln('<info>Done!</info>');
        return 0;
    }
}