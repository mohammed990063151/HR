@extends('layouts.job')
@section('content')
    {{-- message --}}
    
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <!-- Logo -->
            <div class="header-left">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ URL::to('assets/img/enala-logo-h12.gif') }}" width="40" height="40" alt="">
                </a>
            </div>
            <!-- /Logo -->
            <!-- Header Title -->
            <div class="page-title-box float-left">
                <h3>

                    نظام إدارة الموارد البشرية
                </h3>
            </div>
            <!-- /Header Title -->
            <!-- Header Menu -->
            <ul class="nav user-menu">
                <!-- Search -->
                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="search.html">
                            <input class="form-control" type="text" placeholder="Search here">
                            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </li>
                <!-- /Search -->
                <!-- Flag -->
                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                        <img src="{{ URL::to('assets/img/flags/us.png') }}" alt="" height="20"> <span>
                            الانجليزية
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ URL::to('assets/img/flags/us.png') }}" alt="" height="16"> 
                            الانجليزية
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ URL::to('assets/img/flags/kh.png') }}" alt="" height="16"> 
                            العربية
                        </a>
                    </div>
                </li>
                <!-- /Flag -->
{{--                 
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        تسجيل الدخول
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        سجل الان
                    </a>
                </li> --}}
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            {{-- <div class="dropdown mobile-user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('login') }}">
                        تسجيل الدخول
                    </a>
                    <a class="dropdown-item" href="{{ route('register') }}">
                        سجل الان
                    </a>
                </div>
            </div> --}}
            <!-- /Mobile Menu -->

        </div>
        <!-- /Header -->

        <!-- Page Wrapper -->
        <div class="page-wrapper job-wrapper">
            <!-- Page Content -->
            <div class="content container">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">الوظائف</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                                <li class="breadcrumb-item active">الوظائف</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="job-info job-widget">
                            <h3 class="job-title">{{ $job_view[0]->job_title }}</h3>                  
                            <span class="job-dept">{{ $job_view[0]->department }}</span>
                            <ul class="job-post-det">
                                <li><i class="fa fa-calendar"></i> Post Date: <span class="text-blue">{{ date('d F, Y',strtotime($job_view[0]->start_date)) }}</span></li>
                                <li><i class="fa fa-calendar"></i> Last Date: <span class="text-blue">{{ date('d F, Y',strtotime($job_view[0]->expired_date)) }}</span></li>
                                <li><i class="fa fa-user-o"></i> Applications: <span class="text-blue">4</span></li>
                                <li><i class="fa fa-eye"></i> Views: <span class="text-blue">
                                    @if (!empty($job_view[0]->count))
                                        {{ $job_view[0]->count }}
                                        @else
                                        0
                                    @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="job-content job-widget">
                            <div class="job-desc-title"><h4>
                                وصف الوظيفة
                            </h4></div>
                            <div class="job-description">
                                <p>{!!nl2br ($job_view[0]->description) !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="job-det-info job-widget">
                            <a class="btn job-btn" href="#" data-toggle="modal" data-target="#apply_job">تقديم طلب لهذه الوظيفة</a>
                            <div class="info-list">
                                <span><i class="fa fa-bar-chart"></i></span>
                                <h5>نوع الوظيفة</h5>
                                <p>{{ $job_view[0]->job_type }}</p>
                            </div>
                            <div class="info-list">
                                <span><i class="fa fa-money"></i></span>
                                <h5>الراتب</h5>
                                <p>{{ $job_view[0]->salary_from }}$ - {{ $job_view[0]->salary_to }}$</p>
                            </div>
                            <div class="info-list">
                                <span><i class="fa fa-suitcase"></i></span>
                                <h5>الخبرة</h5>
                                <p>{{ $job_view[0]->experience }}</p>
                            </div>
                            <div class="info-list">
                                <span><i class="fa fa-ticket"></i></span>
                                <h5>عدد الوظائف الشاغرة</h5>
                                <p>{{ $job_view[0]->no_of_vacancies }}</p>
                            </div>
                            <div class="info-list">
                                <span><i class="fa fa-map-signs"></i></span>
                                <h5>الموقع</h5>
                                <p>{!!nl2br($job_view[0]->job_location) !!}</p>
                            </div>
                            <div class="info-list">
                                <p class="text-truncate"> 096-566-666
                                <br> <a href="https://enala.sa" target="_blank"title="soengsouy@example.com">
                               https://enala.sa
                                </a>
                                <br> <a href="https://enala.sa" title="https://enala.sa" target="_blank">
                                https://enala.sa
                                </a>
                                </p>
                            </div>
                            <div class="info-list text-center">
                                <a class="app-ends" href="#">
                                    <span class="text-danger">تاريخ انتهاء التقديم:</span> {{ date('d F, Y',strtotime($job_view[0]->expired_date)) }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->

            <!-- Apply Job Modal -->
            <div class="modal custom-modal fade" id="apply_job" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                تقديم طلب لهذه الوظيفة
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="apply_jobs" action="{{ route('form/apply/job/save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>
                                        الاسم الكامل
                                    </label>
                                    <input type="hidden" name="job_title" value="{{ $job_view[0]->job_title }}">
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label>
                                        رقم الهاتف
                                    </label>
                                    <input class="form-control @error('phone') is-invalid @enderror" type="tel" name="phone" value="{{ old('phone') }}">
                                </div>
                                <div class="form-group">
                                    <label>عنوان البريد الإلكتروني</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label>الرسالة</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" name="message">{{ old('message') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>
                                        تحميل السيرة الذاتية
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('cv_upload') is-invalid @enderror" id="cv_upload" name="cv_upload">
                                        <label class="custom-file-label" for="cv_upload">
                                            اختر ملف السيرة الذاتية
                                        </label>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button type="submit" class="btn btn-primary submit-btn">إرسال الطلب</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Apply Job Modal -->

        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->
    @section('script')
    <script>
        $('#apply_jobs').validate({  
            rules: {  
                name: 'required',  
                phone: 'required',
                email: 'required',    
                message: 'required',    
                cv_upload: 'required',    
            },  
            messages: {
                name: 'Please input your name',  
                phone: 'Please input your phone number',  
                email: 'Please input your email',  
                message: 'Please input your message',  
                cv_upload: 'Please upload your cv',  
            },  
            submitHandler: function(form) {  
                form.submit();
            }  
        });  
    </script>
    @endsection
@endsection
