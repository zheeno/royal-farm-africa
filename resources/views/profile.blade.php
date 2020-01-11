@extends('layouts.investor')
@section('title')
    <title>{{ config('app.name', 'Laravel') }} | Profile</title>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 p-4">
            <h2 class="h2-responsive text">Update Profile</h2>
            @if(@session('success'))
                <div class="alert alert-success">{!! @session('success') !!}</div>
            @endif

            @if(Auth::user()->profile)
                @include('inc/userProfileInfo')
            @else
                <div class="row pt-4">
                    <div class="col-12 align-text-center">
                        <img src="{{ asset('img/afro_male_avatar.png') }}" class="img-responsive avatar-rounded" />
                        <h4 class="h4-responsive text bold">{{ Auth::user()->name }}</h4>
                        <span class="grey-text neg-mt-10">{{ Auth::user()->email }}</span>
                    </div>
                </div>
            @endif
            <div class="align-text-center">
                <a class="btn btn-sm green-btn" onClick="$('#avatarModal').modal('show')">Change Profile Photo</a>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-12 p-4">
            <form class="accordion" method="POST" action="/profile">
                @csrf                       
                <div class="profile-update-container">
                    <!-- personal details -->
                    <div class="profile-update-title" id="dropOne">
                        <h5 class="mb-0">
                            <a href="javascript:void(0)" class="" data-toggle="collapse"
                                data-target="#personal" aria-expanded="true" aria-controls="personal">
                                Personal details
                            </a>
                        </h5>
                    </div>
                    <div id="personal" class="collapse show" aria-labelledby="dropOne" data-parent="">
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-11 mx-auto ">
                                <label for="fullname" class="">Fullname (Surname first) *</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="{{ Auth::user()->name }}" required>
                            </div>
                        </div>
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto ">
                                <label for="dateOfBirth" class="">Date of Birth *</label>
                                <input type="date" class="form-control" id="dateOfBirth" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->dob;  }?>" name="dob" required>
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="gender" class="">Gender *</label>
                                <select class="form-control" id="gender" name="gender" <?php if(Auth::user()->profile){ echo "readonly"; } ?>  required>
                                    <option value="male" <?php if(Auth::user()->profile){ if(Auth::user()->profile->gender == "male"){ echo "selected"; }  }?>>Male</option>
                                    <option value="female" <?php if(Auth::user()->profile){ if(Auth::user()->profile->gender == "female"){ echo "selected"; } }?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="email" class="">Email *</label>
                                <input type="email" class="form-control" id="email" value="{{Auth::user()->email}}" readonly required>
                            </div>
                            <div class="form-group col-md-5 mx-auto ">
                                <label for="userPhone" class="user-phone">Phone Number *</label>
                                <input type="tel" id="userPhone" class="form-control" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->phone_no;  }?>" name="phone" required>
                            </div>
                        </div>
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto ">
                                <label for="nationality" class="">Nationality *</label>
                                <input type="text" id="nationality" class="form-control" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->nationality;  }?>" name="nationality" required>
                            </div>
                            <div class="form-group col-md-5 mx-auto ">
                                <label for="occupation" class="">Occupation *</label>
                                <input type="text" class="form-control" id="occupation" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->occupation;  }?>" name="occupation" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- contact details -->
                <div class="profile-update-container">
                    <div class="profile-update-title" id="dropTwo">
                        <h5 class="mb-0">
                            <a href="javascript:void(0)" class="" data-toggle="collapse"
                                data-target="#contact" aria-expanded="true" aria-controls="contact">
                                Contact details
                            </a>
                        </h5>
                    </div>
                    <div id="contact" class="collapse " aria-labelledby="dropTwo" data-parent="">
                        <div class="single_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="occupation" class="">Address *</label>
                                <input type="text" class="form-control" id="occupation" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->address;  }?>" name="address" required>
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="country" class="">Country *</label>
                                <select class="form-control" id="country" name="country" required>
                                    @foreach($data['countries'] as $key => $country)
                                        <option value="{{ $country }}" <?php if(Auth::user()->profile){ if(Auth::user()->profile->country == $country){ echo "selected"; }  }?>>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="state" class="">State/Province/Region *</label>
                                <select class="form-control" id="statepro" name="statepro" required>
                                @foreach($data['states'] as $key => $state)
                                        <option value="{{ $state }}" <?php if(Auth::user()->profile){ if(Auth::user()->profile->state == $state){ echo "selected"; }  }?>>{{ $state }}</option>
                                    @endforeach
                                <option value="OTH" >Others</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="city" class="">City *</label>
                                <input type="text" class="form-control" id="city" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->city;  }?>" name="city" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- bank details -->
                <div class="profile-update-container">
                    <div class="profile-update-title" id="dropThree">
                        <h5 class="mb-0">
                            <a href="javascript:void(0)" class="" data-toggle="collapse" data-target="#bank"
                                aria-expanded="true" aria-controls="bank">
                                Bank details
                            </a>
                        </h5>
                    </div>
                    <div id="bank" class="collapse " aria-labelledby="dropThree" data-parent="">
                        <div class="single_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="accountName" class="">Account Name *</label>
                                <input type="text" class="form-control" id="accountName" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->account_name;  }?>" name="acctname" required>
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="accountName" class="">Account Number *</label>
                                <input type="text" class="form-control" id="accountNumber" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->account_number;  }?>" name="acctnunber" required>
                            </div>
                        </div>
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="bankName" class="">Bank Name *</label>
                                <input type="text" class="form-control" id="bankname" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->bank_name;  }?>" name="bankname" required>
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="accountBvn" class="">Bank Verification Number</label>
                                <input type="text" class="form-control" id="accountBvn"
                                    placeholder="For Nigerian Accounts" name="bvn" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->bvn;  }?>">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- next of kin details -->
                <div class="profile-update-container">
                    <div class="profile-update-title" id="dropFour">
                        <h5 class="mb-0">
                            <a href="javascript:void(0)" class="" data-toggle="collapse"
                                data-target="#nextOfKin" aria-expanded="true" aria-controls="nextOfKin">
                                Next-of-kin details </a>
                        </h5>
                    </div>
                    <div id="nextOfKin" class="collapse " aria-labelledby="dropFour" data-parent="">
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="nextOfKinSurname" class="">Surname</label>
                                <input type="text" class="form-control" id="nextOfKinSurname" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->nok_surname;  }?>" name="nxtsname">
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="nextOfKinFirstname" class="">Firstname *</label>
                                <input type="text" class="form-control" id="nextOfKinFirstname" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->nok_firstname;  }?>" name="nxtfname" required>
                            </div>
                        </div>
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto ">
                                <label for="relationship" class="">Relationship *</label>
                                <select class="form-control" id="relationship" name="relatnsp" required>
                                    @foreach($data['rels'] as $rel)
                                    <option value="{{$rel}}" <?php if(Auth::user()->profile){ if(Auth::user()->profile->nok_relationship == $rel){ echo "selected"; }  }?>>{{$rel}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="nextOfKinEmail" class="">Email *</label>
                                <input type="email" class="form-control" id="nextOfKinEmail" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->nok_email;  }?>" name="nxtemail" required>
                            </div>
                        </div>
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="nextOfKinPhone" class="user-phone">Phone
                                    Number *</label>
                                <input type="tel" id="nextOfKinPhone" class="form-control" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->nok_phone;  }?>" name="nxtphone" required>
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="nextOfKinAddress" class="">Address *</label>
                                <input type="text" class="form-control" id="nextOfKinAddress" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->nok_address;  }?>" name="nxtaddress" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-update-container">
                    <div class="profile-update-title" id="dropFive">
                        <h5 class="mb-0">
                            <a href="javascript:void(0)" class="" data-toggle="collapse"
                                data-target="#social-media" aria-expanded="true"
                                aria-controls="social-media">
                                Social media details
                            </a>
                        </h5>
                    </div>
                    <div id="social-media" class="collapse " aria-labelledby="dropFive" data-parent="">
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="facebook" class="">Facebook</label>
                                <input type="text" class="form-control" id="facebook" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->facebook;  }?>" name="facebook">
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="twitter" class="">Twitter</label>
                                <input type="text" class="form-control" id="twitter" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->twitter;  }?>" name="twitter">
                            </div>
                        </div>
                        <div class="double_input row profile_grid">
                            <div class="form-group col-md-5 mx-auto">
                                <label for="instagram" class="">Instagram</label>
                                <input type="text" class="form-control" id="instagram" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->instagram;  }?>" name="instagram">
                            </div>
                            <div class="form-group col-md-5 mx-auto">
                                <label for="linkedin" class="">Linkedin</label>
                                <input type="text" class="form-control" id="linkedin" value="<?php if(Auth::user()->profile){ echo Auth::user()->profile->linkedin;  }?>" name="linkedin">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile_btn_container">
                    <button type="submit" class="btn green-btn">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- avatar modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content black-lighten-3">
      <div class="modal-header border-0">
        <h5 class="modal-title green-text" id="avatarModalLabel">Change Profile Photo</h5>
        <button type="button" class="close p-3" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-ic fa fa-times"></span>
        </button>
      </div>
      <div class="modal-body align-text-center">
          <div class="alert black white-text">
            <span class="fa fa-info-circle"></span>
            <span>Kindly select a photo from your device</span>
          </div>
      </div>
      <div class="modal-footer border-0">
        <form id="avatar-form" class="mx-auto" action="/changeAvatar" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="md-form">
                <input type="file" name="avatar" class="form-control white-text" accept="image/x-png,image/gif,image/jpeg" required/>
            </div>
            <button type="button" class="btn grey lighten-4" data-dismiss="modal"><span class="text">Cancel</span></button>
            <button type="submit" class="btn green-btn">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection