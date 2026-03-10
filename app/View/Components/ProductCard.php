<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductCard extends Component {
    public $product;
    public $category;
    public $wishlist;

    public function __construct($product = null, $category = null, $wishlist = null) {
        $this->product = $product;
        $this->category = $category;
        $this->wishlist = $wishlist;
    }    

    public function render() {
        return view('components.product-card');
    }
}
