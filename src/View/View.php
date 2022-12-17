<?php

namespace Shield\View;

class View {
    public static function make(string $view, $params = []) {
        $baseContent = self::getBasecontent();

        $viewContent = self::getViewContent($view, $params);

        echo str_replace('{{$content}}', $viewContent, $baseContent);
    }

    protected static function getBasecontent() {
        ob_start();
        include view_path() . 'layouts/layout.php';
        return ob_get_clean();
    }

    protected static function getViewContent(string $view, $params = [], $isError = false) {
        

        $view = self::parse_view($view);

        foreach ($params as $param => $value) {
            $$param = $value;
        }

        if ($isError) {
            include $view;
        }
        else {
            ob_start();
            include $view;
            return ob_get_clean();
        }
        
    }

    protected static function parse_view($view, $isError = false) {
        $path = $isError ? view_path() . 'errors/' : view_path();

        if(str_contains($view, '.')) {
            $views = explode('.', $view);
            foreach ($views as $view) {
                if (is_dir($path . $view)) {
                    $path = $path . $view . '/';
                }
            }
            $view = $path . end($views) . '.php';
        }
        else {
            $view = $path . $view . '.php';
        }

        return $view;
    }
}