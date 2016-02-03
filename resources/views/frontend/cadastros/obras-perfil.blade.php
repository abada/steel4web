@extends('frontend.layouts.master')

@section('content')
{!! Breadcrumbs::render('Cadastros::obra',$obra->nome, $obra->id) !!}
    <h1>
       {{ $obra->nome }}
    </h1>
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
                             @include('frontend.cadastros.obras-perfil-inc')
                        </div>
                        <div class="tab-pane fade" id="etapas">
                        <br />
                             @include('frontend.cadastros.etapas-listar-inc')
                        </div>
                    </div>
                    </div>
                </div>
                <!-- /.panel-body -->
                 <div class="row">
        <div class="col-lg-6 col-md-6">
            <a style='float:left;margin:15px' href="javascript:history.back()" type="button" class="btn btn-primary"><< Voltar</a>
        </div>
        <div class="col-lg-6 col-md-6">
            <a href="{{ url('obra/editar/'.$obra->id) }}" alt="Editar obra" style='float:right;margin:15px' title="Editar obra" type="button" class="btn btn-primary">Editar</a>
        </div>
    </div>
            </div>
            <!-- /.panel -->

        </div>
        <!-- /.col-lg-6 -->

    </div>


   
@endsection

@section('scripts')
{!! Html::script('js/Ajax/funcoes.js') !!}
{!! Html::script('js/Ajax/tabel.js') !!}

@endsection