@extends('admin.layouts.master')

@section('title')
    Danh sách màu sắc
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
    <a href="{{route('admin.colors.create')}}" class="mb-3">
        <button class="btn btn-primary">Tạo mới</button>
    </a>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Màu sắc</h6>
            <div class="dropdown float-right">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cogs"></i> Tùy chọn
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" @if(auth()->user()->role != 2) style="pointer-events: none; opacity: 0.6;" @endif>
                        <i class="fa fa-trash text-danger"></i> Xóa các mục đã chọn
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
                        <th>Tên màu</th>
                        <th>Mã màu</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        <th></th>
                        <th>STT</th>
                        <th>Tên màu</th>
                        <th>Mã màu</th>
                        <th>Hành động</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($data as $key => $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="checkBoxItem" data-id="{{ $item->id }}">
                                </td>
                                <td>{{$key+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="rounded-circle mr-2" style="width: 20px; height: 20px; background-color: {{ $item->hex_code }};"></div>
                                        <span>{{ $item->hex_code }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-primary mr-2" href="{{route('admin.colors.show', $item)}}" title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-warning mr-2" href="{{route('admin.colors.edit', $item)}}" title="Sửa"><i class="fa fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $item->id }}" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Xóa -->
                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-bold text-dark" id="deleteModalLabel{{ $item->id }}">XÁC NHẬN XÓA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có muốn xóa màu "{{ $item->name }}" không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                                            <form action="{{ route('admin.colors.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
@endsection