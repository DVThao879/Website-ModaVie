@extends('admin.layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{asset('theme/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('theme/admin/js/demo/datatables-demo.js')}}"></script>
@endsection

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Đơn hàng</h6>
            <div>
                <select id="filterStatus" class="form-control" onchange="filterOrders()">
                    <option value="">Tất cả ({{$statusCounts['all'] }})</option>
                    <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Chờ xác nhận ({{ $statusCounts['pending'] }})</option>
                    <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Chờ lấy hàng ({{ $statusCounts['processing'] }})</option>
                    <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Đang giao hàng ({{ $statusCounts['shipping'] }})</option>
                    <option value="4" {{ request('status') == 4 ? 'selected' : '' }}>Giao hàng thành công ({{ $statusCounts['completed'] }})</option>
                    <option value="5" {{ request('status') == 5 ? 'selected' : '' }}>Chờ hủy ({{ $statusCounts['pending_cancel'] }})</option>
                    <option value="6" {{ request('status') == 6 ? 'selected' : '' }}>Đã hủy ({{ $statusCounts['canceled'] }})</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" data-disable-sort="true">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($data as $key => $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $item->order_code }}</td>
                                <td>
                                    @if ($item->user_id)
                                        {{ $item->user->name }}
                                    @elseif($item->user_id == null && $item->is_guest == 0)
                                        Khách vãng lai
                                    @elseif($item->user_id == null && $item->is_guest == 1)
                                        Tài khoản bị xóa
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}</td>
                                <td>{{ number_format($item->total, 0, ',', '.') }} VND</td>
                                <td>
                                    @if ($item->status == 1)
                                        <span class="badge badge-warning">Chờ xác nhận</span>
                                    @elseif($item->status == 2)
                                        <span class="badge badge-info">Chờ lấy hàng</span>
                                    @elseif($item->status == 3)
                                        <span class="badge badge-primary">Đang giao hàng</span>
                                    @elseif($item->status == 4)
                                        <span class="badge badge-success">Giao hàng thành công</span>
                                    @elseif($item->status == 5)
                                        <span class="badge badge-secondary">Chờ hủy</span>
                                    @elseif($item->status == 6)
                                        <span class="badge badge-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary mr-2" href="{{ route('admin.bill.detail', $item) }}" title="Xem chi tiết">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if ($item->status != 6)        
                                        @if($item->status == 1)
                                            <a class="btn btn-success" href="{{ route('admin.bill.confirmBill', $item->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn xác nhận đơn hàng này không?');" title="Chờ lấy hàng">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @elseif($item->status == 2)
                                            <a class="btn btn-info" href="{{ route('admin.bill.shipBill', $item->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn giao đơn hàng này không?');" title="Đang giao hàng">
                                                <i class="fa fa-truck"></i>
                                            </a>
                                        @elseif($item->status == 3)
                                            <a class="btn btn-success" href="{{ route('admin.bill.confirmShipping', $item->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn đơn hàng này đã được giao không?');" title="Giao hàng thành công">
                                                <i class="fa fa-check-circle-o"></i>
                                            </a>
                                        @elseif($item->status == 5)
                                            <a class="btn btn-danger" href="{{ route('admin.bill.cancelBill', $item->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');" title="Đã hủy">
                                                <i class="fa fa-times-circle"></i>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@section('script')
<script>
    function filterOrders() {
    const status = document.getElementById('filterStatus').value;
    const url = new URL(window.location.href);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location.href = url.href;
    }
</script>
@endsection