<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Shfm\ModuleBuilder\Question;

use InvalidArgumentException;
use Symfony\Component\Console\Question\Question;
use function getcwd;
use function is_dir;

final class Factory
{
    public function moduleId(): Question
    {
        $moduleId = new Question('Module ID: ');
        $moduleId->setValidator(function ($response): string {
            if (empty($response) || count(explode('.', $response)) != 2) {
                throw new InvalidArgumentException('Invalid module name.');
            }

            return $response;
        });
        return $moduleId;
    }

    public function localPath(): Question
    {
        $localPath = new Question('Path to /local/ directory: ', getcwd());
        $localPath->setValidator(function ($response): ?string {
            if (empty($response)) {
                return null;
            }

            if (!is_dir($response)) {
                throw new InvalidArgumentException('Invalid path.');
            }

            return $response;
        });
        return $localPath;
    }

    public function moduleName(): Question
    {

    }

    public function partnerName(): Question
    {

    }

    public function partnerUri(): Question
    {

    }
}