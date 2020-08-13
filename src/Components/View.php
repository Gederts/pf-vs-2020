<?php

namespace Project\Components;

    use Exception;

class View
{
    private string $viewName;
    private array $data;
    private string $layoutName = '';

    public function __construct(string $viewName, array $data, string $layoutName = '')
    {
        $this->viewName = $viewName;
        $this->data = $data;
        $this->layoutName = $layoutName;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function render(): string
    {
        $filePath = $this->resolveFilePath();

        extract($this->data);

        ob_start();
        include $filePath;
        $content = ob_get_clean();

        return $content;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function resolveFilePath(): string
    {
        $filePath = PROJECT_VIEW_DIR . '/' . $this->viewName . '.php';

        if (!$this->viewName || !file_exists($filePath)) {
            throw new Exception("View '{$this->viewName}' not found");
        }

        return $filePath;
    }
}
