@extends('layout.master');
@section('title', 'Patient - Add')
@section('breadcrumb-module', 'Patient')
@section('page-content')
<!--begin::Row-->
<div class="row">
    <div class="col-lg-12 col-xxl-12">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">Add</h3>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" enctype="multipart/form-data" action="{{ route('referred-doctor.store') }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body pt-4">
                                        <h4>Patient Details</h4>
                                        <hr class="mt-1 mb-4">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Patient Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Patient Name" name="pa_name" id="pa_name" />
                                                    <span class="text-danger" id="pa_nameErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Contact No <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="tel" class="form-control" placeholder="Contact No" name="pa_contact_no" id="pa_contact_no" />
                                                    </div>
                                                    <span class="text-danger" id="pa_contact_noErr"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" id="pa_country_code" name="pa_country_code" value="">
                                            <input type="hidden" id="pa_dial_code" name="pa_dial_code" value="">
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Alternate Contact No <span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control" placeholder="Alternate Contact No" name="pa_alt_contact_no" id="pa_alt_contact_no" />
                                                    <span class="text-danger" id="pa_alt_contact_noErr"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" id="pa_alt_country_code" name="pa_alt_country_code" value="">
                                            <input type="hidden" id="pa_alt_dial_code" name="pa_alt_dial_code" value="">
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" placeholder="Email" name="pa_email" id="pa_email" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Pan Card</label>
                                                    <input type="text" class="form-control" placeholder="Pan Card" name="pa_pan_card" id="pa_pan_card" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>DOB</label>
                                                    <input type="date" class="form-control" placeholder="DOB" name="pa_dob" id="pa_dob" max="{{ date('Y-m-d') }}" onchange="changeDOB(this.value)" />
                                                    <span class="text-danger" id="pa_dobErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Age <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Age" name="pa_age" id="pa_age" />
                                                    <span class="text-danger" id="pa_ageErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select name="pa_gender" id="pa_gender" class="form-control">
                                                        <option value="">-select-</option>
                                                        <option value="male">Male</option>
                                                        <option value="female" selected>Female</option>
                                                    </select>
                                                </div>
                                            </div>



                                        </div>
                                        <h4>Address</h4>
                                        <hr class="mt-1 mb-4">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Address" name="pa_address" id="pa_address" />
                                                    <span class="text-danger" id="pa_addressErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select name="pa_country" id="pa_country" class="form-control">
                                                        <option value="">-Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>State <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="State" name="pa_state" id="pa_state" />
                                                    <span class="text-danger" id="pa_stateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>City <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="City" name="pa_city" id="pa_city" />
                                                    <span class="text-danger" id="pa_cityErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Pin Code <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Pin Code" name="pa_pincode" id="pa_pincode" />
                                                    <span class="text-danger" id="pa_pincodeErr"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <h4>Other Details</h4>
                                        <hr class="mt-1 mb-4">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Marital Status</label>
                                                    <select name="pa_marital_status" id="pa_marital_status" class="form-control">
                                                        <option value="">-select-</option>
                                                        <option value="married">Married</option>
                                                        <option value="single">Single</option>
                                                        <option value="divorced">Divorced</option>
                                                        <option value="widow">Widow</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Occupation</label>
                                                    <input type="text" class="form-control" placeholder="Occupation" name="pa_occupation" id="pa_occupation" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Photo</label>
                                                    <input type="file" class="form-control" placeholder="Photo" name="pa_photo" id="pa_photo" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Referred By</label>
                                                    <select name="pa_referred_by" id="pa_referred_by" class="form-control" onchange="changeReferrer(this.value)">
                                                        <option value="">-Select</option>
                                                        <option value="doctor">Doctor</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 d-none" id="pa_referred_doctor_box">
                                                <div class="form-group search_bar">
                                                    <label>Referred Doctor</label>
                                                    <input type="text" id="pa_referred_doctor" name="pa_referred_doctor" placeholder="Referred Doctor" class="form-control" onkeyup="searchReferredDoctor(this.value)" />
                                                    <ul id="search_doctor_list" class="d-none"></ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 d-none" id="pa_referred_text_box">
                                                <div class="form-group">
                                                    <label>Referred Name</label>
                                                    <input type="text" name="pa_referred_text" id="pa_referred_text" placeholder="Referred Name" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-2" id="createBtn">Add</button>
                                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Patient Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Patient Name" name="pa_name" id="pa_name" />
                                                    <span class="text-danger" id="pa_nameErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Contact No <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="tel" class="form-control" placeholder="Contact No" name="pa_contact_no" id="pa_contact_no" />
                                                    </div>
                                                    <span class="text-danger" id="pa_contact_noErr"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" id="pa_country_code" name="pa_country_code" value="">
                                            <input type="hidden" id="pa_dial_code" name="pa_dial_code" value="">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Alternate Contact No <span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control" placeholder="Alternate Contact No" name="pa_alt_contact_no" id="pa_alt_contact_no" />
                                                    <span class="text-danger" id="pa_alt_contact_noErr"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" id="pa_alt_country_code" name="pa_alt_country_code" value="">
                                            <input type="hidden" id="pa_alt_dial_code" name="pa_alt_dial_code" value="">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" placeholder="Email" name="pa_email" id="pa_email" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Pan Card</label>
                                                    <input type="text" class="form-control" placeholder="Pan Card" name="pa_pan_card" id="pa_pan_card" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Address" name="pa_address" id="pa_address" />
                                                    <span class="text-danger" id="pa_addressErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select name="pa_country" id="pa_country" class="form-control">
                                                        <option value="">-Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>State <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="State" name="pa_state" id="pa_state" />
                                                    <span class="text-danger" id="pa_stateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>City <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="City" name="pa_city" id="pa_city" />
                                                    <span class="text-danger" id="pa_cityErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Pin Code <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Pin Code" name="pa_pincode" id="pa_pincode" />
                                                    <span class="text-danger" id="pa_pincodeErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>DOB</label>
                                                    <input type="date" class="form-control" placeholder="DOB" name="pa_dob" id="pa_dob" max="{{ date('Y-m-d') }}" onchange="changeDOB(this.value)" />
                                                    <span class="text-danger" id="pa_dobErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Age <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Age" name="pa_age" id="pa_age" />
                                                    <span class="text-danger" id="pa_ageErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select name="pa_gender" id="pa_gender" class="form-control">
                                                        <option value="">-select-</option>
                                                        <option value="male">Male</option>
                                                        <option value="female" selected>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Marital Status</label>
                                                    <select name="pa_marital_status" id="pa_marital_status" class="form-control">
                                                        <option value="">-select-</option>
                                                        <option value="married">Married</option>
                                                        <option value="single">Single</option>
                                                        <option value="divorced">Divorced</option>
                                                        <option value="widow">Widow</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Occupation</label>
                                                    <input type="text" class="form-control" placeholder="Occupation" name="pa_occupation" id="pa_occupation" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Last Menstrual Period</label>
                                                    <input type="text" class="form-control" placeholder="Last Menstrual Period" name="pa_last_monestrual_period" id="pa_last_monestrual_period" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Number of Pregnancy</label>
                                                    <input type="text" class="form-control" placeholder="Number of Pregnancy" name="pa_pregnancy_no" id="pa_pregnancy_no" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Number of Miscarriages</label>
                                                    <input type="text" class="form-control" placeholder="Number of Miscarriages" name="pa_miscarriages_no" id="pa_miscarriages_no" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Number of Abortion</label>
                                                    <input type="text" class="form-control" placeholder="Number of Abortion" name="pa_abortion_no" id="pa_abortion_no" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Number of Living Children</label>
                                                    <input type="text" class="form-control" placeholder="Number of Living Children" name="pa_children_no" id="pa_children_no" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Photo</label>
                                                    <input type="file" class="form-control" placeholder="Photo" name="pa_photo" id="pa_photo" />
                                                </div>
                                            </div>
                                            <div class="col-12 d-none">
                                                <h4>Do you consume any of below?</h4>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Tobacco</label>
                                                    <select name="pa_tobacco" id="pa_tobacco" class="form-control">
                                                        <option value="">-Select</option>
                                                        <option value="no">No</option>
                                                        <option value="occational">Occational</option>
                                                        <option value="regular">Regular</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Smoking</label>
                                                    <select name="pa_smoking" id="pa_smoking" class="form-control">
                                                        <option value="">-Select</option>
                                                        <option value="no">No</option>
                                                        <option value="occational">Occational</option>
                                                        <option value="regular">Regular</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Alcohol</label>
                                                    <select name="pa_alcohol" id="pa_alcohol" class="form-control">
                                                        <option value="">-Select</option>
                                                        <option value="no">No</option>
                                                        <option value="occational">Occational</option>
                                                        <option value="regular">Regular</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 d-none">
                                                <div class="form-group">
                                                    <label>Any medical or surgical history?</label>
                                                    <textarea name="pa_medical_history" id="pa_medical_history" class="form-control" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 d-none">
                                                <div class="form-group">
                                                    <label>Family member had any medical or surgical history?</label>
                                                    <textarea name="pa_family_medical_history" id="pa_family_medical_history" class="form-control" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Referred By</label>
                                                    <select name="pa_referred_by" id="pa_referred_by" class="form-control" onchange="changeReferrer(this.value)">
                                                        <option value="">-Select</option>
                                                        <option value="doctor">Doctor</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none" id="pa_referred_doctor_box">
                                                <div class="form-group search_bar">
                                                    <label>Referred Doctor</label>
                                                    <input type="text" id="pa_referred_doctor" name="pa_referred_doctor" placeholder="Referred Doctor" class="form-control" onkeyup="searchReferredDoctor(this.value)" />
                                                    <ul id="search_doctor_list" class="d-none"></ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none" id="pa_referred_text_box">
                                                <div class="form-group">
                                                    <label>Referred Name</label>
                                                    <input type="text" name="pa_referred_text" id="pa_referred_text" placeholder="Referred Name" class="form-control" />
                                                </div>
                                            </div>
                                        </div> -->
                                        <!--begin: Code-->
                                        <div class="example-code mt-10">
                                            <div class="example-highlight">
                                                <pre style="height:400px">
                                            </div>
                                        </div>
                                        <!--end: Code-->
                                    </div>
                                    <!-- <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" id="createBtn">Add</button>
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                                    </div> -->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>

    </div>
</div>
<!--end::Row-->
<script>
    function changeDOB(date){
        let dob = new Date(date);
        let today = new Date();
        let age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        $('#pa_age').val(age);
    }

    function changeReferrer(pa_referred_by){
        if(pa_referred_by == 'doctor'){
            $('#pa_referred_doctor_box').removeClass('d-none');
            $('#pa_referred_text_box').addClass('d-none');
            $('#pa_referred_text').val('');
        }else if(pa_referred_by == 'other'){
            $('#pa_referred_doctor_box').addClass('d-none');
            $('#pa_referred_text_box').removeClass('d-none');
            $('#pa_referred_doctor').val('');
        }else{
            $('#pa_referred_doctor_box').addClass('d-none');
            $('#pa_referred_text_box').addClass('d-none');
            $('#pa_referred_text').val('');
            $('#pa_referred_doctor').val('');
        }
    }

    function searchReferredDoctor(text){
        if(text != ''){
            $.ajax({
                url:"{{ route('referred-doctor.search.list', '') }}" + '/' + btoa(text),
                method:"get",
                success:function(res){
                    if(res.response === true){
                        let data = res.data;
                        let option = '';
                        data.map((val) => option += '<li onclick="selectDoctorName(`'+val.rd_name+'`)">'+val.rd_name+'</li>');
                        $('#search_doctor_list').html(option);
                        $('#search_doctor_list').removeClass('d-none');
                    }else{
                        sweetAlertError(res.message, 3000);
                        $('#search_doctor_list').addClass('d-none');
                    }
                },
                error: function(r){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                    $('#search_doctor_list').addClass('d-none');
                }
            });
        }else{
            $('#search_doctor_list').html('');
            $('#search_doctor_list').addClass('d-none');
        }
    }

    function selectDoctorName(text){
        $('#pa_referred_doctor').val(text);
        $('#search_doctor_list').html('');
        $('#search_doctor_list').addClass('d-none');
    }

    $("form").submit(function(e) {
        e.preventDefault();
        let pa_name = $('#pa_name').val();
        let pa_contact_no = jQuery.trim($('#pa_contact_no').val());
        pa_contact_no = pa_contact_no.replace(' ', '');
        pa_contact_no = pa_contact_no.replace(' ', '');
        pa_contact_no = pa_contact_no.replace(' ', '');
        pa_contact_no = pa_contact_no.replace('(', '');
        pa_contact_no = pa_contact_no.replace(')', '');
        pa_contact_no = pa_contact_no.replace('-', '');
        let pa_alt_contact_no = $('#pa_alt_contact_no').val();
        pa_alt_contact_no = pa_alt_contact_no.replace(' ', '');
        pa_alt_contact_no = pa_alt_contact_no.replace(' ', '');
        pa_alt_contact_no = pa_alt_contact_no.replace(' ', '');
        pa_alt_contact_no = pa_alt_contact_no.replace('(', '');
        pa_alt_contact_no = pa_alt_contact_no.replace(')', '');
        pa_alt_contact_no = pa_alt_contact_no.replace('-', '');
        let pa_address = $('#pa_address').val();
        let pa_city = $('#pa_city').val();
        let pa_pincode = $('#pa_pincode').val();
        let pa_state = $('#pa_state').val();
        let pa_dob = $('#pa_dob').val();
        let pa_age = $('#pa_age').val();
        if(pa_name == ''){
            $('#pa_nameErr').text('Please enter patient name');
            timeoutID('pa_nameErr', 3000);
            scrollTop('pa_nameErr');
        }
        else if(pa_contact_no == ''){
            $('#pa_contact_noErr').text('Please enter contact no');
            timeoutID('pa_contact_noErr', 3000);
            scrollTop('pa_contact_noErr');
        }
        else if(pa_contact_no.length < 10){
            $('#pa_contact_noErr').text('Contact number must be 10 digit');
            timeoutID('pa_contact_noErr', 3000);
            scrollTop('pa_contact_noErr');
        }
        else if(pa_contact_no.length > 10){
            $('#pa_contact_noErr').text('Contact number must be 10 digit');
            timeoutID('pa_contact_noErr', 3000);
            scrollTop('pa_contact_noErr');
        }
        else if(pa_alt_contact_no == ''){
            $('#pa_alt_contact_noErr').text('Please enter alternate contact no');
            timeoutID('pa_alt_contact_noErr', 3000);
            scrollTop('pa_alt_contact_noErr');
        }
        else if(pa_alt_contact_no.length < 10){
            $('#pa_alt_contact_noErr').text('Contact number must be 10 digit');
            timeoutID('pa_alt_contact_noErr', 3000);
            scrollTop('pa_alt_contact_noErr');
        }
        else if(pa_alt_contact_no.length > 10){
            $('#pa_alt_contact_noErr').text('Contact number must be 10 digit');
            timeoutID('pa_alt_contact_noErr', 3000);
            scrollTop('pa_alt_contact_noErr');
        }
        else if(pa_address == ''){
            $('#pa_addressErr').text('Please enter address');
            timeoutID('pa_addressErr', 3000);
            scrollTop('pa_addressErr');
        }
        else if(pa_city == ''){
            $('#pa_cityErr').text('Please enter city');
            timeoutID('pa_cityErr', 3000);
            scrollTop('pa_cityErr');
        }
        else if(pa_city == ''){
            $('#pa_cityErr').text('Please enter city');
            timeoutID('pa_cityErr', 3000);
            scrollTop('pa_cityErr');
        }
        else if(pa_pincode == ''){
            $('#pa_pincodeErr').text('Please enter pin code');
            timeoutID('pa_pincodeErr', 3000);
            scrollTop('pa_pincodeErr');
        }
        else if(pa_state == ''){
            $('#pa_stateErr').text('Please enter state');
            timeoutID('pa_stateErr', 3000);
            scrollTop('pa_stateErr');
        }
        // else if(pa_dob == ''){
        //     $('#pa_dobErr').text('Please select patient DOB');
        //     timeoutID('pa_dobErr', 3000);
        //     scrollTop('pa_dobErr');
        // }
        else if(pa_age == ''){
            $('#pa_ageErr').text('Please enter age');
            timeoutID('pa_ageErr', 3000);
            scrollTop('pa_ageErr');
        }
        else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url:"{{ route('patient.store') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('appointment.create') }}?patient="+btoa(res.data['pa_id']));
                    }else{
                        sweetAlertError(res.message, 3000); 
                    }
                },
                error: function(r){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000); 
                }
            });
        }
    })
</script>
@endsection
@section('custom-script')
<script>
    // /* Start:: Patient add Code */
    const countryData = window.intlTelInput.getCountryData();
    const input = document.querySelector("#pa_contact_no");
    const addressDropdown = document.querySelector("#pa_country");
    
    for (let i = 0; i < countryData.length; i++) {
        const country = countryData[i];
        const optionNode = document.createElement("option");
        optionNode.value = country.name;
        const textNode = document.createTextNode(country.name);
        optionNode.appendChild(textNode);
        addressDropdown.appendChild(optionNode);
    }

    const iti = window.intlTelInput(input, {
        initialCountry: "in",
        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js"),
        hiddenInput: (telInputName) => ({
            pa_contact_no: "phone_full",
            country: "pa_country_code"
        }),
    });

    addressDropdown.value = iti.getSelectedCountryData().name;
    $('#pa_country_code').val(iti.getSelectedCountryData().iso2);
    $('#pa_dial_code').val(iti.getSelectedCountryData().dialCode);

    input.addEventListener('countrychange', () => {
        addressDropdown.value = iti.getSelectedCountryData().name;
        $('#pa_country_code').val(iti.getSelectedCountryData().iso2);
        $('#pa_dial_code').val(iti.getSelectedCountryData().dialCode);
    });

    addressDropdown.addEventListener('change', () => {
        iti.setCountry(addressDropdown.value);
    });
    // /* End:: Patient add Code */
    const input1 = document.querySelector("#pa_alt_contact_no");
    const iti1 = window.intlTelInput(input1, {
        initialCountry: "in",
        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js"),
        hiddenInput: (telInputName) => ({
            pa_alt_contact_no: "phone_full",
            country: "pa_alt_country_code"
        }),
    });
    $('#pa_alt_country_code').val(iti1.getSelectedCountryData().iso2);
    $('#pa_alt_dial_code').val(iti1.getSelectedCountryData().dialCode);
    input1.addEventListener('countrychange', () => {
        $('#pa_alt_country_code').val(iti1.getSelectedCountryData().iso2);
        $('#pa_alt_dial_code').val(iti1.getSelectedCountryData().dialCode);
    });
</script>
@endsection