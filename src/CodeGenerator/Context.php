<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder\CodeGenerator;

final class Context
{
    private array $items;

    public function __construct()
    {
        $this->items = array();
    }

    public function add(string $placeholder, string $value): void
    {
        $this->items[$placeholder] = $value;
    }

    public function has(string $placeholder): bool
    {
        return isset($this->items[$placeholder]);
    }

    public function get(string $placeholder): string
    {
        return $this->items[$placeholder];
    }
}