<?php

namespace App\Nova;

use Drobee\NovaSluggable\Slug;
use Drobee\NovaSluggable\SluggableText;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Category extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Category::class;
    public static function label()
    {
        return 'Kategoriler';
    }
    public static function singularLabel(){
        return 'Kategori';
    }
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            SluggableText::make('Adı', 'name'),
            Slug::make('Slug')->slugUnique()
                ->slugModel(static::$model),
            Images::make('Images', 'image')
                ->conversionOnDetailView('thumb') // conversion used on the model's view
                ->conversionOnIndexView('thumb') // conversion used to display the image on the model's index page
                ->conversionOnForm('thumb') // conversion used to display the image on the model's form
                ->fullSize() // full size column
                ->singleImageRules('dimensions:min_width=100'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
