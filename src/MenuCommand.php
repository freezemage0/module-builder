<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

final class MenuCommand extends Command
{
    private Menu $menu;

    protected function configure(): void
    {
        $this->setDescription('Run module builder')->setName('run');
    }

    public function getMenu(): Menu
    {
        return $this->menu;
    }

    public function setMenu(Menu $menu): void
    {
        $this->menu = $menu;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $items = array();
        foreach ($this->menu->getItems() as $item) {
            $items[$item->getIndex()] = $item;
        }

        $choice = new ChoiceQuestion('Choose one:', $items);
        /** @var MenuItemInterface $item */
        $item = $questionHelper->ask($input, $output, $choice);
        return $item->execute($input, $output, $this->getHelperSet());
    }
}