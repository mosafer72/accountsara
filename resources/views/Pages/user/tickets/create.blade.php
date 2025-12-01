@extends("Pages.layouts.master")
@section("content")
    <style>
        .profile-sidebar {
            background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
        }

        .nav-pills .nav-link {
            color: #6c757d;
            border-radius: 10px;
            padding: 12px 20px;
            margin: 4px 0;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link:hover {
            background-color: #f8f9fa;
        }

        .nav-pills .nav-link.active {
            background-color: #fff;
            color: #4158D0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
            height: 150px;
            border-radius: 15px;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border: 4px solid #fff;
            margin-top: -60px;
            background-color: #fff;
        }

        .settings-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .settings-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
            margin-left: -3.5em;
        }

        .activity-item {
            border-left: 2px solid #e9ecef;
            padding-left: 20px;
            position: relative;
        }

        .activity-item::before {
            content: '';
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #4158D0;
            position: absolute;
            left: -7px;
            top: 5px;
        }
    </style>
    <div class="bg-dark" style="margin-top:100px">
        <div class="container py-5">
            <div class="row">
                <!-- Profile Header -->
                <div class="col-12 mb-4">
                    <div class="profile-header position-relative mb-4">
                        <div class="position-absolute top-0 end-0 p-3">
                            <button class="btn btn-light"><i class="fas fa-edit me-2"></i></button>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <img src="https://randomuser.me/api/portraits/men/40.jpg" class="rounded-circle profile-pic"
                                alt="Profile Picture">
                            <button class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h3 class="mt-3 mb-1">{{ auth()->user()->name }}</h3>
                        <p class="text-muted mb-3">Senior Product Designer</p>
                        <div class="d-flex justify-content-center gap-2 mb-4">
                            <button class="btn btn-primary"><i class="fas fa-user-plus me-2"></i>خروج از محیط
                                کاربری</button>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <!-- Sidebar -->
                                @include("Pages.user.sidebar")

                                <!-- Content Area -->
                                <div class="col-lg-9 p-5 mt-5 mb-5" style="border-right:1px solid #ccc">

                                    <div class="p-4">
                                        @if(session('success'))
                                            <div class="alert alert-success m-2 p-2">{{ session('success') }}</div>
                                        @endif
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger m-2 p-4"> {{ $error }} </div>
                                            @endforeach
                                        @endif
                                        <div class="mt-10 bg-secondary text-white p-3 rounded">ایجاد تیکت</div>
                                        <form method="post" action="{{ route("profile.tickets.store") }}" class="mt-10">
                                            @csrf
                                            <input type="hidden" value="<?= (!isset($parent))  ? 0 : $parent->id ?>" name="parent">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">عنوان تیکت</label>
                                                <input type="text" name="title" class="form-control" id="exampleFormControlInput1"
                                                    placeholder="عنوان تیکت را وارد کنید">
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="exampleFormControlTextarea1">متن تیکت خود را وارد کنید</label>
                                                <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                                                    rows="3"></textarea>
                                            </div>
                                              <button type="submit" class="btn btn-primary mt-4 px-20">ثبت</button>
                                        </form>
                                         <fieldset disabled>
                                            @if (isset($parent))
                                                <div class="mt-2 bg-primary p-3 rounded-4 text-white" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1">عنوان تیکت</label>
                                                        <input type="disable" name="" class="form-control" id="exampleFormControlInput1"
                                                            placeholder="عنوان تیکت را وارد کنید" value="{{ $parent->subject }}" disable>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <label for="exampleFormControlTextarea1">متن تیکت خود را وارد کنید</label>
                                                        <textarea  class="form-control" id="exampleFormControlTextarea1"
                                                            rows="3" disable>{{ $parent->content }}</textarea>
                                                    </div>
                                                </div>
                                            @foreach ($answers as $answer)
                                                 <div class="mt-2 bg-primary p-3 rounded-4 text-white" >
                                                   <div style="direction:ltr">
                                                        @if ($answer->creator=="user")
                                                            <div class="bg-success p-2  rounded-4" style="width:fit-content">ایجاد شده توسط
                                                                <span class="">کاربر</span>
                                                            </div>
                                                        @else
                                                            <div class="bg-success p-2  rounded-4" style="width:fit-content">ایجاد شده توسط
                                                                <span class="">ادمین</span>
                                                            </div>
                                                        @endif
                                                   </div>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1">عنوان تیکت</label>
                                                        <input type="disable" name="" class="form-control" id="exampleFormControlInput1"
                                                            placeholder="عنوان تیکت را وارد کنید" value="{{ $parent->subject }}" disable>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <label for="exampleFormControlTextarea1">متن تیکت خود را وارد کنید</label>
                                                        <textarea  class="form-control" id="exampleFormControlTextarea1"
                                                            rows="3" disable>{{ $parent->content }}</textarea>
                                                    </div>
                                                 </div>
                                            @endforeach
                                            @endif
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
