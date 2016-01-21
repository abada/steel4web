@extends('backend.layouts.master')



@section('content')

<?php foreach( $obras as $obra){
	echo $obra->codigoObra;
} ?>

@endsection