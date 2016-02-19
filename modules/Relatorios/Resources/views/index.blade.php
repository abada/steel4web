@extends('frontend.layouts.master')
@section('styles')
{{ Html::style('modules/'.Module::find('Relatorios')->getLowerName().'/css/relatorios.css') }}
@endsection
@section('content')
{!! Breadcrumbs::render('Relatorios::index') !!}
	<div class="box">

		<div class="box-header bg-padrao with-border">
			RELATORIOS
		</div>
		
		{{-- <div class="nav-tabs-custom" style='margin-top:5px'>
			<ul class="nav nav-tabs ui-sortable-handle">
	            <li class="active">
	            	<a href="#gerais" data-toggle="tab">Gerais</a>
	            </li>
	            <li><a href="#pecas" data-toggle="tab">Peças</a>
	            </li>
	        </ul>
        </div>

        <div class="tab-content no-padding">
        	<div class="tab-pane fade in active" id="gerais">
        		@include('relatorios::geral')
        	</div>

        	<div class="tab-pane fade" id="pecas">
        		@include('relatorios::pecas')
        	</div>
        </div> --}}


		<div class="box-body">
        <div class="row">
        	<div class="col-md-3 relCol">
        		<div class="small-box bg-aqua">
        			<div class="inner">
        				<h3 style='padding-bottom:20px;font-size:45px;margin-top:10px'>Obras</h3>
        			</div>
        			<div class="icon">
        				<i class="fa fa-building"></i>
        			</div>
        			<a href="{{url('relatorios/obras')}}" class="small-box-footer">Gerar Relatorios <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        	<div class="col-md-3 relCol">
        		<div class="small-box bg-green">
        			<div class="inner">
        				<h3 style='padding-bottom:20px;font-size:45px;margin-top:10px'>Etapas</h3>
        			</div>
        			<div class="icon">
        				<i class="fa fa-cubes"></i>
        			</div>
        			<a href="{{url('relatorios/etapas')}}" class="small-box-footer">Gerar Relatorios <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        	<div class="col-md-3 relCol">
        		<div class="small-box bg-yellow">
        			<div class="inner">
        				<h3 style='padding-bottom:20px;font-size:45px;margin-top:10px'>Subetapas</h3>
        			</div>
        			<div class="icon">
        				<i class="fa fa-cube"></i>
        			</div>
        			<a href="{{url('relatorios/subetapas')}}" class="small-box-footer">Gerar Relatorios <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        	<div class="col-md-3 relCol">
        		<div class="small-box bg-red">
        			<div class="inner">
        				<h3 style='padding-bottom:20px;font-size:45px;margin-top:10px'>Importações</h3>
        			</div>
        			<div class="icon">
        				<i class="fa fa-upload"></i>
        			</div>
        			<a href="{{url('relatorios/importacoes')}}" class="small-box-footer">Gerar Relatorios <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        </div>

         <div class="row">
        	<div class="col-md-3 relCol">
        		<div class="small-box bg-orge">
        			<div class="inner">
        				<h3 style='padding-bottom:20px;font-size:45px;margin-top:10px'>Lotes</h3>
        			</div>
        			<div class="icon">
        				<i class="fa fa-th fa-fw"></i>
        			</div>
        			<a href="{{url('relatorios/lotes')}}" class="small-box-footer">Gerar Relatorios <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        	<div class="col-md-3 relCol">
        		<div class="small-box bg-teal">
        			<div class="inner">
        				<h3 style='padding-bottom:20px;font-size:45px;margin-top:10px'>Estagios</h3>
        			</div>
        			<div class="icon">
        				<i class="fa fa-exchange"></i>
        			</div>
        			<a href="{{url('relatorios/etapas')}}" class="small-box-footer">Gerar Relatorios <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        	<div class="col-md-3 relCol">
        		<div class="small-box bg-purple">
        			<div class="inner">
        				<h3 style='padding-bottom:20px;font-size:45px;margin-top:10px'>Apontamentos</h3>
        			</div>
        			<div class="icon">
        				<i class="fa fa-hand-pointer-o"></i>
        			</div>
        			<a href="{{url('relatorios/subetapas')}}" class="small-box-footer">Gerar Relatorios <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        	<div class="col-md-3 relCol">
        		<div class="small-box bg-gren">
        			<div class="inner">
        				<h3 style='padding-bottom:20px;font-size:45px;margin-top:10px'>Romaneios</h3>
        			</div>
        			<div class="icon">
        				<i class="fa fa-truck"></i>
        			</div>
        			<a href="{{url('relatorios/importacoes')}}" class="small-box-footer">Gerar Relatorios <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        </div>
        <a href="javascript:history.back()" class="btn btn-primary"><< Voltar</a>

   </div>
</div>



@endsection

@section('scripts')

{!! Html::script('js/ajax/relatorios.js') !!}

@endsection
