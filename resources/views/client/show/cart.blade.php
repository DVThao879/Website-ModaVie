@extends('client.layouts.app')

@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url(assets/images/bg/breadcrumb.jpg);">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>cart page</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">cart </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-95 pb-100">
        <div class="container">
            <h3 class="cart-page-title">Giỏ hàng của tôi</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                  <form action="#">
                    <div class="table-content table-responsive cart-table-content">
                        {{-- @if ($cart && count($cart) > 0) --}}
                            <table>
                                <thead>
                                    <tr>
                                        <th>Ảnh</th>
                                        <th>Sản Phẩm</th>
                                        <th>Màu,Size</th>
                                        <th>Giá</th>
                                        <th>Số Lượng</th>
                                        <th>Tổng Tiền</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach ($cart as $key => $item)
                                        <tr data-key="{{ $key }}">
                                            <td class="product-thumbnail">
                                                <a href="#"><img style="width: 50px" src="{{ Storage::url($item['image']) }}" alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="#">{{ $item['name'] }}</a></td>
                                            <td class="">{{ $item['color'] }},{{ $item['size'] }}</td>
                                            <td class="product-price-cart">
                                                <span class="amount">{{ number_format($item['price_sale'], 0, ',', '.') }} VND</span>
                                            </td>
                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="dec qtybutton">-</div>
                                                    <input class="cart-plus-minus-box quantity-input" type="number"
                                                        name="qtybutton" value="{{ $item['quantity'] }}" data-key="{{ $key }}" min="1">
                                                    <div class="inc qtybutton">+</div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                {{ number_format($item['price_sale'] * $item['quantity'], 0, ',', '.') }} VND
                                            </td>
                                            <td class="product-remove">
                                                <a href="#" class="remove-item" data-key="{{ $key }}"><i class="la la-close"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    <tr>
                                        <td colspan="6" style="text-align: right; padding: 20px; font-weight: bold; background-color: #f8f9fa; border-top: 2px solid #ddd;">
                                            Tổng Tiền:
                                        </td>
                                        <td style="padding: 20px; font-weight: bold; background-color: #f8f9fa; border-top: 2px solid #ddd;">
                                            <span id="total-amount">{{ number_format($totalAmount, 0, ',', '.') }} VND</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        {{-- @else
                            <p>Giỏ hàng của bạn hiện tại trống.</p>
                        @endif --}}
                    </div>
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="#">Tiếp Tục Mua Hàng</a>
                                </div>
                                <div class="cart-clear">
                                    @if ($cart && count($cart) > 0)
                                        <a href="{{ route('user.checkout') }}">Thanh Toán</a>
                                        @endif
                                          
                                       
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
                

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                      $(document).ready(function() {
                          // Tăng số lượng
                          $('.inc').off('click').on('click', function() { 
                              var $input = $(this).siblings('.quantity-input');
                              var currentValue = parseInt($input.val(), 10); 
                              if (!isNaN(currentValue)) {
                                  var newValue = currentValue + 1; 
                                  $input.val(newValue); 
                      
                                  
                                  updateCart($input.data('key'), newValue);
                              }
                          });
                      
                          // Giảm số lượng
                          $('.dec').off('click').on('click', function() { // off để xóa sự kiện cũ, tránh gán nhiều lần
                              var $input = $(this).siblings('.quantity-input');
                              var currentValue = parseInt($input.val(), 10); // Parse the current value as an integer
                              if (!isNaN(currentValue) && currentValue > 1) { // Ensure value is greater than 1
                                  var newValue = currentValue - 1; // Decrease by 1
                                  $input.val(newValue); // Update the input field value
                      
                                  // Gọi AJAX để cập nhật số lượng
                                  updateCart($input.data('key'), newValue);
                              }
                          });
                      
                          // Khi số lượng được thay đổi thủ công (người dùng tự nhập số lượng)
                          $('.quantity-input').on('change', function() {
                              var key = $(this).data('key');
                              var newQuantity = parseInt($(this).val(), 10);
                              if (!isNaN(newQuantity) && newQuantity > 0) {
                                  // Gọi AJAX để cập nhật số lượng
                                  updateCart(key, newQuantity);
                              }
                          });
                      
                          // Hàm AJAX để cập nhật giỏ hàng
                          function updateCart(key, quantity) {
                              $.ajax({
                                  url: '{{ route('user.cart.update') }}',
                                  method: 'POST',
                                  data: {
                                      _token: '{{ csrf_token() }}',
                                      key: key,
                                      quantity: quantity
                                  },
                                  success: function(response) {
                                      if (response.success) {
                                          // Cập nhật lại tổng tiền cho sản phẩm
                                          $('tr[data-key="' + key + '"] .product-subtotal').text(response.subtotal + ' VND');
                                          
                                          // Cập nhật tổng tiền của giỏ hàng
                                          $('#total-amount').text(response.total + ' VND');
                                      }
                                  }
                              });
                          }
                      
                          // Xóa sản phẩm khỏi giỏ hàng
                          $('.remove-item').on('click', function(e) {
                              e.preventDefault();
                              var key = $(this).data('key');
                      
                              $.ajax({
                                  url: '{{ route('user.cart.remove') }}',
                                  method: 'POST',
                                  data: {
                                      _token: '{{ csrf_token() }}',
                                      key: key
                                  },
                                  success: function(response) {
                                      if (response.success) {
                                          // Xóa dòng sản phẩm khỏi bảng
                                          $('tr[data-key="' + key + '"]').remove();
                      
                                          // Cập nhật tổng tiền của giỏ hàng
                                          $('#total-amount').text(response.total + ' VND');
                                      }
                                  }
                              });
                          });
                      });
                      </script>
                      
                      
                      
                  
                  

                </div>
            </div>
        </div>
    </div>
@endsection
