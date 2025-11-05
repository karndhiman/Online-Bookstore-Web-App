@extends('layouts.app')

@section('title', 'Sell Your Books - Online BookStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Sell Your Books</h4>
                    <p class="text-muted mb-0">Fill out the form below to list your book for sale</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Book Information -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Book Information</h5>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Book Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Author *</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                       id="author" name="author" value="{{ old('author') }}" required>
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="isbn" class="form-label">ISBN</label>
                                        <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                               id="isbn" name="isbn" value="{{ old('isbn') }}">
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="genre" class="form-label">Genre *</label>
                                        <select class="form-select @error('genre') is-invalid @enderror" id="genre" name="genre" required>
                                            <option value="">Select Genre</option>
                                            <option value="fiction">Fiction</option>
                                            <option value="non-fiction">Non-Fiction</option>
                                            <option value="science">Science</option>
                                            <option value="technology">Technology</option>
                                            <option value="history">History</option>
                                            <option value="biography">Biography</option>
                                            <option value="fantasy">Fantasy</option>
                                            <option value="mystery">Mystery</option>
                                            <option value="romance">Romance</option>
                                            <option value="children">Children's Books</option>
                                        </select>
                                        @error('genre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Book Condition & Pricing -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Condition & Pricing</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="condition" class="form-label">Condition *</label>
                                        <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                                            <option value="">Select Condition</option>
                                            <option value="new">New</option>
                                            <option value="like-new">Like New</option>
                                            <option value="very-good">Very Good</option>
                                            <option value="good">Good</option>
                                            <option value="acceptable">Acceptable</option>
                                        </select>
                                        @error('condition')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price ($) *</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" min="1" max="1000" step="0.01" value="{{ old('price') }}" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity Available *</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" name="quantity" min="1" max="100" value="{{ old('quantity', 1) }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Book Images -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Book Images</h5>
                            
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Cover Image *</label>
                                <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                       id="cover_image" name="cover_image" accept="image/*">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Upload a clear image of the book cover (max 2MB)</div>
                            </div>

                            <div class="mb-3">
                                <label for="additional_images" class="form-label">Additional Images</label>
                                <input type="file" class="form-control" 
                                       id="additional_images" name="additional_images[]" multiple accept="image/*">
                                <div class="form-text">You can upload up to 4 additional images</div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Shipping Information</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Shipping Method</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping_method" id="standard" value="standard" checked>
                                    <label class="form-check-label" for="standard">
                                        Standard Shipping (5-7 business days) - Free
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping_method" id="express" value="express">
                                    <label class="form-check-label" for="express">
                                        Express Shipping (2-3 business days) - $5.99
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Submit -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" 
                                   id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" target="_blank">Terms and Conditions</a> and confirm that this book is authentic and I have the right to sell it.
                            </label>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">List Book for Sale</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection