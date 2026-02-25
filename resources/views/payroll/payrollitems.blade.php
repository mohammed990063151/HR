
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
                        <h3 class="page-title">قسيمة الدفع</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">عناصر الرواتب</a></li>
                            <li class="breadcrumb-item active">عناصر الرواتب</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Tab -->
            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab_additions">الإضافات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab_overtime">العمل الإضافي</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab_deductions">الخصومات</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Tab -->
            
            <!-- Tab Content -->
            <div class="tab-content">
            
                <!-- Additions Tab -->
                <div class="tab-pane show active" id="tab_additions">
                
                    <!-- Add Addition Button -->
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_addition"><i class="fa fa-plus"></i> إضافة إضافة</button>
                    </div>
                    <!-- /Add Addition Button -->

                    <!-- Payroll Additions Table -->
                    <div class="payroll-table card">
                        <div class="table-responsive">
                            <table class="table table-hover table-radius">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الفئة</th>
                                        <th>المبلغ الافتراضي/الوحدة</th>
                                        <th class="text-right">الإجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>ترك مبلغ الرصيد</th>
                                        <td>الأجر الشهري</td>
                                        <td>$5</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_addition"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_addition"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>متأخرات الراتب</th>
                                        <td>إضافة الراتب الإضافي</td>
                                        <td>$8</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_addition"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_addition"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gratuity</th>
                                        <td>Monthly remuneration</td>
                                        <td>$20</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_addition"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_addition"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /Payroll Additions Table -->
                    
                </div>
                <!-- Additions Tab -->
                
                <!-- Overtime Tab -->
                <div class="tab-pane" id="tab_overtime">
                
                    <!-- Add Overtime Button -->
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_overtime"><i class="fa fa-plus"></i> إضافة إضافي</button>
                    </div>
                    <!-- /Add Overtime Button -->

                    <!-- Payroll Overtime Table -->
                    <div class="payroll-table card">
                        <div class="table-responsive">
                            <table class="table table-hover table-radius">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>السعر</th>
                                        <th class="text-right">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Normal day OT 1.5x</th>
                                        <td>Hourly 1.5</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_overtime"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_overtime"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Public holiday OT 3.0x</th>
                                        <td>Hourly 3</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_overtime"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_overtime"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rest day OT 2.0x</th>
                                        <td>Hourly 2</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_overtime"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_overtime"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /Payroll Overtime Table -->
                    
                </div>
                <!-- /Overtime Tab -->
                
                <!-- Deductions Tab -->
                <div class="tab-pane" id="tab_deductions">
                
                    <!-- Add Deductions Button -->
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_deduction"><i class="fa fa-plus"></i> إضافة خصم</button>
                    </div>
                    <!-- /Add Deductions Button -->

                    <!-- Payroll Deduction Table -->
                    <div class="payroll-table card">
                        <div class="table-responsive">
                            <table class="table table-hover table-radius">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>المبلغ الافتراضي/مبلغ الوحدة</th>
                                        <th class="text-right">الاجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>مبلغ الغياب</th>
                                        <td>$12</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_deduction"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_deduction"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Advance</th>
                                        <td>$7</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_deduction"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_deduction"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Unpaid leave</th>
                                        <td>$3</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_deduction"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_deduction"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /Payroll Deduction Table -->
                    
                </div>
                <!-- /Deductions Tab -->
                
            </div>
            <!-- Tab Content -->
        </div>
		<!-- /Page Content -->
				
        <!-- Add Addition Modal -->
        <div id="add_addition" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة إضافة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>الاسم <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>الفئة <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>حدد فئة</option>
                                    <option>الأجر الشهري</option>
                                    <option>إضافة أخرى</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="d-block">حساب الوحدة</label>
                                <div class="status-toggle">
                                    <input type="checkbox" id="unit_calculation" class="check">
                                    <label for="unit_calculation" class="checktoggle">خانة الاختيار</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>قيمة الوحدة</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block">المُعين</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="addition_assignee" id="addition_no_emp" value="option1" checked>
                                    <label class="form-check-label" for="addition_no_emp">
                                    لا يوجد مُعين
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="addition_assignee" id="addition_all_emp" value="option2">
                                    <label class="form-check-label" for="addition_all_emp">
                                    جميع الموظفين
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="addition_assignee" id="addition_single_emp" value="option3">
                                    <label class="form-check-label" for="addition_single_emp">
                                    اختيار موظف
                                    </label>
                                </div>
                                <div class="form-group">
                                    <select class="select">
                                        <option>-</option>
                                        <option>حدد الكل</option>
                                        <option>John Doe</option>
                                        <option>Richard Miles</option>
                                    </select>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">إرسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Addition Modal -->
        
        <!-- Edit Addition Modal -->
        <div id="edit_addition" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل الإضافة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>الاسم <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>الفئة <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>اختار الفئة</option>
                                    <option>الأجر الشهري</option>
                                    <option>إضافة أخرى</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="d-block">حساب الوحدة</label>
                                <div class="status-toggle">
                                    <input type="checkbox" id="edit_unit_calculation" class="check">
                                    <label for="edit_unit_calculation" class="checktoggle">checkbox</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>قيمة الوحدة</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block">المُسنَد</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edit_addition_assignee" id="edit_addition_no_emp" value="option1" checked>
                                    <label class="form-check-label" for="edit_addition_no_emp">
                                    لا يوجد مُسنَد
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edit_addition_assignee" id="edit_addition_all_emp" value="option2">
                                    <label class="form-check-label" for="edit_addition_all_emp">
                                    جميع الموظفين
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edit_addition_assignee" id="edit_addition_single_emp" value="option3">
                                    <label class="form-check-label" for="edit_addition_single_emp">
                                    اختيار موظف
                                    </label>
                                </div>
                                <div class="form-group">
                                    <select class="select">
                                        <option>-</option>
                                        <option>اختار الجميع</option>
                                        <option>John Doe</option>
                                        <option>Richard Miles</option>
                                    </select>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Addition Modal -->
        
        <!-- Delete Addition Modal -->
        <div class="modal custom-modal fade" id="delete_addition" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>حذف إضافة</h3>
                            <p>هل أنت متأكد أنك تريد الحذف؟</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">حذف</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">إلغاء</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Addition Modal -->
				
        <!-- Add Overtime Modal -->
        <div id="add_overtime" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة إضافية</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>الاسم <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>نوع السعر <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>-</option>
                                    <option>سعر يومي</option>
                                    <option>سعر ساعة</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>السعر <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Overtime Modal -->
        
        <!-- Edit Overtime Modal -->
        <div id="edit_overtime" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل إضافية</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>الاسم <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>نوع السعر <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>-</option>
                                    <option>سعر يومي</option>
                                    <option>سعر ساعة</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>السعر <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Overtime Modal -->
        
        <!-- Delete Overtime Modal -->
        <div class="modal custom-modal fade" id="delete_overtime" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>حذف إضافية</h3>
                            <p>هل أنت متأكد أنك تريد الحذف؟</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">حذف</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">إلغاء</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Overtime Modal -->
        
        <!-- Add Deduction Modal -->
        <div id="add_deduction" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة خصم</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>الاسم <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label class="d-block">حساب الوحدة</label>
                                <div class="status-toggle">
                                    <input type="checkbox" id="unit_calculation_deduction" class="check">
                                    <label for="unit_calculation_deduction" class="checktoggle">صندوق الاختيار</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>مبلغ الوحدة</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block">المسؤول</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="deduction_assignee" id="deduction_no_emp" value="option1" checked>
                                    <label class="form-check-label" for="deduction_no_emp">
                                    لا يوجد مسؤول
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="deduction_assignee" id="deduction_all_emp" value="option2">
                                    <label class="form-check-label" for="deduction_all_emp">
                                    جميع الموظفين
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="deduction_assignee" id="deduction_single_emp" value="option3">
                                    <label class="form-check-label" for="deduction_single_emp">
                                    حدد الموظف
                                    </label>
                                </div>
                                <div class="form-group">
                                    <select class="select">
                                        <option>-</option>
                                        <option>اختر الكل</option>
                                        <option>John Doe</option>
                                        <option>Richard Miles</option>
                                    </select>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">ارسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Deduction Modal -->
				
        <!-- Edit Deduction Modal -->
        <div id="edit_deduction" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل الخصم</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>الاسم <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label class="d-block">حساب الوحدة</label>
                                <div class="status-toggle">
                                    <input type="checkbox" id="edit_unit_calculation_deduction" class="check">
                                    <label for="edit_unit_calculation_deduction" class="checktoggle">checkbox</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>مبلغ الوحدة</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Assignee</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edit_deduction_assignee" id="edit_deduction_no_emp" value="option1" checked>
                                    <label class="form-check-label" for="edit_deduction_no_emp">
                                    No assignee
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edit_deduction_assignee" id="edit_deduction_all_emp" value="option2">
                                    <label class="form-check-label" for="edit_deduction_all_emp">
                                    All employees
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edit_deduction_assignee" id="edit_deduction_single_emp" value="option3">
                                    <label class="form-check-label" for="edit_deduction_single_emp">
                                    Select Employee
                                    </label>
                                </div>
                                <div class="form-group">
                                    <select class="select">
                                        <option>-</option>
                                        <option>Select All</option>
                                        <option>John Doe</option>
                                        <option>Richard Miles</option>
                                    </select>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Addition Modal -->
        
        <!-- Delete Deduction Modal -->
        <div class="modal custom-modal fade" id="delete_deduction" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Deduction</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Deduction Modal -->
    </div>
    <!-- /Page Content -->

@endsection
