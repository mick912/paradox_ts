<?php
namespace bin\Command;

trait GenerateTrait
{
    public function generateFile($fileName, $content, $params)
    {
        if (!is_dir(dirname($fileName))) {
            $oldumask = umask(0);
            mkdir(dirname($fileName), 0755, true);
            umask($oldumask);
        }

        $placeholders = array_map(function ($paramName) {
            return '%' . $paramName . '%';
        }, array_keys($params));

        $content = str_replace($placeholders, array_values($params), $content);

        file_put_contents($fileName, $content);
    }
}