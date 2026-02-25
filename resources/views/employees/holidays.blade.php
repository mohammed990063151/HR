
@extends('layouts.master')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">العطل <span>{{ date('Y') }}</span></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">العطل</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> إضافة عطل</a>
                    </div>
                </div>
            </div>
			<!-- /Page Header -->
              
            @php
                use Carbon\Carbon;
                $today_date = Carbon::today()->format('d-m-Y');
            @endphp
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>رقم</th>
                                    <th hidden>id</th>
                                    <th>العنوان </th>
                                    <th>تاريخ العطل</th>
                                    <th hidden></th>
                                    <th>اليوم</th>
                                    <th class="text-right">اجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($holidays as $key=>$items )
                                    @if(($today_date > $items->date_holiday))
                                        <tr class="holiday-completed">
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $items->name_holiday }}</td>
                                            <td>{{date('d F, Y',strtotime($items->date_holiday)) }}</td>
                                            <td>{{date('l',strtotime($items->date_holiday)) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($holidays as $key=>$items )
                                    @if(($today_date <= $items->date_holiday))
                                        <tr class="holiday-upcoming">
                                            <td hidden class="id">{{ $items->id }}</td>
                                            <td>{{ ++$key }}</td>
                                            <td class="holidayName">{{ $items->name_holiday }}</td>
                                            <td hidden class="holidayDate">{{$items->date_holiday }}</td>
                                            <td>{{date('d F, Y',strtotime($items->date_holiday)) }}</td>
                                            <td>{{date('l',strtotime($items->date_holiday)) }}</td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item userUpdate" data-toggle="modal" data-id="'.$items->id.'" data-target="#edit_holiday"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item deleteRecord" href="#" data-toggle="modal" data-target="#deleteRecord"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Holiday Modal -->
        <div class="modal custom-modal fade" id="add_holiday" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة عطل</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/holidays/save') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>اسم العطل <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="nameHoliday" name="nameHoliday">
                            </div>
                            <div class="form-group">
                                <label>تاريخ العطل <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="holidayDate" name="holidayDate">
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">إضافة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Holiday Modal -->

        <!-- Edit Holiday Modal -->
        <div class="modal custom-modal fade" id="edit_holiday" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل العطل</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/holidays/update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="e_id" value="">
                            <div class="form-group">
                                <label>اسم العطل <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="holidayName_edit" name="holidayName" value="">
                            </div>
                            <div class="form-group">
                                <label>تاريخ العطل <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" id="holidayDate_edit" name="holidayDate" value="">
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Holiday Modal -->

        <!-- Delete Holiday Modal -->
        <div class="modal custom-modal fade" id="deleteRecord" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>حذف قائمة التدريب</h3>
                            <p>هل أنت متأكد أنك تريد الحذف؟</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('form/holidays/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">حذف</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" data-dismiss="modal" class="btn btn-primary cancel-btn">الغاء</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Holiday Modal -->
    </div>
    <!-- /Page Wrapper -->
@section('script')
    <!-- Update -->
    <script>
        $(document).on('click','.userUpdate',function()
        {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id').text());
            $('#holidayName_edit').val(_this.find('.holidayName').text());
            $('#holidayDate_edit').val(_this.find('.holidayDate').text());  
        });
    </script>

    <!-- Delete -->
    <script>
        $(document).on('click','.deleteRecord',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>
@endsection
@endsection
