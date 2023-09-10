@extends('layouts/master')

@section('content')

<?php
 echo "<p>hi</p>";
    $output = exec('python C:/xampp/htdocs/Hostel-Management-System/app/Python/test.py');
    echo "<pre>$output</pre>";
?>

@endsection