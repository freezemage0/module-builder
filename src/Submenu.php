<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

final class Submenu implements MenuItemInterface
{
    private int $index;
    private string $description;
    /** @var MenuItemInterface[] */
    private array $items;

    public function __construct(int $index, string $description)
    {
        $this->index = $index;
        $this->description = $description;
        $this->items = array();
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function addItem(MenuItemInterface $item): void
    {
        $this->items[] = $item;
    }

    public function __toString(): string
    {
        return $this->description;
    }

    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet): int
    {
        $items = array();
        foreach ($this->items as $item) {
            $items[$item->getIndex()] = $item;
        }

        /** @var QuestionHelper $question */
        $question = $helperSet->get('question');
        /** @var MenuItemInterface $item */
        $item = $question->ask($input, $output, new ChoiceQuestion($this->getDescription(), $items));

        return $item->execute($input, $output, $helperSet);
    }
}