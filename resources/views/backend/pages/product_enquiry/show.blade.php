@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.product_enquiry.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.product_enquiry.partials.header-breadcrumbs')
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>From</th>
                        <td>{{ $contact->name }}</td>
                    </tr>
                    <tr>
                        <th>For Product</th>
                        <td>{{ $contact->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></td>
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
