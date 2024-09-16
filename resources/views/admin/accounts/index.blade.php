@extends('admin.layouts.master')

@section('title')
    Danh sách tài khoản
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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên tài khoản</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        <th>ID</th>
                        <th>Tên tài khoản</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{ $item->role == 0 ? 'Khách hàng' : ($item->role == 1 ? 'Nhân viên' : 'Admin') }}</td>
                                <td>
                                   {!! $item->is_active ? '<span class="badge bg-success text-white">Hoạt động</span>' : '<span class="badge bg-danger text-white">Không hoạt động</span>' !!}
                                </td>
                                <td class="d-flex">
                                    <a class="btn btn-primary mr-2" href="{{route('admin.users.show', $item)}}" title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                    @if(Auth::user()->role != 2)
                                    <a class="btn btn-warning mr-2" href="{{route('admin.users.edit', $item)}}" title="Sửa"><i class="fa fa-edit"></i></a>
                                    <form action="{{route('admin.users.destroy', $item)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" title="Xóa"><i class="fa fa-trash"></i></button>
                                    </form>
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