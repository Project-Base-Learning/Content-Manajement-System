<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Page;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Route;

abstract class Controller
{
    protected function data()
    {
        $data = config('general-settings');

        if (Route::currentRouteName() == '/' && !empty($data['navigation']['home'])) {
            $data['page'] = Page::where('slug', $data['navigation']['home']['slug'])->firstOrFail();
        } else {
            $data['page'] = Page::where('slug', Route::currentRouteName())->firstOrFail();
        }

        if ($data['features']['sponsors']) {
            $data['sponsors'] = Sponsor::where('featured', 1)->get();
        }
        $data['sections'] = [];
        foreach ($data['page']->sections as $section) {
            $data['sections'][$section->section->title] = $section->section;
            if ($section->section->has_dataset) {
                $tmp = $section->section->dataset;
                $tmp2 = Article::query()->whereNotNull('published_at');
                $tmp2 = $tmp2->where([
                    ['category_id', $tmp->category->id],
                    ['private', 0]
                ]);
                $tmp2 = $tmp2->orderBy($tmp->order_col, $tmp->order_sort);
                if ($tmp->paginate) {
                    if ($tmp->paginate == 'default') {
                        $tmp2 = $tmp2->paginate($tmp->limit, ['*'], $tmp->variable_name.'_page');
                    } else if ($tmp->paginate == 'simple') {
                        $tmp2 = $tmp2->simplePaginate($tmp->limit, ['*'], $tmp->variable_name.'_page');
                    }
                } else {
                    $tmp2 = $tmp2->take($tmp->limit)->get();
                }
                $data['loads'][$tmp->variable_name] = $tmp2;
            }
        }
        return $data;
    }
}
