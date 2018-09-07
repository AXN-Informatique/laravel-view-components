<?php

if (!function_exists('render')) {
    /**
     * Get the evaluated content of a view component.
     *
     * @param  string $class
     * @param  array  $data
     * @return string
     */
    function render($class, array $data = [])
    {
        return \Axn\ViewComponents\ViewComponent::make($class, $data)->render();
    }
}
