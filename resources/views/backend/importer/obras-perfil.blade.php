@extends('backend.layouts.master')

@section('page-header')
    <h1>
       {{ $obra->nome }}
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#detalhes" data-toggle="tab">Detalhes</a>
                        </li>
                        <li><a href="#etapas" data-toggle="tab">Etapas</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="detalhes">
                            <br />
                             @include('backend.importer.obras-perfil-inc')
                        </div>
                        <div class="tab-pane fade" id="etapas">
                        <br />
                             @include('backend.importer.etapas-listar-inc')
                        </div>
                    </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
    </div>


    <div class="row">
        <div class="col-lg-6 col-md-6">
            <a href="javascript:history.back()" type="button" class="btn btn-primary"><< Voltar</a>
        </div>
    </div>
@endsection