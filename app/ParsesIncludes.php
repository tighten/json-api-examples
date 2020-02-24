<?php

namespace App;

use Exception;

trait ParsesIncludes
{
    public function requestedIncludes($request)
    {
        if (! $request->input('include')) {
            return collect([]);
        }

        $includes = collect(explode(',', $request->input('include')));

        $includes->each(function ($include) {
            if (! in_array($include, $this->allowedIncludes)) {
                throw new Exception("Invalid include requested: {$include}");
            }
        });

        return $includes;
    }
}
