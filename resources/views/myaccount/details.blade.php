@extends('myaccount.layout') 

@section('myaccount-content')
    <style type="text/css">
        td {
            padding: 5px;
            border: 2px solid black;
            width: 200px;
        }
        
        th {
            padding: 5px;
            border: 2px solid black;
            width: 200px;
        }
    </style>
    <table>
        <tr>
            <th>First Name</th>
            <td>{{ $customer->fname }}</td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>{{ $customer->lname }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $customer->email }}</td>
        </tr>
        <tr>
            <th>Company</th>
            <td>{{ $customer->company }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>{{ $customer->phone }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>
                {{ $customer->address1 }} <br/>
                {{ $customer->address2 }} 
            </td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $customer->country->name }}</td>
        </tr>
        <tr>
            <th>State</th>
            <td>{{ $customer->state->name }}</td>
        </tr>
        <tr>
            <th>City</th>
            <td>{{ $customer->city }}</td>
        </tr>
        <tr>
            <th>Postal code</th>
            <td>{{ $customer->postalcode }}</td>
        </tr>
        <tr>
            <th><a class="btn" href="{{route('myaccount.update')}}">Edit</a></th>
        </tr>
    </table>
@endsection