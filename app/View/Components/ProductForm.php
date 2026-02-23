<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductForm extends Component {
    public $product;
    public $route;
    public $formname;
    public $method;
    public $buttonText;
    public $title;
    public $categories;
    public $subcategories;
    public $subsubcategories;
    public $brands;
    public $colors;
    public $sizes;
    public $productimages;

    public function __construct(
        $product = null, 
        $route, 
        $formname = null,
        $title = null,
        $method = 'POST', 
        $categories = null, 
        $subcategories = null, 
        $subsubcategories = null, 
        $brands = null,
        $colors = null,
        $sizes = null,
        $productimages = null,
        $buttonText = 'Save')
    {
        $this->product = $product;
        $this->title = $title;
        $this->route = $route;
        $this->formname = $formname;
        $this->method = $method;
        $this->categories = $categories;
        $this->subcategories = $subcategories;
        $this->subsubcategories = $subsubcategories;
        $this->brands = $brands;
        $this->colors = $colors;
        $this->sizes = $sizes;
        $this->productimages = $productimages;
        $this->buttonText = $buttonText;
    }

    public function render() {
        return view('components.product-form');
    }
}
