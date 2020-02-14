<?php

namespace App;

class CacheKeys
{
    public static function articleIndex($request)
    {
        $params = http_build_query($request->only('page', 'sort', 'include'));

        return 'articles.index::' . $params;
    }

    public static function articleShow($articleId, $request)
    {
        $params = http_build_query($request->only('include'));

        return 'articles.show::' . $articleId . '::' . $params;
    }
}
