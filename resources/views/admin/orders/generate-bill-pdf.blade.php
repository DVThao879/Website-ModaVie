<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>

    <style>
        body {
            font-family: DejaVu Sans;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            margin: 0 auto;
        }

        .header {
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #333;
        }

        .info h4,
        .details h4 {
            color: #333;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        .info table,
        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .info th,
        .details th,
        .info td,
        .details td {
            border: 1px solid #e6e5e5;
            padding: 8px;
            font-size: 13px;
            text-align: left;
        }

        .info th,
        .details th {
            color: #333;
        }

        .info td,
        .details td {
            color: #333;
        }

        .summary {
            text-align: right;
            margin-top: 20px;
        }

        .summary span {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>HÓA ĐƠN</h1>
            <p><strong>Website:</strong> www.example.com</p>
            <p><strong>Email:</strong> support@example.com | <strong>Điện thoại:</strong> 0123456789</p>
            <p><strong>Ngày tạo:</strong> {{$date }}</p>
        </div>

        <div class="info">
            <h4>Thông Tin Khách Hàng</h4>
            <table>
                <tr>
                    <th>Họ và tên</th>
                    <td>{{ $bill->user_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $bill->user_email }}</td>
                </tr>
                <tr>
                    <th>Điện thoại</th>
                    <td>{{ $bill->user_phone }}</td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td>{{ $bill->user_address }}</td>
                </tr>
                <tr>
                    <th>Ngày đặt hàng</th>
                    <td>{{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>

        <div class="details">
            <h4>Chi Tiết Đơn Hàng</h4>
            <p>Mã hóa đơn: {{ $bill->order_code }}</p>
            <p>Phương thức thanh toán: {{ $bill->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Thanh toán online' }}</p>
            <p>Trạng thái: Đã thanh toán</p>
            <table>
                <thead>
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
                </thead>
                <tbody>
                @php
                    // Tính tổng tiền
                    $totalPrice = $bill->billDetails->sum(function($billDetail) {
                        return $billDetail->quantity * $billDetail->price;
                    });
                @endphp
                @foreach ($bill->billDetails as $detail)
                <tr>
                    <td>{{ $detail->product_name }}</td>
                    <td>{{ $detail->size }}</td>
                    <td>{{ $detail->color }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->price }} VND</td>
                    <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VNĐ</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5"><strong>Tổng tiền</strong></td>
                    <td>{{ number_format($totalPrice, 0, ',', '.') }} VNĐ</td>
                </tr>
                <tr>
                    <td colspan="5">Mã giảm giá:</td>
                    <td>
                        @if ($bill->voucher_id)
                            {{ $bill->voucher->code }} (-{{ $bill->voucher->discount }}%)
                        @else
                            Không có mã giảm giá
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="5"><strong>Thành Tiền</strong></td>
                    <td>{{ number_format($bill->total, 0, ',', '.') }} VNĐ</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="summary">
            <span>Cảm ơn bạn đã đặt hàng!</span>
        </div>
    </div>
</body>
</html>
