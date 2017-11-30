<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/prooph/proophessor-do-symfony for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/prooph/proophessor-do-symfony/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace App\Http\View;

use Illuminate\Support\Facades\Blade;
use Illuminate\View\View;

class RiotTag
{
    private $search = ['"', PHP_EOL];

    private $replace = ['\"', ''];

    public function render(string $view)
    {
        $view = trim($view, '\'');

        $tagName   = $this->getTagNameFromView($view);
        $component = view('proophessor_do/riot-user-form')->render();

        $jsFunction = $this->extractJsFunction($component, $view);
        $component = $this->removeJsFromTemplate($component, $view);

        return 'riot.tag("' . $tagName . '", "' . str_replace($this->search, $this->replace,
                                                              $component) . '", ' . $jsFunction . ');';
    }

    private function getTagNameFromView(string $view)
    {
        $startPos = strpos($view, 'riot-');

        return substr($view, $startPos + 5);
    }

    private function extractJsFunction($template, $view)
    {
        preg_match(
            '/<script .*type="text\/javascript"[^>]*>[\s]*(?<func>function.+\});?[\s]*<\/script>/is',
            $template,
            $matches
        );

        if (!$matches['func']) {
            throw new \RuntimeException('Riot tag javascript function could not be found for tag name: ' . $view);
        }

        return $matches['func'];
    }

    private function removeJsFromTemplate($template, $tagName)
    {
        $template = preg_replace('/<script .*type="text\/javascript"[^>]*>.*<\/script>/is', '', $template);

        if (!$template) {
            throw new \RuntimeException('Riot tag template compilation failed for tag: ' . $tagName . ' with error code: ' . preg_last_error());
        }

        return $template;
    }
}
