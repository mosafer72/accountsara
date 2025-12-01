<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $last_products = Product::limit(3)->get();
        $sliders = Product::limit(7)->get();
        $most_sell = Product::orderBy("sell_count")->limit(3)->get();
        $low_sell = Product::orderBy("sell_count", "desc")->limit(7)->get();
        return View("Pages.index", compact(["low_sell", "sliders", "last_products", "most_sell"]));
    }
    public function about_us()
    {
        return View("Pages.about_us");

    }

    public function faq()
    {
        return View("Pages.faq");

    }

}
