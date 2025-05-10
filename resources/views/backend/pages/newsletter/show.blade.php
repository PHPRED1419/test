@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.contact_enquiry.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.contact_enquiry.partials.header-breadcrumbs')
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>From</th>
                        <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                    </tr>                    
                    <tr>
                        <th>Mobile</th>
                        <td><a href="tel:{{ $contact->phone }}">{{ $contact->mobile_number }}</a></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
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
