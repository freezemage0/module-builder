<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder\CodeGenerator;

use InvalidArgumentException;
use function is_file;
use function var_dump;

final class Template
{
    private const TEMPLATE_EXTENSION = 'template';

    public string $origin;
    public string $target;

    public function __construct(string $origin, string $target)
    {
        $origin .= '.' . Template::TEMPLATE_EXTENSION;
        if (!is_file($origin)) {
            throw new InvalidArgumentException('Template file does not exist');
        }
        $this->origin = $origin;
        $this->target = $target;
    }
}