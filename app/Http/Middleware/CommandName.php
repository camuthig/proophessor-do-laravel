<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class CommandName
{
    public function handle(Request $request, \Closure $next) {
        $alias = basename($request->url());
        $name = config(sprintf('app.command_alias.%s', $alias));

        if ($name === null) {
            throw new \Exception(sprintf('Unknown command alias %s', $alias));
        }

        $request->attributes->add(['prooph_command_name' => $name]);

        return $next($request);
    }
}
