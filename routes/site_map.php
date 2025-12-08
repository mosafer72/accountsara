<?php
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;
use App\Models\Category;

Route::get('/generate-sitemap', function () {

    $sitemap = Sitemap::create();

    // صفحات ثابت
    $sitemap->add(Url::create('https://accountsara.ir/')->setPriority(1.0)->setChangeFrequency('daily'));
    $sitemap->add(Url::create('https://accountsara.ir/products')->setPriority(0.9)->setChangeFrequency('daily'));
    $sitemap->add(Url::create('https://accountsara.ir/categories')->setPriority(0.8)->setChangeFrequency('weekly'));
    $sitemap->add(Url::create('https://accountsara.ir/contact')->setPriority(0.6)->setChangeFrequency('monthly'));
    $sitemap->add(Url::create('https://accountsara.ir/about')->setPriority(0.6)->setChangeFrequency('monthly'));

    // محصولات با ID
    foreach (Product::where('is_active', 1)->get() as $product) {
        $url = "https://accountsara.ir/product/" . $product->id;

        $sitemap->add(
            Url::create($url)
                ->setPriority(0.8)
                ->setChangeFrequency('weekly')
                ->setLastModificationDate($product->updated_at)
        );
    }

    // دسته‌بندی‌ها (اگر با ID هستن)
    if (class_exists(Category::class)) {
        foreach (Category::all() as $category) {

            $url = "https://accountsara.ir/category/" . $category->id;

            $sitemap->add(
                Url::create($url)
                    ->setPriority(0.7)
                    ->setChangeFrequency('weekly')
            );
        }
    }

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap generated!';
});
