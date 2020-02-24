
@extends('back_end.home')

@section('content')

@push('css')
    <link href="{{ asset('/backEndStyle') }}/assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
@endpush
<div class="container  p-5 ">

    
     <form class="form-horizontal" action="{{ url('admin/add-member') }}" method="Post" enctype="multipart/form-data">@csrf
       

            <div class="card-body">
                <h4 class="card-title">Add Member</h4>
                <div class="form-group row">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label {{$errors->has('username')?' text-danger ' : ''}}  ">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control {{$errors->has('username')?' is-invalid ' : ''}} " name="username" id="username" placeholder="Username Here">
                        <div class="invalid-feedback">{{$errors->first('username')}} </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-3 text-right control-label col-form-label {{$errors->has('name')?' text-danger ' : ''}}">name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control {{$errors->has('name')?' is-invalid ' : ''}}" name="name" id="name" placeholder=" Name Here">

                         <div class="invalid-feedback">{{$errors->first('name')}} </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-3 text-right control-label col-form-label {{$errors->has('password')?' text-danger ' : ''}}">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control {{$errors->has('password')? 'is-invalid' : ''}}" name="password" id="password" placeholder="Password Here">
                          <div class="invalid-feedback">{{$errors->first('password')}} </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email1" class="col-sm-3 text-right control-label col-form-label {{$errors->has('email')?' text-danger ' : ''}}">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control {{$errors->has('email')? 'is-invalid' : ''}}" name="email" id="email1" placeholder="Email Here">
                         <div class="invalid-feedback">{{$errors->first('email')}} </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="col-sm-3 text-right control-label col-form-label {{$errors->has('website')?' text-danger ' : ''}}">Website</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control {{$errors->has('website')? 'is-invalid' : ''}}"  name="website" id="cono1" placeholder="Website Here">
                         <div class="invalid-feedback">{{$errors->first('website')}} </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="col-sm-3 text-right control-label col-form-label {{$errors->has('subject')?' text-danger ' : ''}}">Bin</label>
                    <div class="col-sm-9">
                        <textarea class="form-control  {{$errors->has('subject')? 'is-invalid' : ''}}" name="subject" style="margin-top: 0px; margin-bottom: 0px; height: 56px;"></textarea>
                         <div class="invalid-feedback">{{$errors->first('subject')}} </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 text-right control-label col-form-label">Gender</label>
                    <div class="col-md-9">
                        <select class="select2 form-control custom-select select2-hidden-accessible" name='gender'style="width: 100%; height:36px;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="None">Choose...</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>

                          
                        </select>
                         
                    </div>
                </div>


                  <div class="form-group row">
                    <label class="col-md-3 text-right control-label col-form-label" {{$errors->has('image')?' text-danger ' : ''}}>Choose your image </label>
                    <div class="col-md-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input  {{$errors->has('image')? 'is-invalid' : ''}}" id="validatedCustomFile" required="" name="photo">
                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                    </div>
                     <div class="invalid-feedback">{{$errors->first('photo')}} </div>
                </div>

                <div class="form-group row" style="    margin-left: 27%;">
                    
                    <div class="col-md-9">
                      <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing1">
                                            <label class="custom-control-label" for="customControlAutosizing1">Checked</label>
                                        </div>
                    </div>
                </div>
              

            </div>
            <div class="border-top">
                <div class="card-body">
                    <input type="submit"  class="btn btn-primary" value="Save">

                </div>
            </div>
        </form>
</div>
@push('js')
   <script src="{{ asset('/backEndStyle') }}/assets/libs/toastr/build/toastr.min.js"></script>
<script type="text/javascript">
@if (Session::has('success'))
        toastr.success ("{{ session('success') }}", 'Successfully');
    @endif
      
</script>
@endpush

@endsection