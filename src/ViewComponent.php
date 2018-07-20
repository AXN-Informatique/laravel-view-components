<?php

namespace Axn\ViewComponents;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;

abstract class ViewComponent implements Htmlable, Renderable
{
    /**
     * The component's data, coming from the parent view.
     *
     * @var array
     */
    private $data = [];

    /**
     * Make a new view component.
     *
     * @param  string $class
     * @param  array  $data
     * @return void
     */
    public static function make($class, array $data = [])
    {
        $component = app($class);

        if (!$component instanceof static) {
            throw new ViewComponentException(
                $class.' must be an instance of '.__CLASS__
            );
        }

        $component->data = $data;

        return $component;
    }

    /**
     * Get a piece of data from the component.
     *
     * @param  string  $key
     * @return mixed
     */
    public function &__get($key)
    {
		if (!isset($this->data[$key])) {
			return null;
		}

        return $this->data[$key];
    }

    /**
     * Set a piece of data on the component.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Check if a piece of data is bound to the component.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Remove a piece of bound data from the component.
     *
     * @param  string  $key
     * @return bool
     */
    public function __unset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Compose the component: contains the logic and returns the content.
     *
     * @return mixed
     */
    abstract protected function compose();

    /**
     * Get the evaluated content of the component.
     *
     * @return string
     */
    public function render()
    {
        $content = $this->compose();

        if ($content instanceof Htmlable) {
            $content = $content->toHtml();
        }
        elseif ($content instanceof Renderable) {
            $content = $content->render();
        }

        return (string) $content;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->render();
    }

	/**
     * Get the string content of the component.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
