@extends('admin.layouts.master')

@section('title')
    Chi tiết bình luận
@endsection

@section('style-libs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <!-- Custom styles for this page -->
    <link href="{{asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('script-libs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <!-- Page level plugins -->
    <script src="{{asset('theme/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('theme/admin/js/demo/datatables-demo.js')}}"></script>
@endsection

@section('content')
<a href="{{route('admin.comments.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<div id="alert-container" class="alert d-none mt-3" role="alert"></div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Bình luận</h6>
            <div class="dropdown float-right">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cogs"></i> Tùy chọn
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item activeAll" data-is_active="0" href="#" @if(auth()->user()->role != 2) style="pointer-events: none; opacity: 0.6;" @endif>
                        <i class="fa fa-toggle-on text-success"></i> Bật các mục đã chọn
                    </a>
                    <a class="dropdown-item activeAll" data-is_active="1" href="#" @if(auth()->user()->role != 2) style="pointer-events: none; opacity: 0.6;" @endif>
                        <i class="fa fa-toggle-off text-danger"></i> Tắt các mục đã chọn
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" data-disable-sort="false">
                    <thead>
                    <tr>
                        <th>
                            <input id="checkAllTable" type="checkbox">
                        </th>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Tên tài khoản</th>
                        <th>Nội dung</th>
                        <th>Đánh giá</th>
                        <th>Ngày bình luận</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Tên tài khoản</th>
                            <th>Nội dung</th>
                            <th>Đánh giá</th>
                            <th>Ngày bình luận</th>
                            <th>Trạng thái</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($product->comments as $key => $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="checkBoxItem" data-id="{{ $item->id }}">
                                </td>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $item->user->name ?? 'N/A' }}</td>
                                <td>{{ $item->content }}</td>
                                <td>{{ $item->rating }} sao</td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="js-switch active" data-model="{{ $item->is_active }}"
                                        {{ $item->is_active == 1 ? 'checked' : '' }} data-switchery="true"
                                        data-modelId="{{ $item->id }}" @if(Auth::user()->role != 2) disabled @endif/>
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
<script src="{{ asset('ajax/checkall.js') }}"></script>
<script src="{{ asset('ajax/changeActive/Comment/changeActiveComment.js') }}"></script>
<script src="{{ asset('ajax/changeActive/Comment/changeAllActiveComment.js') }}"></script>
@endsection