@csrf

<div class="mb-3">
    <label>Product Name</label>
    <input type="text" name="name" class="form-control"
        value="{{ old('name', $product->name ?? '') }}">
</div>

<div class="mb-3">
    <label>Price</label>
    <input type="number" name="price" class="form-control"
        value="{{ old('price', $product->price ?? '') }}">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">
        {{ old('description', $product->description ?? '') }}
    </textarea>
</div>

<button type="submit" class="btn btn-primary">
    {{ $buttonText }}
</button>