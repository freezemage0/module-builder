<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

final class Menu
{
    /** @var MenuItemInterface[] $items */
    private array $items;

    public string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->items = array();
    }

    public function addItem(MenuItemInterface $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
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
        $item = $question->ask($input, $output, new ChoiceQuestion($this->title, $items));

        return $item->execute($input, $output, $helperSet);
    }
}