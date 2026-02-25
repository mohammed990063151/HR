
@extends('layouts.master')
@section('content')
    {{-- message --}}
    
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">تقرير الفواتير</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">تقرير الفواتير</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <!-- Search Filter -->
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3"> 
                    <div class="form-group form-focus select-focus">
                        <select class="select floating"> 
                            <option>حدد العميل</option>
                            <option>محمد علي</option>
                            <option>محمد مصطفى</option>
                        </select>
                        <label class="focus-label">العميل</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">  
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">من</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">  
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">الى</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">  
                    <a href="#" class="btn btn-success btn-block"> بحث </a>  
                </div>     
            </div>
            <!-- /Search Filter -->
            
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الفاتورة</th>
                                    <th>العميل</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>تاريخ الاستحقاق</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                    <th class="text-right">اجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><a href="{{ url('form/invoice/view/page') }}">#INV-0001</a></td>
                                    <td>Global Technologies</td>
                                    <td>11 Mar 2019</td>
                                    <td>17 Mar 2019</td>
                                    <td>$2099</td>
                                    <td><span class="badge bg-inverse-success">مدفوع</span></td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="edit-invoice.html"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                <a class="dropdown-item" href="invoice-view.html"><i class="fa fa-eye m-r-5"></i> عرض</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-file-pdf-o m-r-5"></i> تحميل</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><a href="{{ url('form/invoice/view/page') }}">#INV-0002</a></td>
                                    <td>Delta Infotech</td>
                                    <td>11 Mar 2019</td>
                                    <td>17 Mar 2019</td>
                                    <td>$2099</td>
                                    <td><span class="badge bg-inverse-info">مرسل</span></td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="edit-invoice.html"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                <a class="dropdown-item" href="invoice-view.html"><i class="fa fa-eye m-r-5"></i> عرض</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-file-pdf-o m-r-5"></i> تحميل</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->

@endsection
