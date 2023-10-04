@extends('hotel-page.layout')

@section('content')
    <section class="content">
        <div class="container">
            <h1 style="text-align:center">Manage Products</h1>
            <button class="btn btn-primary" id="addProductBtn" data-toggle="modal" data-target="#productModal"
                    style="border-color: #3c8dbc; background-color: #3c8dbc; color: white;">Add Product
            </button>
            <table class="table mt-4 table-bordered"
                   style="border-color: #3c8dbc; border: 2px solid #FFC107; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15); border-radius: 5px;">
                <thead>
                <tr class="table-header" style="background-color: #ffc107; color: white;">
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Vegetarian</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="productTableBody">
                <!-- Products will be displayed here -->
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Product Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3c8dbc; color: white;">
                        <h5 class="modal-title" id="productModalLabel">Add/Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 20px;">
                        <form id="productForm">
                            @csrf <!-- Include the CSRF token -->
                            <input type="hidden" id="productId" name="productId">
                            <h6>Name</h6>
                            <input type="text" class="form-control" id="productName" name="productName"
                                   placeholder="Enter product name" style="width: 100%;">
                            <h6>Description</h6>
                            <textarea class="form-control" id="productDescription" name="productDescription"
                                      placeholder="Enter product description" style="width: 100%;"></textarea>
                            <h6>Price</h6>
                            <input type="number" class="form-control" id="productPrice" name="productPrice"
                                   placeholder="Enter product price" style="width: 100%;">
                            <h6>Vegetarian</h6>
                            <select class="form-control" id="productVegetarian" name="productVegetarian"
                                    style="width: 100%;">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <h6>Category</h6>
                            <input type="text" class="form-control" id="productCategory" name="productCategory"
                                   placeholder="Enter product category" style="width: 100%;">
                            <h6>Image URL</h6>
                            <input type="text" class="form-control" id="productImage" name="productImage"
                                   placeholder="Enter product image URL" style="width: 100%;">
                            <button type="button" class="btn btn-primary" id="productSubmitBtn"
                                    style="border-color: #3c8dbc; background-color: #28a745; margin-top:10px; color: white;">
                                Submit
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer" style="background-color: #3c8dbc; color: white;">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            // Function to fetch products from the API and populate the table
            function fetchProducts() {
                var productTableBody = $('#productTableBody');
                productTableBody.html('');

                $.ajax({
                    method: 'GET',
                    url: '/api/products/hotels/{{ auth()->user()->hotel->id }}',
                    dataType: 'json',
                    success: function (data) {
                        data.data.forEach(function (product) {
                            var actionsHtml = `
                            <button class="btn btn-primary btn-sm edit-product" data-id="${product.id}"
                                data-toggle="modal" data-target="#productModal" style="width:100px; margin-bottom:10px">Edit</button>
                            <button class="btn btn-danger btn-sm delete-product" data-id="${product.id}" style="width:100px;">Delete</button>
                        `;
                            var row = `
                            <tr>
                                <td>${product.name}</td>
                                <td>${product.description}</td>
                                <td>${product.price}</td>
                                <td>${product.is_vegetarian ? 'Yes' : 'No'}</td>
                                <td>${product.category}</td>
                                <td><img src="${product.image}" alt="Product Image" style="max-width: 100px;"></td>
                                <td class="table-actions">${actionsHtml}</td>
                            </tr>
                        `;

                            productTableBody.append(row);
                        });
                    }
                });
            }

            // Initial fetch of products when the page loads
            fetchProducts();

            // Handle the "Add Product" button click
            var addProductBtn = $('#addProductBtn');
            addProductBtn.on('click', function () {
                // Clear the form fields in the modal for adding a new product
                var productModal = $('#productModal');
                productModal.find('.modal-title').html('Add Product');
                productModal.find('#productId').val('');
                productModal.find('#productName').val('');
                productModal.find('#productDescription').val('');
                productModal.find('#productPrice').val('');
                productModal.find('#productVegetarian').val('0');
                productModal.find('#productCategory').val('');
                productModal.find('#productImage').val('');
                productModal.find('#productSubmitBtn').html('Add Product');
            });

            // Handle the "Submit" button click for adding or editing a product
            $('#productSubmitBtn').on('click', function () {
                var productModal = $('#productModal');
                var productId = productModal.find('#productId').val();
                var productName = productModal.find('#productName').val();
                var productDescription = productModal.find('#productDescription').val();
                var productPrice = productModal.find('#productPrice').val();
                var productVegetarian = productModal.find('#productVegetarian').val();
                var productCategory = productModal.find('#productCategory').val();
                var productImage = productModal.find('#productImage').val();

                var url = '/api/products' + (productId ? '/' + productId : '');
                var method = productId ? 'PUT' : 'POST';

                var data = {
                    _token: '{{ csrf_token() }}', // Include CSRF token
                    name: productName,
                    description: productDescription,
                    price: productPrice,
                    is_vegetarian: productVegetarian,
                    category: productCategory,
                    image: productImage,
                    hotel_id: {{ auth()->user()->hotel->id }}
                };

                $.ajax({
                    method: method,
                    url: url,
                    dataType: 'json',
                    data: data,
                    success: function () {
                        // Fetch products again to refresh the table
                        fetchProducts();
                        productModal.modal('hide');
                    }
                });
            });

            // Handle the "Edit Product" button click (Delegation)
            $('#productTableBody').on('click', '.edit-product', function () {
                var productId = $(this).attr('data-id');
                $.ajax({
                    method: 'GET',
                    url: '/api/products/' + productId,
                    dataType: 'json',
                    success: function (data) {
                        var product = data.data;
                        var productModal = $('#productModal');
                        productModal.find('.modal-title').html('Edit Product');
                        productModal.find('#productId').val(product.id);
                        productModal.find('#productName').val(product.name);
                        productModal.find('#productDescription').val(product.description);
                        productModal.find('#productPrice').val(product.price);
                        productModal.find('#productVegetarian').val(product.vegetarian ? '1' : '0');
                        productModal.find('#productCategory').val(product.category);
                        productModal.find('#productImage').val(product.image);
                        productModal.find('#productSubmitBtn').html('Update Product');
                    }
                });
            });

            // Handle the "Delete Product" button click (Delegation)
            $('#productTableBody').on('click', '.delete-product', function () {
                var productId = $(this).attr('data-id');
                $.ajax({
                    method: 'DELETE',
                    url: '/api/products/' + productId,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                    },
                    success: function () {
                        fetchProducts();
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#productModal').on('hidden.bs.modal', function () {
                fetchProducts();
            });
        });
    </script>
    </script>
@endsection
