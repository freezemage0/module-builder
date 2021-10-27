<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder\CodeGenerator;

use OutOfRangeException;
use function dirname;
use function file_get_contents;
use function file_put_contents;
use function is_dir;
use function mkdir;
use function preg_replace_callback;

final class Builder
{
    private const PATTERN = '/{{(\\w+)}}/';

    public function build(Template $template, Context $context): void
    {
        $content = preg_replace_callback(
                Builder::PATTERN,
                function (array $matches) use ($context): string {
                    $placeholder = $matches[1];
                    if (!$context->has($placeholder)) {
                        throw new OutOfRangeException(sprintf('Unknown placeholder "%s"', $placeholder));
                    }
                    return $context->get($placeholder);
                },
                file_get_contents($template->origin)
        );

        $targetDirectory = dirname($template->target);
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        file_put_contents($template->target, $content);
    }
}