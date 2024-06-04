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
            <td>Sufiyan</td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>Ahmed</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>sufiyankhanzada748@gmail.com</td>
        </tr>
        <tr>
            <th>Company</th>
            <td>ABC</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>03461351500</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>Hyderabad&nbsp;&nbsp;hyderabad </td>
        </tr>
        <tr>
            <th>Country</th>
            <td>Pakistan</td>
        </tr>
        <tr>
            <th>State</th>
            <td>Azad Kashmir</td>
        </tr>
        <tr>
            <th>City</th>
            <td>hyderabad</td>
        </tr>
        <tr>
            <th>Postal code</th>
            <td>710000</td>
        </tr>
        <tr>
            <th><a class="btn" href="{{route('myaccount.update')}}">Edit</a></th>
        </tr>
    </table>
@endsection