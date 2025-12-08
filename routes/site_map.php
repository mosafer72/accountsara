<?php


use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;

Route::get('/generate-sitemap', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/')->setPriority(1.0))
        ->add(Url::create('/products')->setPriority(0.9))
        ->add(Url::create('/categories')->setPriority(0.8))
        ->add(Url::create('/contact')->setPriority(0.6))
        ->add(Url::create('/about')->setPriority(0.6));

    foreach (Product::all() as $product) {
        $sitemap->add(
            Url::create("/product/{$product->slug}")
                ->setPriority(0.8)
                ->setChangeFrequency('weekly')
        );
    }

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap generated!';
});
