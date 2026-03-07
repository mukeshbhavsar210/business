<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductCard extends Component {
    public $product;
    public $category;

    public function __construct($product = null, $category = null) {
        $this->product = $product;
        $this->category = $category;
    }    

    public function render() {
        return view('components.product-card');
    }
}
