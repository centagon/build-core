<?php

namespace Build\Core\Resources;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Asset
{

    /**
     * Holds the style references.
     * @var \Illuminate\Support\Collection
     */
    protected $stylesheetReferences;

    /**
     * Holds the inlined styles.
     * @var \Illuminate\Support\Collection
     */
    protected $inlinedStyles;

    /**
     * Holds the javascript references.
     * @var \Illuminate\Support\Collection
     */
    protected $javascriptReferences;

    /**
     * Holds the inline scripts.
     * @var \Illuminate\Support\Collection
     */
    protected $inlinedScripts;

    /**
     * Asset constructor.
     */
    public function __construct()
    {
        $this->stylesheetReferences = collect();
        $this->inlinedStyles        = collect();

        $this->javascriptReferences = collect();
        $this->inlinedScripts       = collect();
    }

    /**
     * Push a stylesheet on the stack.
     *
     * @param  string  $path
     *
     * @return $this
     */
    public function addStylesheet($path)
    {
        $this->stylesheetReferences->push($path);

        return $this;
    }

    public function addJavascript($path)
    {
        $this->javascriptReferences->push($path);

        return $this;
    }

    /**
     * Push a inline stylesheet on the stack.
     *
     * @param  string  $string
     *
     * @return $this
     */
    public function inlineStyle($string)
    {
        $this->inlinedStyles->push($string);

        return $this;
    }

    public function inlineScript($string)
    {
        $this->inlinedScripts->push($string);

        return $this;
    }

    /**
     * Render the styles.
     *
     * @return string
     */
    public function styles()
    {
        $references = $this->stylesheetReferences->map(function ($style) {
            return $this->wrapReferenceStyle($style);
        });

        $inlines = $this->inlinedStyles->map(function ($style) {
            return $this->wrapInlineStyles($style);
        });

        return implode("\n", array_merge($references->toArray(), $inlines->toArray()));
    }

    public function scripts()
    {
        $references = $this->javascriptReferences->map(function ($script) {
            return $this->wrapReferenceScript($script);
        });

        $inlines = $this->inlinedScripts->map(function ($style) {
            return $this->wrapInlineScripts($style);
        });

        return implode("\n", array_merge($references->toArray(), $inlines->toArray()));
    }

    protected function wrapReferenceStyle($style)
    {
        return sprintf('<link rel="stylesheet" href="%s" />', $style);
    }

    protected function wrapReferenceScript($script)
    {
        return sprintf('<script src="%s"></script>', $script);
    }

    /**
     * Wrap inline styles with the <style> tag.
     *
     * @param  string  $style
     *
     * @return string
     */
    protected function wrapInlineStyles($style)
    {
        return '<style>' . $style . '</style>';
    }

    protected function wrapInlineScripts($script)
    {
        return '<script>' . $script . '</script>';
    }
}
