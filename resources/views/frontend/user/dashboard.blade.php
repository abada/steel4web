@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-12">

           <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-black" style="background: url({{ asset('img/capa.jpg')}}) center no-repeat;background-size: cover">
                  <h3 class="widget-user-username"><span  style=' background-color:rgba(0,0,0,0.6);padding:10px'>{{access()->user()->locatario->razao}}</span></h3>
                  <h5 class="widget-user-desc" style='margin-top:19.5px'>
                    @if(!empty(access()->user()->locatario->fantasia))
                    <span  style=' background-color:rgba(0,0,0,0.4);padding:5px'>{{access()->user()->locatario->fantasia}}</span>
                    @endif
                </h5>
                </div>
                <div class="widget-user-image">
                  <img class="img-circle" src="{{ asset('img/1234.jpg') }}" alt="User Avatar">
                </div>
                <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header">Membro Desde</h5>
                        <span class="description-text">{!! date('d/m/Y',strtotime($user->created_at)) !!}</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header" style='font-size:18px !important;padding-bottom:5px'>{!! $user->name !!}</h5>
                        <span class="description-text">{{access()->user()->roles->first()->name}}</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">
                        <h5 class="description-header">Email</h5>
                    <span>{!! $user->email !!}</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>
                <hr>
                <div class="box-body">

                    <a href="{!! route('frontend.user.perfil.editar') !!}" class="btn btn-primary">{{ trans('labels.frontend.user.profile.edit_information') }}</a>

                    @if ($user->canChangePassword())
                        <a href="{!! route('auth.password.change') !!}" style='float:right' class="btn btn-primary">{{ trans('navs.frontend.user.change_password') }}</a>
                    @endif

                </div>
              </div><!-- /.widget-user -->

        </div><!-- col-md-10 -->
    <div class="pull-left">
                <a href="javascript:history.back()" style='margin-left:10px' class="btn btn-primary"><< Voltar</a>
            </div>
    </div><!-- row -->
@endsection




