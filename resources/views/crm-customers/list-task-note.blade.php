@extends('Layout.index')
@section('content')
    <div class="container-fluid">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Lịch ghi chú: {{$listData->total()}} kết quả</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('crm-customers.list-task-note')}}" method="get" class="d-flex">
                    <div class="col-md-3" style="margin-right: 15px">
                        <select class="form-control" name="status">
                            <option value="all">Tất cả</option>
                            <option @if(request()->get('status') == 'pending') selected @endif value="pending">Chưa thực hiện</option>
                            <option @if(request()->get('status') == 'done') selected @endif value="done">Hoàn thành</option>
                            <option @if(request()->get('status') == 'overdue') selected @endif value="overdue">Huỷ</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" style="margin-right: 15px">Tìm kiếm</button>
                    <a href="{{route('crm-customers.list-task-note')}}" style="margin-right: 15px" class="btn btn-danger">Hủy</a>
                </form>
                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Ngày ghi chú</th>
                        <th>Lịch gọi lại</th>
                        <th>Nội dung</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($listData && $listData->total() > 0)
                        @foreach($listData as $key => $note)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    <a href="{{route('crm-customers.detail-customer', ['customer_id' => $note->customer_id])}}">
                                        <span>{{optional($note->customer)->code ?? 'N/A'}}</span><br>
                                    </a>
                                    <span>{{optional($note->customer)->name ?? 'N/A'}}</span><br>
                                    <span class="text-info">{{optional($note->customer)->contact_number ?? 'N/A'}}</span><br>
                                </td>
                                <td>
                                    <span>{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y') }}</span><br>
                                    @if($note->status == 'done') <span class="text-success">Hoàn thành</span><br> @endif
                                    @if($note->status == 'overdue') <span class="text-danger">Huỷ</span><br> @endif
                                </td>
                                <td>
                                    @if($note->schedule_date) <span>{{ \Carbon\Carbon::parse($note->schedule_date)->format('d/m/Y') }}</span><br> @endif
                                    <span class="text-danger">{{$note->days_diff_text}}</span>
                                </td>
                                <td>
                                    <span>{{$note->note}}</span>
                                    @if($note->called_at)
                                        <br><span class="text-primary">Ghi chú lần 2: {{ \Carbon\Carbon::parse($note->called_at)->format('d/m/Y') }}</span><br>
                                        <span>{{$note->result_note}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($note->schedule_date && $note->status == 'pending')
                                        <div class="modal fade" id="modalUpdate{{$note->id}}" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <form action="{{route('crm-customers.update-note-item',['note_id' => $note->id])}}" method="post" class="modal-content" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title" id="myLargeModalLabel">
                                                            Cập nhật ghi chú: {{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y') }}
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-2">
                                                            <label class="form-label">Trạng thái</label>
                                                            <select name="status" class="form-control">
                                                                <option value="done">Hoàn thành</option>
                                                                <option value="overdue">Huỷ</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="form-label">Nội dung</label>
                                                            <textarea style="height: 150px" class="form-control" name="result_note" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start" data-bs-dismiss="modal">
                                                            Hủy
                                                        </button>
                                                        <button class="btn btn-primary">Xác nhận</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <button class="badge fw-medium fs-2 btn btn-rounded btn-primary" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$note->id}}">
                                            Cập nhật
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                <p class="m-0 text-center text-danger">Không có dữ liệu</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            @if($listData)
                <div class="d-flex justify-content-center">{{$listData->appends(request()->all())->links('pagination')}}</div>
            @endif
        </div>
    </div>

@endsection
