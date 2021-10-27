<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface MenuItemInterface
{
    public function getIndex(): int;

    public function getDescription(): string;

    public function __toString(): string;

    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet): int;
}