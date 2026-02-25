
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
                        <h3 class="page-title">أداء</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">أداء الموظف</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <section class="review-section information">
                <div class="review-header text-center">
                    <h3 class="review-title">المعلومات الأساسية للموظف</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-nowrap review-table mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <form>
                                                <div class="form-group">
                                                    <label for="name">الاسم </label>
                                                    <input type="text" class="form-control" id="name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="depart3">قسم</label>
                                                    <input type="text" class="form-control" id="depart3">
                                                </div>
                                                <div class="form-group">
                                                    <label for="departa">تعيين</label>
                                                    <input type="text" class="form-control" id="departa">
                                                </div>
                                                <div class="form-group">
                                                    <label for="qualif">المؤهلات: </label>
                                                    <input type="text" class="form-control" id="qualif">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form>
                                                <div class="form-group">
                                                    <label for="doj">رقم الوظيفي</label>
                                                    <input type="text" class="form-control" value="DGT-009">
                                                </div>
                                                <div class="form-group">
                                                    <label for="doj">تاريخ الانضمام</label>
                                                    <input type="text" class="form-control" id="doj">
                                                </div>
                                                <div class="form-group">
                                                    <label for="doc">تاريخ التأكيد</label>
                                                    <input type="text" class="form-control" id="doc">
                                                </div>
                                                <div class="form-group">
                                                    <label for="qualif1">سنوات الخبرة السابقة</label>
                                                    <input type="text" class="form-control" id="qualif1">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form>
                                                <div class="form-group">
                                                    <label for="name1"> اسم محمد</label>
                                                    <input type="text" class="form-control" id="name1">
                                                </div>
                                                <div class="form-group">
                                                    <label for="depart1"> RO تعين: </label>
                                                    <input type="text" class="form-control" id="depart1">
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>	 
            
            <section class="review-section professional-excellence">
                <div class="review-header text-center">
                    <h3 class="review-title">التميز المهني</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>منطقة النتائج الرئيسية</th>
                                        <th>مؤشرات الأداء الرئيسية</th>
                                        <th>الوزن</th>
                                        <th>نسبة الإنجاز <br>( تقييم الموظف )</th>
                                        <th>نقاط محققة <br>( تقييم الموظف )</th>
                                        <th>نسبة الإنجاز <br>( تقييم المشرف )</th>
                                        <th>النقاط المسجلة <br>( RO )</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="2">1</td>
                                        <td rowspan="2">الإنتاج</td>
                                        <td>الجودة</td>
                                        <td><input type="text" class="form-control" readonly value="30"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>TAT (يستدير الوقت)</td>
                                        <td><input type="text" class="form-control" readonly value="30"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>تحسين العمليات</td>
                                        <td>PMS,New Ideas</td>
                                        <td><input type="text" class="form-control" readonly value="10"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>إدارة الفريق</td>
                                        <td>إنتاجية الفريق، الديناميكيات، الحضور، معدل دوران الموظفين</td>
                                        <td><input type="text" class="form-control" readonly value="5"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>مشاركة المعرفة</td>
                                        <td>مشاركة المعرفة لزيادة إنتاجية الفريق</td>
                                        <td><input type="text" class="form-control" readonly value="5"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>التقارير والتواصل</td>
                                        <td>البريد الإلكتروني/المكالمات/التقارير والاتصالات الأخرى</td>
                                        <td><input type="text" class="form-control" readonly value="5"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">الاجمالي </td>
                                        <td><input type="text" class="form-control" readonly value="85"></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="review-section personal-excellence">
                <div class="review-header text-center">
                    <h3 class="review-title">التميز الشخصي</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>السمات الشخصية</th>
                                        <th>المؤشرات الرئيسية</th>
                                        <th>الوزن</th>
                                        <th>النسبة المحققة <br>( تقييم الموظف )</th>
                                        <th>نقاط محققة <br>( الموظف )</th>
                                        <th>النسبة المحققة <br>( تقييم المشرف )</th>
                                        <th>النقاط المسجلة <br>( RO )</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="2">1</td>
                                        <td rowspan="2">الحضور</td>
                                        <td>الإجازات المجدولة أو غير المجدولة</td>
                                        <td><input type="text" class="form-control" readonly value="2"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>الوعي بالوقت</td>
                                        <td><input type="text" class="form-control" readonly value="2"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">2</td>
                                        <td rowspan="2">السلوك وال tháiة</td>
                                        <td>التعاون في الفريق</td>
                                        <td><input type="text" class="form-control" readonly value="2"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>الاحترافية والاستجابة</td>
                                        <td><input type="text" class="form-control" readonly value="2"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>السياسات والإجراءات</td>
                                        <td>الالتزام بالسياسات والإجراءات</td>
                                        <td><input type="text" class="form-control" readonly value="2"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                    <td>4</td>
                                        <td>المبادرات</td>
                                        <td>جهود خاصة، اقتراحات، أفكار، إلخ</td>
                                        <td><input type="text" class="form-control" readonly value="2"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>تحسين المهارات المستمر</td>
                                        <td>الاستعداد للانتقال إلى المستوى التالي و استخدام التدريب</td>
                                        <td><input type="text" class="form-control" readonly value="3"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">Total </td>
                                        <td><input type="text" class="form-control" readonly value="15"></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                        <td><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center"><b>Total Percentage(%)</b></td>
                                        <td colspan="5" class="text-center"><input type="text" class="form-control" readonly value="0"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <div class="grade-span">
                                                <h4>درجة</h4>
                                                <span class="badge bg-inverse-danger">الفقراء الذين تقل أعمارهم عن 65 عامًا</span> 
                                                <span class="badge bg-inverse-warning">متوسط ​​65-74</span> 
                                                <span class="badge bg-inverse-info">75-84 مُرضٍ</span> 
                                                <span class="badge bg-inverse-purple">85-92 جيد</span> 
                                                <span class="badge bg-inverse-success">أعلى 92 ممتاز</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">مبادرات خاصة، إنجازات، مساهمات إذا وجدت</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-review review-table mb-0" id="table_achievements">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>بواسطة الموظف</th>
                                        <th>تعليق المدير المباشر</th>
                                        <th>تعليق المدير الإداري</th>
                                        <th style="width: 64px;"><button type="button" class="btn btn-primary btn-add-row"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody id="table_achievements_tbody">
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">تعليقات حول الوظيفة</h3>
                    <p class="text-muted">التعديلات إذا وُجدت مثل إضافة/حذف مسؤوليات</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-review review-table mb-0" id="table_alterations">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>بواسطة الموظف</th>
                                        <th>تعليق المدير المباشر</th>
                                        <th>تعليق المدير الإداري</th>
                                        <th style="width: 64px;"><button type="button" class="btn btn-primary btn-add-row"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody id="table_alterations_tbody">
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">تعليقات حول الوظيفة</h3>
                    <p class="text-muted">التعديلات إذا وُجدت مثل إضافة/حذف مسؤوليات</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>النقاط القوية</th>
                                        <th>المناطق المطلوب تحسينها</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">النقاط القوية والمناطق المطلوب تحسينها التي يُلاحظها المدير المباشر</h3>
                    <p class="text-muted">Lorem ipsum dollar</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>النقاط القوية</th>
                                        <th>المناطق المطلوب تحسينها</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">النقاط القوية والمناطق المطلوب تحسينها التي يُلاحظها المدير الإداري</h3>
                    <p class="text-muted">Lorem ipsum dollar</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>النقاط القوية</th>
                                        <th>المناطق المطلوب تحسينها</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">الأهداف الشخصية</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>الهدف المحقق خلال العام الماضي</th>
                                        <th>الهدف المحدد للعام الحالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">التحديثات الشخصية</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>العام الماضي</th>
                                        <th>نعم/لا</th>
                                        <th>التفاصيل</th>
                                        <th>العام الحالي</th>
                                        <th>نعم/لا</th>
                                        <th>التفاصيل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>متزوج/مخطوب؟</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>	
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td>خطط الزواج</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>الدراسات العليا / الشهادات?</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td>خطط الدراسة العليا</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>القضايا الصحية?</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td>خطط الشهادات</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Others</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td>Others</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">الهدف المهني المحقق لعام سابق</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-review review-table mb-0" id="table_goals">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>من قبل الموظف</th>
                                        <th>تعليق المدير المباشر</th>
                                        <th>تعليق المدير الإداري</th>
                                        <th style="width: 64px;"><button type="button" class="btn btn-primary btn-add-row"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody id="table_goals_tbody">
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">الهدف المهني للعام القادم</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-review review-table mb-0" id="table_forthcoming">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>من قبل الموظف</th>
                                        <th>تعليق المدير المباشر</th>
                                        <th>تعليق المدير الإداري</th>
                                        <th style="width: 64px;"><button type="button" class="btn btn-primary btn-add-row"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody id="table_forthcoming_tbody">
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">متطلبات التدريب</h3>
                    <p class="text-muted">إذا كانت هناك أي متطلبات لإنجاز أهداف معايير الأداء بشكل كامل</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-review review-table mb-0" id="table_targets">
                                <thead>
                                    <tr>
                                    <th style="width:40px;">#</th>
                                    <th>من قبل الموظف</th>
                                    <th>تعليق المدير المباشر</th>
                                    <th>تعليق المدير الإداري</th>
                                    <th style="width: 64px;"><button type="button" class="btn btn-primary btn-add-row"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody id="table_targets_tbody">
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">أي تعليقات عامة أخرى، ملاحظات، اقتراحات إلخ.</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-review review-table mb-0" id="general_comments">
                                <thead>
                                    <tr>
                                    <th style="width:40px;">#</th>
                                    <th>من قبل الموظف</th>
                                    <th>تعليق المدير المباشر</th>
                                    <th>تعليق المدير الإداري</th>
                                    <th style="width: 64px;"><button type="button" class="btn btn-primary btn-add-row"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody id="general_comments_tbody" >
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">للاستخدام فقط للمدير المباشر</h3>
                    <p class="text-muted">محمد  مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>نعم/لا</th>
                                        <th>إذا كان "نعم" - التفاصيل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>يعاني عضو الفريق من مشاكل متعلقة بالعمل</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختيار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>يعاني عضو الفريق من مشاكل تتعلق بالإجازات</td>
                                        <td>
                                        <select class="form-control select">
                                            <option>اختيار</option>
                                            <option>نعم</option>
                                            <option>لا</option>
                                        </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>يعاني عضو الفريق من مشاكل تتعلق بالاستقرار</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختيار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>العضو في الفريق يظهر سلوكاً غير داعم</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختيار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>أي ملاحظات أخرى خاصة بعضو الفريق</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختيار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                    <td>التعليق العام / أداء عضو الفريق</td>
                                        <td>
                                            <select class="form-control select">
                                                <option>اختيار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="review-section">
                <div class="review-header text-center">
                    <h3 class="review-title">للاستخدام من قبل قسم الموارد البشرية فقط</h3>
                    <p class="text-muted">محمد مصطفى</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th>المعايير العامة</th>
                                        <th>النقاط المتاحة</th>
                                        <th>النقاط المحققة</th>
                                        <th>تعليق المشرف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>نقاط تحقيق أهداف مؤشرات الأداء الرئيسية (سيتم احتسابها من الدرجة الإجمالية المحددة في هذه الوثيقة من قبل المسؤول عن التقرير)</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>نقاط المهارات المهنية (سيتم احتساب النقاط المقدمة من قبل المسؤول عن التقييم في ورقة تقييم المهارات والسلوك)</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                        <td>نقاط المهارات الشخصية (سيتم احتساب النقاط المقدمة من قبل المسؤول عن التقييم في ورقة تقييم المهارات والسلوك)</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                       <td>نقاط الإنجازات الخاصة (يُرجى من رئيس القسم تقديمها)</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                    <tr>
                                    <td>النتيجة الإجمالية</td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                        <td><input type="text" class="form-control" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered review-table mb-0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>الاسم</th>
                                    <th>التوقيع</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>موظف</td>
                                    <td><input type="text" class="form-control" ></td>
                                    <td><input type="text" class="form-control" ></td>
                                    <td><input type="text" class="form-control" ></td>
                                </tr>
                                <tr>
                                    <td>موظف التقارير</td>
                                    <td><input type="text" class="form-control" ></td>
                                    <td><input type="text" class="form-control" ></td>
                                    <td><input type="text" class="form-control" ></td>
                                </tr>
                                <tr>
                                    <td>رئيس القسم</td>
                                    <td><input type="text" class="form-control" ></td>
                                    <td><input type="text" class="form-control" ></td>
                                    <td><input type="text" class="form-control" ></td>
                                </tr>
                                <tr>
                                    <td>تنمية الموارد البشرية</td>
                                    <td><input type="text" class="form-control" ></td>
                                    <td><input type="text" class="form-control" ></td>
                                    <td><input type="text" class="form-control" ></td>
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
    @section('script')
    <!-- Add Table Row JS -->
    <script>
        $(function () {
            $(document).on("click", '.btn-add-row', function () {
                var id = $(this).closest("table.table-review").attr('id');  // Id of particular table
                console.log(id);
                var div = $("<tr />");
                div.html(GetDynamicTextBox(id));
                $("#"+id+"_tbody").append(div);
            });
            $(document).on("click", "#comments_remove", function () {
                $(this).closest("tr").prev().find('td:last-child').html('<button type="button" class="btn btn-danger" id="comments_remove"><i class="fa fa-trash-o"></i></button>');
                $(this).closest("tr").remove();
            });
            function GetDynamicTextBox(table_id) {
                $('#comments_remove').remove();
                var rowsLength = document.getElementById(table_id).getElementsByTagName("tbody")[0].getElementsByTagName("tr").length+1;
                return '<td>'+rowsLength+'</td>' + '<td><input type="text" name = "DynamicTextBox" class="form-control" value = "" ></td>' + '<td><input type="text" name = "DynamicTextBox" class="form-control" value = "" ></td>' + '<td><input type="text" name = "DynamicTextBox" class="form-control" value = "" ></td>' + '<td><button type="button" class="btn btn-danger" id="comments_remove"><i class="fa fa-trash-o"></i></button></td>'
            }
        });
    </script>
    @endsection
@endsection
