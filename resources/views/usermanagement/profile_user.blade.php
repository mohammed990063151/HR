@extends('layouts.master')
@section('style')
<style>
/* —— تحسين صفحة الملف الشخصي (RTL + بدون تداخل) —— */
.profile-page.page-wrapper {
    padding-top: 88px;
}
@media (max-width: 768px) {
    .profile-page.page-wrapper { padding-top: 76px; }
}
.profile-page .content.container-fluid {
    max-width: min(1200px, 100%);
    margin-left: auto;
    margin-right: auto;
    padding-left: clamp(12px, 2vw, 24px);
    padding-right: clamp(12px, 2vw, 24px);
}
.profile-page .page-header {
    margin-bottom: 1.25rem;
    padding-bottom: 0;
    border-bottom: none;
}
.profile-page .page-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.35rem;
}
.profile-page .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    font-size: 0.875rem;
}
.profile-page .breadcrumb-item + .breadcrumb-item::before {
    float: right;
    padding-left: 0.5rem;
    padding-right: 0;
}

/* بطاقة الهيدر: إلغاء absolute على الصورة وإصلاح التداخل */
.profile-page .profile-view {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: 1.5rem;
    min-height: 0;
    padding: 0.25rem 0 0.5rem;
}
.profile-page .profile-view .profile-img-wrap {
    position: relative !important;
    left: auto !important;
    right: auto !important;
    top: auto !important;
    flex-shrink: 0;
    margin: 0;
    width: 112px;
    height: 112px;
    border-radius: 50%;
    background: #f1f5f9;
    border: 3px solid #e2e8f0;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08);
}
.profile-page .profile-view .profile-img,
.profile-page .profile-view .profile-img img {
    width: 106px;
    height: 106px;
    border-radius: 50%;
    object-fit: cover;
}
.profile-page .profile-view .profile-basic {
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    flex: 1 1 260px;
    min-width: 0;
}
.profile-page .profile-view .pro-edit {
    position: absolute;
    top: 0;
    inset-inline-end: 0;
}
.profile-page .profile-info-left {
    text-align: right;
}
.profile-page .profile-info-left .user-name {
    font-size: 1.35rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.3;
}
.profile-page .staff-id,
.profile-page .doj {
    font-size: 0.875rem;
    color: #64748b;
}
.profile-page .staff-msg {
    margin-top: 1rem;
}
.profile-page .staff-msg .btn-profile-msg {
    background: #4f46e5;
    border-color: #4f46e5;
    color: #fff;
    border-radius: 10px;
    padding: 0.45rem 1.1rem;
    font-weight: 600;
    font-size: 0.875rem;
}
.profile-page .staff-msg .btn-profile-msg:hover {
    background: #4338ca;
    border-color: #4338ca;
    color: #fff;
}

/* صفوف الحقول: شبكة بدل float */
.profile-page .personal-info {
    list-style: none;
    padding: 0;
    margin: 0;
}
.profile-page .personal-info li {
    display: grid;
    grid-template-columns: minmax(0, 130px) minmax(0, 1fr);
    gap: 0.75rem 1rem;
    align-items: flex-start;
    margin-bottom: 0.85rem;
    padding-bottom: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
}
.profile-page .personal-info li:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}
.profile-page .personal-info li .title {
    float: none !important;
    width: auto !important;
    margin: 0 !important;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #64748b;
    line-height: 1.4;
}
.profile-page .personal-info li .text {
    font-size: 0.9rem;
    color: #1e293b;
    text-align: right;
    word-break: break-word;
}
.profile-page .pro-overview .personal-info li .title {
    width: auto !important;
}
.profile-page .avatar-box {
    float: none;
    display: inline-flex;
    vertical-align: middle;
    margin-left: 6px;
}

/* تبويبات */
.profile-page .card.tab-box {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.profile-page .user-tabs .nav-tabs {
    border-bottom: 1px solid #e2e8f0;
    flex-wrap: wrap;
    gap: 0.25rem;
    padding: 0.5rem 0.75rem 0;
}
.profile-page .user-tabs .nav-tabs .nav-link {
    border-radius: 10px 10px 0 0;
    font-weight: 600;
    color: #64748b;
    padding: 0.65rem 1rem;
}
.profile-page .user-tabs .nav-tabs .nav-link.active {
    color: #4f46e5;
    border-color: #e2e8f0 #e2e8f0 #fff;
    background: #fff;
}
.profile-page .badge-admin-mini {
    font-size: 0.65rem;
    font-weight: 700;
    vertical-align: middle;
    margin-inline-start: 0.35rem;
}

/* بطاقات المحتوى */
.profile-page .card.profile-box {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    margin-bottom: 1rem;
}
.profile-page .card.profile-box .card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    padding-bottom: 0.75rem;
    margin-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}
.profile-page .section-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: #475569;
    margin: 1rem 0 0.5rem;
}

@media (max-width: 767px) {
    .profile-page .profile-view {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .profile-page .profile-view .profile-img-wrap {
        margin: 0 auto;
    }
    .profile-page .profile-info-left {
        text-align: center;
    }
    .profile-page .personal-info li {
        grid-template-columns: 1fr;
        text-align: right;
    }
    .profile-page .personal-info li .text {
        text-align: right;
    }
}
</style>
@endsection
@section('content')
    <div class="page-wrapper profile-page">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">الملف الشخصي</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">الملف الشخصي</li>
                        </ul>
                    </div>
                </div>
            </div>
              
            <!-- /Page Header -->
            <div class="card mb-0 border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#">
                                            <img class="user-profile" alt="" src="{{ URL::to('/assets/images/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ Session::get('name') }}</h3>
                                                <h6 class="text-muted">{{ Session::get('department') }}</h6>
                                                <small class="text-muted">{{ Session::get('position') }}</small>
                                                <div class="staff-id">معرّف المستخدم: {{ Session::get('user_id') }}</div>
                                                <div class="small doj text-muted">تاريخ الانضمام: {{ Session::get('join_date') }}</div>
                                                <div class="staff-msg"><a class="btn btn-profile-msg" href="{{ route('chat') }}">أرسل رسالة</a></div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">الهاتف:</div>
                                                    <div class="text"><a href="">{{ Session::get('phone_number') }}</a></div>
                                                </li>
                                                <li>
                                                    <div class="title">البريد الإلكتروني:</div>
                                                    <div class="text"><a href="">{{ Session::get('email') }}</a></div>
                                                </li>
                                                @if(!empty($information))
                                                    <li>
                                                        @if(Auth::user()->user_id == $information->user_id)
                                                            <div class="title">تاريخ الميلاد:</div>
                                                            <div class="text">{{date('d F, Y',strtotime($information->birth_date)) }}</div>
                                                        @else
                                                            <div class="title">تاريخ الميلاد:</div>
                                                            <div class="text">N/A</div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        @if(Auth::user()->user_id == $information->user_id)
                                                        <div class="title">العنوان:</div>
                                                        <div class="text">{{ $information->address }}</div>
                                                        @else
                                                        <div class="title">العنوان:</div>
                                                        <div class="text">N/A</div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        @if(Auth::user()->user_id == $information->user_id)
                                                        <div class="title">الجنس:</div>
                                                        <div class="text">{{ $information->gender }}</div>
                                                        @else
                                                        <div class="title">الجنس:</div>
                                                        <div class="text">N/A</div>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <div class="title">تقارير إلى:</div>
                                                        <div class="text">
                                                            <div class="avatar-box">
                                                                <div class="avatar avatar-xs">
                                                                    <img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="">
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                {{ Auth::user()->line_manager }}
                                                            </a>
                                                        </div>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <div class="title">تاريخ الميلاد:</div>
                                                        <div class="text">N/A</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">العنوان:</div>
                                                        <div class="text">N/A</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">الجنس:</div>
                                                        <div class="text">N/A</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">تقارير إلى:</div>
                                                        <div class="text">
                                                            <div class="avatar-box">
                                                                <div class="avatar avatar-xs">
                                                                    <img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="">
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                {{ Auth::user()->line_manager }}
                                                            </a>
                                                        </div>
                                                    </li>
                                                @endif    
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
					
            <div class="card tab-box mt-3">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">الملف الشخصي</a></li>
                            <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">المشاريع</a></li>
                            <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">البنك والإحصائيات <span class="badge badge-danger badge-admin-mini">للمدير</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="tab-content">
                <div id="emp_profile" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <!-- Personal Informations -->
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">المعلومات الشخصية <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">رقم جواز السفر</div>
                                            @if (!empty($userInformation->passport_no))
                                                <div class="text">{{ $userInformation->passport_no }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">تاريخ انتهاء جواز السفر</div>
                                            @if (!empty($userInformation->passport_expiry_date))
                                                <div class="text">{{ $userInformation->passport_expiry_date }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">الهاتف</div>
                                            @if (!empty($userInformation->tel))
                                                <div class="text">{{ $userInformation->tel }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">الجنسية</div>
                                            @if (!empty($userInformation->nationality))
                                                <div class="text">{{ $userInformation->nationality }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">الديانة</div>
                                            @if (!empty($userInformation->religion))
                                                <div class="text">{{ $userInformation->religion }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">الحالة الاجتماعية</div>
                                            @if (!empty($userInformation->marital_status))
                                                <div class="text">{{ $userInformation->marital_status }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">الوظيفة الزوج</div>
                                            @if (!empty($userInformation->employment_of_spouse))
                                                <div class="text">{{ $userInformation->employment_of_spouse }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">عدد الأطفال</div>
                                            @if (!empty($userInformation->children))
                                                <div class="text">{{ $userInformation->children }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Personal Informations -->
                        
                        <!-- Emergency Contact -->
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">جهة الاتصال الطارئة
                                        <a href="#" class="edit-icon" data-toggle="modal" data-target="#emergency_contact_modal">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </h3>
                                    <h5 class="section-title">الرئيسية</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">الاسم</div>
                                            @if (!empty($emergencyContact->name_primary))
                                            <div class="text">{{ $emergencyContact->name_primary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">العلاقة</div>
                                            @if (!empty($emergencyContact->relationship_primary))
                                            <div class="text">{{ $emergencyContact->relationship_primary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">الهاتف </div>
                                            @if (!empty($emergencyContact->phone_primary) && !empty($emergencyContact->phone_2_primary))
                                            <div class="text">{{ $emergencyContact->phone_primary }},{{ $emergencyContact->phone_2_primary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                    </ul>
                                    <hr>
                                    <h5 class="section-title">ثانوية</h5>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">الاسم</div>
                                            @if (!empty($emergencyContact->name_secondary))
                                            <div class="text">{{ $emergencyContact->name_secondary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">العلاقة</div>
                                            @if (!empty($emergencyContact->relationship_secondary))
                                            <div class="text">{{ $emergencyContact->relationship_secondary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">الهاتف </div>
                                            @if (!empty($emergencyContact->phone_secondary) && !empty($emergencyContact->phone_2_secondary))
                                            <div class="text">{{ $emergencyContact->phone_secondary }},{{ $emergencyContact->phone_2_secondary }}</div>
                                            @else
                                            <div class="text">N/A</div>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Emergency Contact -->
                    </div>

                    <div class="row">
                        <!-- Bank information -->
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">معلومات البنك
                                        <a href="#" class="edit-icon" data-toggle="modal" data-target="#bank_information_modal">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">اسم البنك</div>
                                            @if(!empty($bankInformation->bank_name))
                                                <div class="text">{{ $bankInformation->bank_name }}</div>
                                            @else  
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">رقم الحساب البنكي</div>
                                            @if(!empty($bankInformation->bank_account_no))
                                                <div class="text">{{ $bankInformation->bank_account_no }}</div>
                                            @else  
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">IFSC Code</div>
                                            @if(!empty($bankInformation->ifsc_code))
                                                <div class="text">{{ $bankInformation->ifsc_code }}</div>
                                            @else  
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">PAN No</div>
                                            @if(!empty($bankInformation->pan_no))
                                                <div class="text">{{ $bankInformation->pan_no }}</div>
                                            @else  
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /Bank information -->

                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">معلومات عائلية </h3> <a href="#" class="edit-icon" data-toggle="modal" data-target="#family_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>الاسم</th>
                                                    <th>العلاقة</th>
                                                    <th>تاريخ الميلاد</th>
                                                    <th>الهاتف</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Leo</td>
                                                    <td>Brother</td>
                                                    <td>Feb 16th, 2019</td>
                                                    <td>9876543210</td>
                                                    <td class="text-right">
                                                        <div class="dropdown dropdown-action">
                                                            <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                                <a href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
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

                    </div>
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">معلومات التعليم <a href="#" class="edit-icon" data-toggle="modal" data-target="#education_info"><i class="fa fa-pencil"></i></a></h3>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">الكلية الدولية للفنون والعلوم (المرحلة الجامعية)
                                                        </a>
                                                        <div>
                                                            بكالوريوس علوم الكمبيوتر
                                                        </div>
                                                        <span class="time">2000 - 2003</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">الكلية الدولية للفنون والعلوم (المرحلة الجامعية)</a>
                                                        <div>ماجستير علوم الكمبيوتر</div>
                                                        <span class="time">2000 - 2003</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">الخبرة <a href="#" class="edit-icon" data-toggle="modal" data-target="#experience_info"><i class="fa fa-pencil"></i></a></h3>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">مصمم ويب في شركة زين</a>
                                                        <span class="time">يناير 2013 - الحاضر (5 سنوات 2 شهور)</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">مصمم ويب في Ron-tech</a>
                                                        <span class="time">يناير 2013 - الحاضر (5 سنوات 2 شهور)</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">مصمم ويب في Dalt Technology</a>
                                                        <span class="time">يناير 2013 - الحاضر (5 سنوات 2 شهور)</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Profile Info Tab -->
                    
                <!-- Projects Tab -->
                <div class="tab-pane fade" id="emp_projects">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                            <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="project-view.html">إدارة المكتب</a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">1</span> <span class="text-muted">المهام المفتوح , </span>
                                        <span class="text-xs">9</span> <span class="text-muted">المهام المكتملة</span>
                                    </small>
                                    <p class="text-muted">
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            موعد التسليم
                                        </div>
                                        <div class="text-muted">
                                            17 Apr 2019
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>قائد المشروع :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>الفريق :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="m-b-5">التقدم <span class="text-success float-right">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="project-view.html">إدارة المشروع</a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">2</span> <span class="text-muted">المهام المفتوحة, </span>
                                        <span class="text-xs">5</span> <span class="text-muted">المهام المكتملة</span>
                                    </small>
                                    <p class="text-muted">
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            موعد التسليم:
                                        </div>
                                        <div class="text-muted">
                                            17 Apr 2019
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>قائد المشروع :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>الفريق :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="m-b-5">التقدم <span class="text-success float-right">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                            <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="project-view.html">تطبيق المكالمات الفيديو</a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">3</span> <span class="text-muted">open tasks, </span>
                                        <span class="text-xs">3</span> <span class="text-muted">tasks completed</span>
                                    </small>
                                    <p class="text-muted">
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            موعد التسليم:
                                        </div>
                                        <div class="text-muted">
                                            17 Apr 2019
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>قائد المشروع :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>الفريق :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="m-b-5">التقدم <span class="text-success float-right">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                            <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="project-view.html">إدارة المستشفى
                                        </a></h4>
                                    <small class="block text-ellipsis m-b-15">
                                        <span class="text-xs">12</span> <span class="text-muted">المهام </span>
                                        <span class="text-xs">4</span> <span class="text-muted">المهام المكتملة</span>
                                    </small>
                                    <p class="text-muted">
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            موعد التسليم:
                                        </div>
                                        <div class="text-muted">
                                            17 Apr 2019
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>قائد المشروع :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>الفريق :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="assets/img/profiles/avatar-05.jpg"></a>
                                            </li>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="m-b-5">التقدم <span class="text-success float-right">40%</span></p>
                                    <div class="progress progress-xs mb-0">
                                        <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Projects Tab -->
                
                <!-- Bank Statutory Tab -->
                <div class="tab-pane fade" id="bank_statutory">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"> معلومات الراتب الأساسية</h3>
                            <form>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">نوع الراتب <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>
                                                    اختر نوع أساس الراتب
                                                </option>
                                                <option>ساعي</option>
                                                <option>يومي</option>
                                                <option>أسبوعي</option>
                                                <option>شهري</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">مبلغ الراتب
                                                 <small class="text-muted">الراتب الشهري</small></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Type your salary amount" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">نوع الدفع</label>
                                            <select class="select">
                                                <option>اختر نوع الدفع</option>
                                                <option>تحويل بنكي</option>
                                                <option>شيك</option>
                                                <option>نقداً</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3 class="card-title"> 
معلومات صندوق الادخار
                                </h3>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">مساهمة صندوق الادخار</label>
                                            <select class="select">
                                                <option>اختر مساهمة صندوق الادخار</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">PF No. <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>
                                                    حدد مساهمة PF
                                                </option>
                                                <option>نعم</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">
                                                معدل PF للموظفين
                                            </label>
                                            <select class="select">
                                                <option>اختر مساهمة PF للموظف</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">معدل إضافي <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>اختر معدل إضافي</option>
                                                <option>0%</option>
                                                <option>1%</option>
                                                <option>2%</option>
                                                <option>3%</option>
                                                <option>4%</option>
                                                <option>5%</option>
                                                <option>6%</option>
                                                <option>7%</option>
                                                <option>8%</option>
                                                <option>9%</option>
                                                <option>10%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">إجمالي المعدل</label>
                                            <input type="text" class="form-control" placeholder="N/A" value="11%">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">
                                                معدل PF للموظفين
                                            </label>
                                            <select class="select">
                                                <option>اختر مساهمة PF للموظف</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">معدل إضافي <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>اختر معدل إضافي</option>
                                                <option>0%</option>
                                                <option>1%</option>
                                                <option>2%</option>
                                                <option>3%</option>
                                                <option>4%</option>
                                                <option>5%</option>
                                                <option>6%</option>
                                                <option>7%</option>
                                                <option>8%</option>
                                                <option>9%</option>
                                                <option>10%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">إجمالي المعدل</label>
                                            <input type="text" class="form-control" placeholder="N/A" value="11%">
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <h3 class="card-title"> 
                                    معلومات إيسي
                                </h3>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">مساهمة إيسي</label>
                                            <select class="select">
                                                <option>اختر مساهمة إيسي</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">رقم إيسي <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>اختر رقم إيسي</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">
                                                معدل ESI للموظفين
                                            </label>
                                            <select class="select">
                                                <option>اختر معدل إيسي</option>
                                                <option>نعم</option>
                                                <option>لا</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">معدل إضافي
                                                 <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>اختر معدل إضافي</option>
                                                <option>0%</option>
                                                <option>1%</option>
                                                <option>2%</option>
                                                <option>3%</option>
                                                <option>4%</option>
                                                <option>5%</option>
                                                <option>6%</option>
                                                <option>7%</option>
                                                <option>8%</option>
                                                <option>9%</option>
                                                <option>10%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">المعدل الإجمالي</label>
                                            <input type="text" class="form-control" placeholder="N/A" value="11%">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">
                                        حفظ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Bank Statutory Tab -->
            </div>
        </div>
        <!-- /Page Content -->
        @if(!empty($information))
        <!-- Profile Modal -->
        <div id="profile_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">معلومات الملف الشخصي</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('profile/information/save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-img-wrap edit-img">
                                        <img class="inline-block" src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                        <div class="fileupload btn">
                                            <span class="btn-text">edit</span>
                                            <input class="upload" type="file" id="image" name="images">
                                            <input type="hidden" name="hidden_image" id="e_image" value="{{ Auth::user()->avatar }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->user_id }}">
                                                <input type="hidden" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    تاريخ الميلاد
                                                </label>
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker" type="text" id="birth_date" name="birth_date" value="{{ $information->birth_date }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>الجنس</label>
                                                <select class="select form-control" id="gender" name="gender">
                                                    <option value="{{ $information->gender }}" {{ ( $information->gender == $information->gender) ? 'selected' : '' }}>{{ $information->gender }} </option>
                                                    <option value="Male">ذكر</option>
                                                    <option value="Female">أنثى</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>العنوان</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ $information->address }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            الحالة
                                        </label>
                                        <input type="text" class="form-control" id="state" name="state" value="{{ $information->state }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>البلد</label>
                                        <input type="text" class="form-control" id="" name="country" value="{{ $information->country }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pin Code</label>
                                        <input type="text" class="form-control" id="pin_code" name="pin_code" value="{{ $information->pin_code }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label>رقم الهاتف</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $information->phone_number }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>قسم
                                             <span class="text-danger">*</span></label>
                                        <select class="select" id="department" name="department">
                                            <option value="{{ $information->department }}" {{ ( $information->department == $information->department) ? 'selected' : '' }}>{{ $information->department }} </option>
                                            <option value="Web Development">Web Development</option>
                                            <option value="IT Management">IT Management</option>
                                            <option value="Marketing">Marketing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <select class="select" id="" name="designation">
                                            <option value="{{ $information->designation }}" {{ ( $information->designation == $information->designation) ? 'selected' : '' }}>{{ $information->designation }} </option>
                                            <option value="Web Designer">Web Designer</option>
                                            <option value="Web Developer">Web Developer</option>
                                            <option value="Android Developer">Android Developer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تقارير إلى
                                             <span class="text-danger">*</span></label>
                                        <select class="select" id="" name="reports_to">
                                            <option value="{{ $information->reports_to }}" {{ ( $information->reports_to == $information->reports_to) ? 'selected' : '' }}>{{ $information->reports_to }} </option>
                                            @foreach ($user as $users )
                                            <option value="{{ $users->name }}">{{ $users->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Profile Modal -->
        @else
        <!-- Profile Modal -->
        <div id="profile_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">معلومات الملف الشخصي</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('profile/information/save') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-img-wrap edit-img">
                                        <img class="inline-block" src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                        <div class="fileupload btn">
                                            <span class="btn-text">edit</span>
                                            <input class="upload" type="file" id="upload" name="upload">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->user_id }}">
                                                <input type="hidden" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Birth Date</label>
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker" type="text" id="birth_date" name="birth_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="select form-control" id="gender" name="gender">
                                                    <option value="Male">
                                                        ذكر
                                                    </option>
                                                    <option value="Female">أنثى</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>العنوان</label>
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            الحالة
                                        </label>
                                        <input type="text" class="form-control" id="state" name="state">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>البلد</label>
                                        <input type="text" class="form-control" id="" name="country">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pin Code</label>
                                        <input type="text" class="form-control" id="pin_code" name="pin_code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            رقم الهاتف </label>
                                        <input type="text" class="form-control" id="phoneNumber" name="phone_number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>قسم
                                             <span class="text-danger">*</span></label>
                                        <select class="select" id="department" name="department">
                                            <option selected disabled>
                                                اختر القسم</option>
                                            <option value="Web Development">تطوير الويب</option>
                                            <option value="IT Management">إدارة تقنية المعلومات</option>
                                            <option value="Marketing">التسويق</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        
                                        <select class="select" id="" name="designation">
                                            <option selected disabled>Select Designation</option>
                                            <option value="Web Designer">Web Designer</option>
                                            <option value="Web Developer">Web Developer</option>
                                            <option value="Android Developer">Android Developer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reports To <span class="text-danger">*</span></label>
                                        <select class="select" id="" name="reports_to">
                                            <option selected disabled>-- select --</option>
                                            @foreach ($user as $users )
                                            <option value="{{ $users->name }}">{{ $users->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Profile Modal -->
        @endif

        <!-- Bank information Modal -->
        <div id="bank_information_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bank Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('bank/information/save') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="user_id" value="{{ Session::get('user_id') }}" readonly>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bank name</label>
                                        @if(!empty($bankInformation->bank_name))
                                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ $bankInformation->bank_name }}">
                                        @else 
                                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bank account No</label>
                                        @if(!empty($bankInformation->bank_account_no))
                                            <input type="text" class="form-control @error('bank_account_no') is-invalid @enderror" name="bank_account_no" value="{{ $bankInformation->bank_account_no }}">
                                        @else 
                                            <input type="text" class="form-control @error('bank_account_no') is-invalid @enderror" name="bank_account_no" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('bank_account_no') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        @if(!empty($bankInformation->ifsc_code))
                                            <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror" name="ifsc_code" value="{{ $bankInformation->ifsc_code }}">
                                        @else 
                                            <input type="text" class="form-control @error('pan_no') is-invalid @enderror" name="ifsc_code" value="{{ old('ifsc_code') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PAN No</label>
                                        @if(!empty($bankInformation->pan_no))
                                            <input type="text" class="form-control @error('pan_no') is-invalid @enderror" name="pan_no" value="{{ $bankInformation->pan_no }}">
                                        @else 
                                            <input type="text" class="form-control @error('pan_no') is-invalid @enderror" name="pan_no" value="{{ old('pan_no') }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Bank information Modal -->
    
        @if (!empty($userInformation))
        <!-- Personal Info Modal -->
        <div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Personal Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('user/information/save') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="user_id" value="{{ Session::get('user_id') }}" readonly>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Passport No</label>
                                        <input type="text" class="form-control @error('passport_no') is-invalid @enderror" name="passport_no" value="{{ $userInformation->passport_no }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Passport Expiry Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker @error('passport_expiry_date') is-invalid @enderror" type="text" name="passport_expiry_date" value="{{ $userInformation->passport_expiry_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tel</label>
                                        <input class="form-control @error('tel') is-invalid @enderror" type="text" name="tel" value="{{ $userInformation->tel }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nationality <span class="text-danger">*</span></label>
                                        <input class="form-control @error('nationality') is-invalid @enderror" type="text" name="nationality" value="{{ $userInformation->nationality }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Religion</label>
                                        <div class="form-group">
                                            <input class="form-control @error('religion') is-invalid @enderror" type="text" name="religion" value="{{ $userInformation->religion }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Marital status <span class="text-danger">*</span></label>
                                        <select class="select form-control @error('marital_status') is-invalid @enderror" name="marital_status">
                                            <option value="{{ $userInformation->marital_status }}" {{ ( $userInformation->marital_status == $userInformation->marital_status) ? 'selected' : '' }}> {{ $userInformation->marital_status }} </option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Employment of spouse</label>
                                        <input class="form-control @error('employment_of_spouse') is-invalid @enderror" type="text" name="employment_of_spouse" value="{{ $userInformation->employment_of_spouse }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. of children </label>
                                        <input class="form-control @error('children') is-invalid @enderror" type="text" name="children" value="{{ $userInformation->children }}">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Personal Info Modal -->
        @else
         <!-- Personal Info Modal -->
        <div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Personal Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="personalInfo" action="{{ route('user/information/save') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="user_id" value="{{ Session::get('user_id') }}" readonly>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Passport No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('passport_no') is-invalid @enderror" name="passport_no">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Passport Expiry Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker @error('passport_expiry_date') is-invalid @enderror" type="text" name="passport_expiry_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tel <span class="text-danger">*</span></label>
                                        <input class="form-control @error('tel') is-invalid @enderror" type="number" name="tel">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nationality <span class="text-danger">*</span></label>
                                        <input class="form-control @error('nationality') is-invalid @enderror" type="text" name="nationality">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Religion <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input class="form-control @error('religion') is-invalid @enderror" type="text" name="religion">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Marital status <span class="text-danger">*</span></label>
                                        <select class="select form-control @error('marital_status') is-invalid @enderror" name="marital_status">
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Employment of spouse <span class="text-danger">*</span></label>
                                        <input class="form-control @error('employment_of_spouse') is-invalid @enderror" type="text" name="employment_of_spouse">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. of children <span class="text-danger">*</span></label>
                                        <input class="form-control @error('children') is-invalid @enderror" type="text" name="children">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Personal Info Modal -->
        @endif
        
        <!-- Family Info Modal -->
        <div id="family_info_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Family Informations</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-scroll">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Family Member <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Relationship <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of birth <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Relationship <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of birth <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Family Info Modal -->
        
        <!-- Emergency Contact Modal -->
        <div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Personal Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="validation" action="{{ route('user/profile/emergency/contact/save') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="user_id" value="{{  Session::get('user_id') }}">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Primary Contact</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                @if (!empty($emergencyContact->name_primary))
                                                <input type="text" class="form-control" name="name_primary" value="{{ $emergencyContact->name_primary }}">
                                                @else
                                                <input type="text" class="form-control" name="name_primary">
                                                @endif
                                            </li>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                @if (!empty($emergencyContact->relationship_primary))
                                                <input type="text" class="form-control" name="relationship_primary" value="{{ $emergencyContact->relationship_primary }}">
                                                @else
                                                <input type="text" class="form-control" name="relationship_primary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                @if (!empty($emergencyContact->phone_primary))
                                                <input type="text" class="form-control" name="phone_primary" value="{{ $emergencyContact->phone_primary }}">
                                                @else
                                                <input type="text" class="form-control" name="phone_primary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone 2</label>
                                                @if (!empty($emergencyContact->phone_2_primary))
                                                <input type="text" class="form-control" name="phone_2_primary" value="{{ $emergencyContact->phone_2_primary }}">
                                                @else
                                                <input type="text" class="form-control" name="phone_2_primary">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Secondary Contact</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                @if (!empty($emergencyContact->name_secondary))
                                                <input type="text" class="form-control" name="name_secondary" value="{{ $emergencyContact->name_secondary }}">
                                                @else
                                                <input type="text" class="form-control" name="name_secondary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                @if (!empty($emergencyContact->relationship_secondary))
                                                <input type="text" class="form-control" name="relationship_secondary" value="{{ $emergencyContact->relationship_secondary }}">
                                                @else
                                                <input type="text" class="form-control" name="relationship_secondary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                @if (!empty($emergencyContact->phone_secondary))
                                                <input type="text" class="form-control" name="phone_secondary" value="{{ $emergencyContact->phone_secondary }}">
                                                @else
                                                <input type="text" class="form-control" name="phone_secondary">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone 2</label>
                                                @if (!empty($emergencyContact->phone_2_secondary))
                                                <input type="text" class="form-control" name="phone_2_secondary" value="{{ $emergencyContact->phone_2_secondary }}">
                                                @else
                                                <input type="text" class="form-control" name="phone_2_secondary">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Emergency Contact Modal -->
        
        <!-- Education Modal -->
        <div id="education_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Education Informations</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-scroll">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Oxford University" class="form-control floating">
                                                    <label class="focus-label">Institution</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Computer Science" class="form-control floating">
                                                    <label class="focus-label">Subject</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="text" value="01/06/2002" class="form-control floating datetimepicker">
                                                    </div>
                                                    <label class="focus-label">Starting Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="text" value="31/05/2006" class="form-control floating datetimepicker">
                                                    </div>
                                                    <label class="focus-label">Complete Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="BE Computer Science" class="form-control floating">
                                                    <label class="focus-label">Degree</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Grade A" class="form-control floating">
                                                    <label class="focus-label">Grade</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Oxford University" class="form-control floating">
                                                    <label class="focus-label">Institution</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Computer Science" class="form-control floating">
                                                    <label class="focus-label">Subject</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="text" value="01/06/2002" class="form-control floating datetimepicker">
                                                    </div>
                                                    <label class="focus-label">Starting Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <div class="cal-icon">
                                                        <input type="text" value="31/05/2006" class="form-control floating datetimepicker">
                                                    </div>
                                                    <label class="focus-label">Complete Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="BE Computer Science" class="form-control floating">
                                                    <label class="focus-label">Degree</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus focused">
                                                    <input type="text" value="Grade A" class="form-control floating">
                                                    <label class="focus-label">Grade</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Education Modal -->
        
        <!-- Experience Modal -->
        <div id="experience_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Experience Informations</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-scroll">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="Digital Devlopment Inc">
                                                    <label class="focus-label">Company Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="United States">
                                                    <label class="focus-label">Location</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="Web Developer">
                                                    <label class="focus-label">Job Position</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <div class="cal-icon">
                                                        <input type="text" class="form-control floating datetimepicker" value="01/07/2007">
                                                    </div>
                                                    <label class="focus-label">Period From</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <div class="cal-icon">
                                                        <input type="text" class="form-control floating datetimepicker" value="08/06/2018">
                                                    </div>
                                                    <label class="focus-label">Period To</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="Digital Devlopment Inc">
                                                    <label class="focus-label">Company Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="United States">
                                                    <label class="focus-label">Location</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <input type="text" class="form-control floating" value="Web Developer">
                                                    <label class="focus-label">Job Position</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <div class="cal-icon">
                                                        <input type="text" class="form-control floating datetimepicker" value="01/07/2007">
                                                    </div>
                                                    <label class="focus-label">Period From</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <div class="cal-icon">
                                                        <input type="text" class="form-control floating datetimepicker" value="08/06/2018">
                                                    </div>
                                                    <label class="focus-label">Period To</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-more">
                                            <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Experience Modal -->

    <!-- /Page Content -->
    </div>
    @section('script')
        <!-- Personal Info -->
        <script>
            $('#personalInfo').validate({  
                rules: {  
                    passport_no: 'required',  
                    passport_expiry_date: 'required',  
                    tel: 'required',  
                    nationality: 'required',  
                    religion: 'required',  
                    marital_status: 'required',  
                    employment_of_spouse: 'required',  
                    children: 'required',  
                },  
                messages: {
                    passport_no: 'Please Input Passport No',    
                    passport_expiry_date: 'Please Input Passport Expiry Date',    
                    tel: 'Please Input Phone Number',     
                    nationality: 'Please Input Nationality',    
                    religion: 'Please Input Religion',    
                    marital_status: 'Please Input Marital status',    
                    employment_of_spouse: 'Please Input Employment of spouse',    
                    children: 'Please Input No. of children',    
                },  
                submitHandler: function(form) {  
                    form.submit();
                }  
            });  
        </script>

        <!-- Emergency Contact -->
        <script>
            $('#validation').validate({  
                rules: {  
                    name_primary: 'required',  
                    relationship_primary: 'required',  
                    phone_primary: 'required',  
                    phone_2_primary: 'required',  
                    name_secondary: 'required',  
                    relationship_secondary: 'required',  
                    phone_secondary: 'required',  
                    phone_2_secondary: 'required',  
                },  
                messages: {
                    name_primary: 'Please input name primary',  
                    relationship_primary: 'Please input relationship primary',  
                    phone_primary: 'Please input phone primary',  
                    phone_2_primary: 'Please input phone 2 primary',  
                    name_secondary: 'Please input name secondary',  
                    relationship_secondary: 'Please input relationship secondary',  
                    phone_secondaryr: 'Please input phone secondary',  
                    phone_2_secondary: 'Please input phone 2 secondary',  
                },  
                submitHandler: function(form) {  
                    form.submit();
                }  
            });  
        </script>
        
    @endsection
@endsection