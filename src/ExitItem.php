<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExitItem implements MenuItemInterface
{
    private int $index;
    private string $description;

    public MenuItemInterface $parent;

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
        if (!isset($this->parent)) {
            $output->writeln('Goodbye');
            return 0;
        }

        return $this->parent->execute($input, $output, $helperSet);
    }
}