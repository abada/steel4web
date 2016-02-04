@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-padrao">
                <div class="panel-heading">{{ trans('labels.frontend.user.profile.update_information') }}</div>

                <div class="panel-body">
                    <div class="col-md-6">
                        {!! Form::model($user, ['route' => 'frontend.user.profile.update', 'class' => 'form-horizontal', 'method' => 'PATCH']) !!}
                            
                            <div class="form-group">

                                {!! Form::label('name', trans('validation.attributes.frontend.name'), ['class' => 'control-label']) !!}
                                {!! Form::input('text', 'name', null, ['class' => 'form-control col-md-6', 'placeholder' => trans('validation.attributes.frontend.name')]) !!}
                            </div>

                            @if ($user->canChangeEmail())
                                <div class="form-group">
                                    {!! Form::label('email', trans('validation.attributes.frontend.email'), ['class' => 'control-label']) !!}
                                    {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.email')]) !!}
                                </div>
                            @endif
                            
                            <div class="form-group">

                                {!! Form::label('image', 'Imagem de Exibição', ['class' => 'control-label']) !!}
                                {!! Form::input('file', 'image', null, ['class' => 'form-control col-md-6']) !!}
                            </div>

                            <div class="form-group">
                                
                                    {!! Form::submit(trans('labels.general.buttons.save'), ['class' => 'btn btn-primary']) !!}
                              
                            </div>

                        {!! Form::close() !!}
                     </div>
                </div><!--panel body-->

            </div><!-- panel -->
            <div class="pull-left">
                <a href="javascript:history.back()" style='margin-left:10px' class="btn btn-primary"><< Voltar</a>
            </div>
        </div><!-- col-md-10 -->

    </div><!-- row -->
@endsection