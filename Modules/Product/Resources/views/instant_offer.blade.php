@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | Get Instant Offer
@endsection

@section('main-content')
@include('frontend.layouts.partials.inner-banner')

<nav aria-label="breadcrumb" class="breadcrumb_bg">
    <div class="container-xxl position-relative">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Get Instant Offer</li>
        </ol>
    </div>
</nav>

<div class="mt-3 mb-5">
    <div class="container-xxl position-relative">
        <div class="cms_area">
            <div class="offer-section">
                <div class="heading-section">
                <a name="sent"></a>
                    <h3>GET INSTANT ONLINE OFFER /QUOTE </h3>
                    <p><strong>BUYER PLEASE FILL THIS ONLINE FORM FOR INSTANT QUOTE FOR OXYGEN PLANT </strong></p>
                    <p>(CALL:+91-9871872626 FOR ANY ASSISTANCE OR EMAIL TO <a href="mailto:info@universalboschi.net">info@universalboschi.net</a>)</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success" style="font-size: 23px;">
                        {{ session('success') }}
                    </div>
                @endif

<?php
/*
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
*/
?>

                <form action="{{ route('submit.instant.offer') }}#sent" method="post"  id="offerForm" class="needs-validation">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <tbody>
                                <!-- SECTION A -->
                                <tr>
                                    <td colspan="3">
                                        <h2>CUSTOMER PROFILE SECTION A</h2>
                                        <p class="font13">(PLEASE FILL IN THE DETAILS GET MAXIMUM DISCOUNTS BY BUILDING YOUR PROFILE WITH INGLA.BOSCHI COMPANY)</p>
                                    </td>
                                </tr>                                
                                <!-- Field 1: Name -->
                                <tr>
                                    <td class="serial-no" width="5%">1</td>
                                    <td class="text-label" width="50%">
                                        <label for="name">NAME OF BUYER (PERSON)<sup>*</sup></label>
                                    </td>
                                    <td class="input-data" width="45%">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
                                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 2: Country -->
                                <tr>
                                    <td class="serial-no">2</td>
                                    <td class="text-label">
                                        <label for="country">COUNTRY<sup>*</sup></label>
                                    </td>
                                    <td class="input-data">
                                    <input type="text" list="country" autocomplete="on" name="country" class="form-control" placeholder="Your Country* (Required)" value="{{ old('country') }}">
                                    <datalist id="country">
                                    @foreach(country_list() as $country)
                                        <option value="{{ $country }}" {{ old('country') == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                    </datalist>
                                    @error('country')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 3: Email -->
                                <tr>
                                    <td class="serial-no">3</td>
                                    <td class="text-label">
                                        <label for="email">EMAIL ADDRESS <br>(OFFER WILL BE SENT TO YOUR EMAIL ID)<sup>*</sup></label>
                                    </td>
                                    <td class="input-data">
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                                        @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 4: Mobile -->
                                <tr>
                                    <td class="serial-no">4</td>
                                    <td class="text-label">
                                        <label><strong>MOBILE</strong> PHONE NUMBER <sup>*</sup></label>
                                    </td>
                                    <td class="input-data">
                                    <div class="flex">
                                    <select name="nationalCode" class="mobile-code">
                                    @foreach(country_code_list() as $code)
                                        <option value="{{ $code }}" {{ old('nationalCode') == $code ? 'selected' : '' }}>
                                            {{ $code }}
                                        </option>
                                    @endforeach
                                    </select>
                                    <input type="number" name="mobile" placeholder="Mobile number" value="{{ old('mobile') }}"> 
                                    </div>
                                    @error('mobile')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 5: Company -->
                                <tr>
                                    <td class="serial-no">5</td>
                                    <td class="text-label">
                                        <label for="company"><strong>COMPANY NAME</strong> IN WHICH OFFER IS REQUIRED (IF ANY) IF NO COMPANY WRITE PERSON FULL NAME</label>
                                    </td>
                                    <td class="input-data">
                                        <input type="text" name="company" id="company" class="form-control" value="{{ old('company') }}">
                                        @error('company')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 6: Current Business -->
                                <tr>
                                    <td class="serial-no">6</td>
                                    <td class="text-label">
                                        <label>BRIEF DETAILS YOUR <strong>CURRENT BUSINESS/PROFESSION</strong> OF BUYER <sup>*</sup></label>
                                    </td>
                                    <td class="input-data">
                                    <div class="checkbox-list">
                                    <input value="SERVICES" type="radio" name="currentbusiness" id="SERVICES" @if( old('currentbusiness') == 'SERVICES') checked @endif>
                                    <label for="SERVICES">SERVICES </label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="JOB" type="radio" name="currentbusiness" id="JOB" @if( old('currentbusiness') == 'JOB') checked @endif>
                                    <label for="JOB">JOB</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="FACTORY" type="radio" name="currentbusiness" id="FACTORY" @if( old('currentbusiness') == 'FACTORY') checked @endif>
                                    <label for="FACTORY">FACTORY</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="TRADING BUSINESS" type="radio" name="currentbusiness" id="TRADINGbUSINESS" @if( old('currentbusiness') == 'TRADING BUSINESS') checked @endif>
                                    <label for="TRADINGbUSINESS">TRADING BUSINESS</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="STEEL OR PROCESS INDUSTRY" type="radio" name="currentbusiness" id="PROCESSiNDUSTRY" @if( old('currentbusiness') == 'STEEL OR PROCESS INDUSTRY') checked @endif>
                                    <label for="PROCESSiNDUSTRY">STEEL OR PROCESS INDUSTRY </label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="ANY OTHER" type="radio" name="currentbusiness" id="ANYoTHER" @if( old('currentbusiness') == 'ANY OTHER') checked @endif>
                                    <label for="ANYoTHER">ANY OTHER</label>
                                    </div>
                                    @error('currentbusiness')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 7: Sales Turnover -->
                                <tr>
                                    <td class="serial-no">7</td>
                                    <td class="text-label">
                                        <label>WHAT IS YOUR CURRENT BUSINESS <strong>SALES TURNOVER PER YEAR</strong> (IF APPLICABLE) <sup>*</sup></label>
                                    </td>
                                    <td class="input-data">
                                    <div class="checkbox-list">
                                    <input value="NIL" type="radio" name="salesturnover" id="NIL" @if( old('salesturnover') == 'NIL') checked @endif>
                                    <label for="NIL">NIL</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="UPTO 100,000 USD" type="radio" name="salesturnover" id="UPTO100" @if( old('salesturnover') == 'UPTO 100,000 USD') checked @endif>
                                    <label for="UPTO100">UPTO 100,000 USD</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="UPTO 300,000 USD" type="radio" name="salesturnover" id="UPTO300"  @if( old('salesturnover') == 'UPTO 300,000 USD') checked @endif>
                                    <label for="UPTO300">UPTO 300,000 USD</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="UPTO 1 MILLION USD" type="radio" name="salesturnover" id="UPTO1"  @if( old('salesturnover') == 'UPTO 1 MILLION USD') checked @endif>
                                    <label for="UPTO1">UPTO 1 MILLION USD</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="UPTO 2 MILLION USD" type="radio" name="salesturnover" id="UPTO2"  @if( old('salesturnover') == 'UPTO 2 MILLION USD') checked @endif>
                                    <label for="UPTO2">UPTO 2 MILLION USD</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="OVER 2 MILLION USD" type="radio" name="salesturnover" id="OVER2"  @if( old('salesturnover') == 'OVER 2 MILLION USD') checked @endif>
                                    <label for="OVER2">OVER 2 MILLION USD</label>
                                    </div>
                                    @error('salesturnover')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 8: Past Experience -->
                                <tr>
                                    <td class="serial-no">8</td>
                                    <td class="text-label">
                                        <label>DO YOU HAVE ANY PAST EXPERIENCE IN OXYGEN OR NITROGEN GAS CYLINDERS <sup>*</sup></label>
                                    </td>
                                    <td class="input-data">
                                    <p><strong>(CAN SELECT ONE OR MORE)</strong></p>
                                    <div class="checkbox-list">
                                    <input value="FIRST TIME SET UP AS NEW PROJECT" type="checkbox" name="pastexperience[]" id="SELLINGGAS" @if(is_array(old('pastexperience')) && in_array('FIRST TIME SET UP AS NEW PROJECT', old('pastexperience'))) checked @endif>
                                    <label for="FIRSTTIME">FIRST TIME SET UP AS NEW PROJECT</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="SELLING GAS CYLINDERS" type="checkbox" name="pastexperience[]" id="SELLINGGAS" @if(is_array(old('pastexperience')) && in_array('SELLING GAS CYLINDERS', old('pastexperience'))) checked @endif>
                                    <label for="SELLINGGAS">SELLING GAS CYLINDERS</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="PRODUCTION OF OXYGEN" type="checkbox" name="pastexperience[]" id="SELLINGGAS" @if(is_array(old('pastexperience')) && in_array('PRODUCTION OF OXYGEN', old('pastexperience'))) checked @endif>
                                    <label for="PRODUCTIONOXYGEN">PRODUCTION OF OXYGEN </label>
                                    </div>
                                    @error('pastexperience')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- SECTION B -->
                                <tr>
                                    <td colspan="3">
                                        <h2>SELECTION OF MODEL /CAPACITY /FEATURES /BUDGET /DISCOUNTS</h2>
                                        <p>BY SPENDING YOUR VALUABLE TIME IN TICKING THE BOXES WE CAN ARRIVE AT THE CORRECT AND MOST APPROPRIATE MODEL FOR OXYGEN NITROGEN PLANT AS PER YOUR BUDGET</p>
                                    </td>
                                </tr>
                                
                                <!-- Field 9: Purpose For -->
                                <tr>
                                <td class="serial-no">9</td>
                                <td class="text-label">
                                <label>PURPOSE FOR SETTING OXYGEN PLANT <sup>*</sup></label>
                                </td>
                                <td class="input-data">
                                <p><strong>(CAN SELECT ONE OR MORE)</strong></p>
                                <div class="checkbox-list">
                                <input value="INDUSTRIAL USES" type="checkbox" name="purposefor[]" id="purposefor" @if(is_array(old('purposefor')) && in_array('INDUSTRIAL USES', old('purposefor'))) checked @endif>
                                <label for="INDUSTRIAL">INDUSTRIAL USES</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="MEDICAL USE" type="checkbox" name="purposefor[]" id="purposefor" @if(is_array(old('purposefor')) && in_array('MEDICAL USE', old('purposefor'))) checked @endif>
                                <label for="MEDICAL">MEDICAL USE</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="SET UP AS NEW PROJECT" type="checkbox" name="purposefor[]" id="purposefor" @if(is_array(old('purposefor')) && in_array('SET UP AS NEW PROJECT', old('purposefor'))) checked @endif>
                                <label for="NEWPROJECT">SET UP AS NEW PROJECT</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="SELL IN MARKET" type="checkbox" name="purposefor[]" id="purposefor" @if(is_array(old('purposefor')) && in_array('SELL IN MARKET', old('purposefor'))) checked @endif>
                                <label for="SELLIN">SELL IN MARKET </label>
                                </div>
                                <div class="checkbox-list">
                                <input value="OWN CONSUMPTION" type="checkbox" name="purposefor[]" id="purposefor" @if(is_array(old('purposefor')) && in_array('OWN CONSUMPTION', old('purposefor'))) checked @endif>
                                <label for="CONSUMPTION">OWN CONSUMPTION</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="ANY OTHER" type="checkbox" name="purposefor[]" id="purposefor" @if(is_array(old('purposefor')) && in_array('ANY OTHER', old('purposefor'))) checked @endif>
                                <label for="ANYOTHER">ANY OTHER</label>
                                </div>
                                @error('purposefor')<div class="text-danger small">{{ $message }}</div>@enderror
                                </td>
                                </tr>
                                
                                <!-- Field 10: Choose Model -->
                                <tr>
                                    <td class="serial-no">10</td>
                                    <td class="text-label">
                                        <label for="choosemodel">IF ALREADY CHOOSE THE MODEL AND CAPACITY FROM WEBSITE (PLEASE GIVE MODEL /CAPACITY)</label>
                                    </td>
                                    <td class="input-data">
                                        <input type="text" name="choosemodel" id="choosemodel" class="form-control" placeholder="FILL MODEL NO. /CAPACITY" value="{{ old('choosemodel') }}">
                                        @error('choosemodel')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 11: Model Capacity -->
                                <tr>
                                <td class="serial-no">11</td>
                                <td class="text-label">
                                <label><strong>GIVE MODEL &amp; CAPACITY</strong> (OR GIVE US APPROX. BUDGET INVESTMENT  IDEA) OF OXYGEN /NITROGEN  PLANT  <sup>*</sup></label>
                                </td>
                                <td class="input-data">
                                <div class="checkbox-list">
                                <input value="20M3/HR TO 50 M3/HR (125000 USD TO 200,000 USD)" type="radio" name="modelcapacity" id="20M3" @if( old('modelcapacity') == '20M3/HR TO 50 M3/HR (125000 USD TO 200,000 USD)') checked @endif>
                                <label for="20M3">20M3/HR TO 50 M3/HR (125000 USD TO 200,000 USD)</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="80M3/HR TO 170 M3/HR (200000 USD TO 300,000 USD)" type="radio" name="modelcapacity" id="80M3" @if( old('modelcapacity') == '80M3/HR TO 170 M3/HR (200000 USD TO 300,000 USD)') checked @endif>
                                <label for="80M3">80M3/HR TO 170 M3/HR (200000 USD TO 300,000 USD)</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="200M3/HR TO 400 M3/HR (300000 USD TO 500,000 USD)" type="radio" name="modelcapacity" id="200M3" @if( old('modelcapacity') == '200M3/HR TO 400 M3/HR (300000 USD TO 500,000 USD)') checked @endif>
                                <label for="200M3">200M3/HR TO 400 M3/HR (300000 USD TO 500,000 USD)</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="500M3/HR TO 700 M3/HR (600000 USD TO 800,000 USD)" type="radio" name="modelcapacity" id="500M3" @if( old('modelcapacity') == '500M3/HR TO 700 M3/HR (600000 USD TO 800,000 USD)') checked @endif>
                                <label for="500M3">500M3/HR TO 700 M3/HR (600000 USD TO 800,000 USD)</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="800M3/HR TO 1500 M3/HR (900000 USD TO 30,00,000 USD)" type="radio" name="modelcapacity" id="800M3" @if( old('modelcapacity') == '800M3/HR TO 1500 M3/HR (900000 USD TO 30,00,000 USD)') checked @endif>
                                <label for="800M3">800M3/HR TO 1500 M3/HR (900000 USD TO 30,00,000 USD)</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="ANY OTHER" type="radio" name="modelcapacity" id="ANYOTHERcapacity" @if( old('modelcapacity') == 'ANY OTHER') checked @endif>
                                <label for="ANYOTHERcapacity">ANY OTHER</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="TONNAGE LIQUID OXYGEN NITROGEN PLANTS (1 MILLION USD STARTING)" type="radio" name="modelcapacity" id="TONNAGE" @if( old('modelcapacity') == 'TONNAGE LIQUID OXYGEN NITROGEN PLANTS (1 MILLION USD STARTING)') checked @endif>
                                <label for="TONNAGE">TONNAGE LIQUID OXYGEN NITROGEN PLANTS (1 MILLION USD STARTING)</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="LARGE GAS COMPLEX (2 MILLION UPTO 5 MILLION USD)" type="radio" name="modelcapacity" id="LARGEGAS" @if( old('modelcapacity') == 'LARGE GAS COMPLEX (2 MILLION UPTO 5 MILLION USD)') checked @endif>
                                <label for="LARGEGAS">LARGE GAS COMPLEX (2 MILLION UPTO 5 MILLION USD)</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="ALREADY GIVE THE MODEL/CAPACITY ABOVE" type="radio" name="modelcapacity" id="ALREADY" @if( old('modelcapacity') == 'ALREADY GIVE THE MODEL/CAPACITY ABOVE') checked @endif>
                                <label for="ALREADY">ALREADY GIVE THE MODEL/CAPACITY ABOVE</label>
                                </div>
                                @error('modelcapacity')<div class="text-danger small">{{ $message }}</div>@enderror
                                </td>
                                </tr>
                                
                                <!-- Field 12: Safety Features -->
                                <tr>
                                    <td class="serial-no">12</td>
                                    <td class="text-label">
                                        <label>DO YOU WANT TO HAVE SAFETY AND FEATURES OF EUROPEAN QUALITY IN YOU OXYGEN PLANTS OFFER</label>
                                    </td>
                                    <td class="input-data">
                                    <p><strong>(CAN SELECT ONE OR MORE)</strong></p>
                                    <div class="checkbox-list">
                                    <input value="GERMAN STAINLESS STEEL LEAK PROOF COLUMN" type="checkbox" name="safety[]" id="GERMAN" @if(is_array(old('safety')) && in_array('GERMAN STAINLESS STEEL LEAK PROOF COLUMN', old('safety'))) checked @endif>
                                    <label for="GERMAN">GERMAN STAINLESS STEEL LEAK PROOF COLUMN</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="ZERO MAINTENANCE AIR COMPRESSOR ATLAS COPCO" type="checkbox" name="safety[]" id="ZERO" @if(is_array(old('safety')) && in_array('ZERO MAINTENANCE AIR COMPRESSOR ATLAS COPCO', old('safety'))) checked @endif>
                                    <label for="ZERO">ZERO MAINTENANCE AIR COMPRESSOR ATLAS COPCO</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="NEW TYPE A TECHNOLOGY" type="checkbox" name="safety[]" id="NEWTYPE" @if(is_array(old('safety')) && in_array('NEW TYPE A TECHNOLOGY', old('safety'))) checked @endif>
                                    <label for="NEWTYPE">NEW TYPE A TECHNOLOGY </label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="LIQUID OXYGEN PRODUCTION" type="checkbox" name="safety[]" id="LIQUIDOXYGEN" @if(is_array(old('safety')) && in_array('LIQUID OXYGEN PRODUCTION', old('safety'))) checked @endif>
                                    <label for="LIQUIDOXYGEN">LIQUID OXYGEN PRODUCTION </label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="NITROGEN PRODUCTION AND FILLING" type="checkbox" name="safety[]" id="NITROGEN" @if(is_array(old('safety')) && in_array('NITROGEN PRODUCTION AND FILLING', old('safety'))) checked @endif>
                                    <label for="NITROGEN">NITROGEN PRODUCTION AND FILLING</label>
                                    </div>
                                    <div class="checkbox-list">
                                    <input value="NEED ASSISTANCE OF SALES TEAM TO SELECT" type="checkbox" name="safety[]" id="NEEDASSISTANCE" @if(is_array(old('safety')) && in_array('NITROGEN PRODUCTION AND FILLING', old('safety'))) checked @endif>
                                    <label for="NEEDASSISTANCE">NEED ASSISTANCE OF SALES TEAM TO SELECT</label>
                                    </div>
                                    @error('safety')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 13: Mobile Number -->
                                <tr>
                                    <td class="serial-no">13</td>
                                    <td class="text-label">
                                        <label for="mobilenumber">GIVE A MOBILE NUMBER TO GET IN TOUCH IMMEDIATELY BY OUR SALES MANAGER AT THE TIME GENERATING YOUR OFFER</label>
                                    </td>
                                    <td class="input-data">
                                        <input type="tel" name="mobilenumber" id="mobilenumber" class="form-control" placeholder="GIVE MOBILES NO" value="{{ old('mobilenumber') }}">
                                        @error('mobilenumber')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 14: Website -->
                                <tr>
                                    <td class="serial-no">14</td>
                                    <td class="text-label">
                                        <label for="website">FILL YOUR COMPANY WEBSITE DETAILS IF ANY</label>
                                    </td>
                                    <td class="input-data">
                                        <input type="url" name="website" id="website" class="form-control" placeholder="WWW.ABCD.COM" value="{{ old('website') }}">
                                        @error('website')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 15: Installation Country -->
                                <tr>
                                    <td class="serial-no">15</td>
                                    <td class="text-label">
                                        <label for="installation">COUNTRY OF INSTALLATION OF THE OXYGEN PLANT (THIS WILL HELP US IN KNOWING THE SITE CONDITIONS) <sup>*</sup></label>
                                    </td>
                                    <td class="input-data">
                                        <input type="text" name="installation" id="installation" class="form-control" placeholder="EXAMPLE: ETHIOPIA" value="{{ old('installation') }}">
                                        @error('installation')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                
                                <!-- Field 16: Timeline -->
                                <tr>
                                <td class="serial-no">16</td>
                                <td class="text-label">
                                <label>EXPECTED PURCHASE ORDER TIMELINE <sup>*</sup></label>
                                </td>
                                <td class="input-data">
                                <div class="checkbox-list">
                                <input value="IMMEDIATE" type="radio" name="timeline" id="IMMEDIATE" @if( old('timeline') == 'IMMEDIATE') checked @endif>
                                <label for="IMMEDIATE">IMMEDIATE</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="WITHIN 30 DAYS" type="radio" name="timeline" id="30DAYS" @if( old('timeline') == 'WITHIN 30 DAYS') checked @endif>
                                <label for="30DAYS">WITHIN 30 DAYS</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="WITHIN 60 DAYS" type="radio" name="timeline" id="60DAYS" @if( old('timeline') == 'WITHIN 60 DAYS') checked @endif>
                                <label for="60DAYS">WITHIN 60 DAYS</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="WITHIN 90 DAYS" type="radio" name="timeline" id="90DAYS" @if( old('timeline') == 'WITHIN 90 DAYS') checked @endif>
                                <label for="90DAYS">WITHIN 90 DAYS</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="MORE THAN 90 DAYS" type="radio" name="timeline" id="MORETHAN" @if( old('timeline') == 'MORE THAN 90 DAYS') checked @endif>
                                <label for="MORETHAN">MORE THAN 90 DAYS</label>
                                </div>
                                @error('timeline')<div class="text-danger small">{{ $message }}</div>@enderror
                                </td>
                                </tr>
                                
                                <!-- Field 17: Discount -->
                                <tr>
                                <td class="serial-no">17</td>
                                <td class="text-label">
                                <label>EXPECTED DISCOUNT ON LIST PRICE AS SPECIAL CASE <br><strong>WE HAVE SPECIAL FREEZONE AND PROMOTION DISCOUNTS AS PER ELIGIBILITY BY BOSCHI ITALY COMPANY POLICY</strong></label>
                                </td>
                                <td class="input-data">
                                <div class="checkbox-list">
                                <input value="5%" type="radio" name="discount" id="discount5" @if( old('discount') == '5%') checked @endif>
                                <label for="discount5">5%</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="10%" type="radio" name="discount" id="discount10" @if( old('discount') == '10%') checked @endif>
                                <label for="discount10">10%</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="20%" type="radio" name="discount" id="discount20" @if( old('discount') == '20%') checked @endif>
                                <label for="discount20">20%</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="30%" type="radio" name="discount" id="discount30" @if( old('discount') == '30%') checked @endif>
                                <label for="discount30">30%</label>
                                </div>
                                <div class="checkbox-list">
                                <input value="MORE THAN 30%" type="radio" name="discount" id="discount3" @if( old('discount') == 'MORE THAN 30%') checked @endif>
                                <label for="discount3">MORE THAN 30%</label>
                                </div>
                                @error('discount')<div class="text-danger small">{{ $message }}</div>@enderror
                                </td>
                                </tr>
                                
                                <!-- Field 18: Message -->
                                <tr>
                                    <td class="serial-no">18</td>
                                    <td class="text-label">
                                        <label for="message">FILL YOUR MESSAGE/REQUIREMENTS SPECIAL REQUIREMENTS FEATURES ETC</label>
                                    </td>
                                    <td class="input-data">
                                        <textarea name="message" id="message" class="form-control" placeholder="FILL HERE" rows="3">{{ old('message') }}</textarea>
                                        @error('message')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <p><strong>Note: </strong><strong style="color:red">*</strong> Compulsory field.</p>
                        <div class="btn-section">
                            <button type="submit" name="process" id="process" class="btn btn-primary cta-btn">
                                Send
                            </button>
                            <div class="pageloaderbox" style="display:none">
                                Processing <div class="spinner-border spinner-border-sm" role="status"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
