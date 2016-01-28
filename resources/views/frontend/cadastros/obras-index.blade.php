@extends('frontend.layouts.master')



@section('content')

<?php foreach( $obras as $obra){
	echo $obra->codigoObra;
} ?>

@endsection