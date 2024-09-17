@extends('admin.layouts.master')

@section('title')
    Danh sách sản phẩm
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
    <a href="{{route('admin.products.create')}}" class="mb-3">
        <button class="btn btn-primary">Tạo mới</button>
    </a>
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
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Giá sale</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Ảnh</th>
                            <th>Giá min</th>
                            <th>Giá max</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($data as $key => $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <div style="width: 100px; height: 130px;">
                                        <img src="{{ Storage::url($item->img_thumb) }}" alt="Product Image" class="img-fluid" style=" width: 100%; height: 100%;">
                                    </div>
                                </td>
                                <td>{{number_format($item->price_min, 0, ",", ".")}} VNĐ</td>
                                <td>{{number_format($item->price_max, 0, ",", ".")}} VNĐ</td>
                                <td>{{$item->category->name}}</td>
                                <td>{!! $item->is_active ? '<span class="badge bg-success text-white">Hoạt động</span>' : '<span class="badge bg-danger text-white">Không hoạt động</span>' !!}</td>
                                <td class="d-flex">
                                    <a href="{{ route('admin.products.show', $item) }}" class="btn btn-primary mr-2" title="Xem chi tiết"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('admin.products.edit', $item) }}" class="btn btn-warning mr-2" title="Sửa"><i class="fa fa-edit"></i></a>
                                    {{-- <form action="{{ route('admin.products.destroy', $item) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" title="Xóa"><i class="fa fa-trash"></i></button>
                                    </form> --}}
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
                                            Bạn có muốn xóa sản phẩm "{{ $item->name }}" không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                                            <form action="{{ route('admin.products.destroy', $item) }}" method="POST">
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

