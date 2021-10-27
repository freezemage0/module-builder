<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder\CodeGenerator;

use function dirname;
use function var_dump;

class ModuleGenerator
{
    private Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function generate(Context $context): void
    {
        $root = dirname(__DIR__, 2) . '/template/module';
        $target = sprintf('%s/modules/%s/install/index.php', $context->get('LOCAL_PATH'), $context->get('MODULE_ID'));

        $template = new Template($root . '/index', $target);
        $this->builder->build($template, $context);
    }
}