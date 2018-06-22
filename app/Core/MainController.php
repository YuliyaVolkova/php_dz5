<?php

namespace App\Core;

use Intervention\Image\ImageManagerStatic as IImage;

class MainController
{
    protected $view;
    public $imageBefore = PUBLIC_PATH . '/db.jpg';
    public $imageAfter = PUBLIC_PATH . '/dbResult.jpg';

    public function __construct()
    {
        $this->view = new View();
    }

    public function index()
    {
        $this->imageHandler($this->imageBefore, $this->imageAfter);
        $this->view->render('index', []);
    }

    static function imageHandler($imageBefore, $imageAfter)
    {
        putenv('GDFONTPATH=' . realpath(PUBLIC_PATH));
        $image = IImage::make($imageBefore);
            $image->rotate(45)
            ->text(
                'Watermark',
                $image->width() / 2,
                $image->height() / 2,
                function ($font) {
                    $font->file(PUBLIC_PATH . DIRECTORY_SEPARATOR . 'arial.ttf')
                        ->size('120');
                    $font->color(array(132, 198, 229, 0.5));
                    $font->align('center');
                    $font->valign('center');
                })
            ->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($imageAfter, 90);
    }
}
