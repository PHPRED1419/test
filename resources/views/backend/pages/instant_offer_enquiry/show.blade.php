@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.instant_offer_enquiry.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.instant_offer_enquiry.partials.header-breadcrumbs')
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>From</th>
                        <td>{{ $contact->name }}</td>
                    </tr>
                    
                    <tr>
                        <th>Mobile</th>
                        <td><a href="tel:{{ $contact->mobile }}">{{ $contact->mobile }}</a></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                    </tr>

                    <tr>
                        <th>Country</th>
                        <td>{{ $contact->country }}</td>
                    </tr>
                    <tr>
                        <th>National Code</th>
                        <td>{{ $contact->national_code }}</td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td>{{ $contact->company }}</td>
                    </tr>
                    <tr>
                        <th>Current Business</th>
                        <td>{{ $contact->current_business }}</td>
                    </tr>
                    <tr>
                        <th>Sales Turnover</th>
                        <td>{{ $contact->sales_turnover }}</td>
                    </tr>
                    <tr>
                        <th>Past Experience</th>
                        <td>{{ $contact->past_experience }}</td>
                    </tr>
                    <tr>
                        <th>Purpose for</th>
                        <td>{{ $contact->purpose_for }}</td>
                    </tr>
                    <tr>
                        <th>Choose Model</th>
                        <td>{{ $contact->choose_model }}</td>
                    </tr>
                    <tr>
                        <th>Model Capacity</th>
                        <td>{{ $contact->model_capacity }}</td>
                    </tr>
                    <tr>
                        <th>Safety Features</th>
                        <td>{{ $contact->safety_features }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $contact->mobile_number }}</td>
                    </tr>
                    <tr>
                        <th>Website</th>
                        <td>{{ $contact->website }}</td>
                    </tr>
                    <tr>
                        <th>Installation Country</th>
                        <td>{{ $contact->installation_country }}</td>
                    </tr>
                    <tr>
                        <th>Timeline</th>
                        <td>{{ $contact->timeline }}</td>
                    </tr>
                    <tr>
                        <th>Expected Discount</th>
                        <td>{{ $contact->expected_discount }}</td>
                    </tr>
                    
                    <?php
                    /*<tr>
                        <th>Subject</th>
                        <td>{{ $contact->subject }}</td>
                    </tr>
                    */
                    ?>
                    <tr>
                        <th>Message</th>
                        <td>{{ $contact->message }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
