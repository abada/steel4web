@extends ('frontend.layouts.master')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.create'))



@section('content')
{!! Breadcrumbs::render('Users::create') !!}
    {!! Form::open(['route' => 'admin.access.users.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="box">
            <div class="box-header with-border bg-padrao">
                <h3 class="box-title">{{ trans('labels.backend.access.users.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.access.includes.partials.header-buttons')
                </div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('name', trans('validation.attributes.backend.access.users.name'), ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.name')]) !!}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {!! Form::label('email', trans('validation.attributes.backend.access.users.email'), ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.email')]) !!}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {!! Form::label('password', trans('validation.attributes.backend.access.users.password'), ['class' => 'col-lg-2 control-label', 'placeholder' => trans('validation.attributes.backend.access.users.password')]) !!}
                    <div class="col-lg-10">
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    {!! Form::label('password_confirmation', trans('validation.attributes.backend.access.users.password_confirmation'), ['class' => 'col-lg-2 control-label', 'placeholder' => trans('validation.attributes.backend.access.users.password_confirmation')]) !!}
                    <div class="col-lg-10">
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    <label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.users.active') }}</label>
                    <div class="col-lg-1">
                        <input type="checkbox" value="1" name="status" checked="checked" />
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    <label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.users.confirmed') }}</label>
                    <div class="col-lg-1">
                        <input type="checkbox" value="1" name="confirmed" checked="checked" />
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    <label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.users.send_confirmation_email') }}<br/>
                        <small>{{ trans('strings.backend.access.users.if_confirmed_off') }}</small>
                    </label>
                    <div class="col-lg-1">
                        <input type="checkbox" value="1" name="confirmation_email" />
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    <label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.users.associated_roles') }}</label>
                    <div class="col-lg-3">
                        @if (count($roles) > 0)
                            @foreach($roles as $role)
                                <input type="checkbox" value="{{$role->id}}" name="assignees_roles[]" id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{!! $role->name !!}</label> <a href="#" data-role="role_{{$role->id}}" class="show-permissions small">(<span class="show-hide">{{ trans('labels.general.show') }}</span> {{ trans('labels.backend.access.users.permissions') }})</a><br/>

                                <div class="permission-list hidden" data-role="role_{{$role->id}}">
                                    @if ($role->all)
                                        {{ trans('labels.backend.access.users.all_permissions') }}<br/><br/>
                                    @else
                                        @if (count($role->permissions) > 0)
                                            <blockquote class="small">{{--
                                        --}}@foreach ($role->permissions as $perm){{--
                                            --}}{{$perm->display_name}}<br/>
                                                @endforeach
                                            </blockquote>
                                        @else
                                            {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                                        @endif
                                    @endif
                                </div><!--permission list-->
                            @endforeach
                        @else
                            {{ trans('labels.backend.access.users.no_roles') }}
                        @endif
                    </div>
                </div><!--form control-->

                <div class="form-group">
                    <input type="hidden" name='locatario_id' value='{{access()->user()->locatario_id}}'>
                    <label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.users.other_permissions') }}</label>
                    <div class="col-lg-10">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> {{ '&nbsp;Permissões adicionais serão somadas as previamentes conferidas pelos Papéis Associados ao Usuário.' }}
                        </div><!--alert-->

                        @if (count($permissions))
                            @foreach (array_chunk($permissions->toArray(), 10) as $perm)
                                <div class="col-lg-3">
                                    <ul style="margin:0;padding:0;list-style:none;">
                                        @foreach ($perm as $p)

                                            <?php
                                            //Since we are using array format to nicely display the permissions in rows
                                            //we will just manually create an array of dependencies since we do not have
                                            //access to the relationship to use the lists() function of eloquent
                                            //but the relationships are eager loaded in array format now
                                            $dependencies = [];
                                            $dependency_list = [];
                                            if (count($p['dependencies'])) {
                                                foreach ($p['dependencies'] as $dependency) {
                                                    array_push($dependencies, $dependency['dependency_id']);
                                                    array_push($dependency_list, $dependency['permission']['display_name']);
                                                }
                                            }
                                            $dependencies = json_encode($dependencies);
                                            $dependency_list = implode(", ", $dependency_list);
                                            ?>

                                            <li><input type="checkbox" value="{{$p['id']}}" name="permission_user[]" data-dependencies="{!! $dependencies !!}" id="permission-{{$p['id']}}"> <label for="permission-{{$p['id']}}" />

                                                @if ($p['dependencies'])
                                                    <a style="color:black;text-decoration:none;" data-toggle="tooltip" data-html="true" title="<strong>{{ trans('labels.backend.access.users.dependencies') }}:</strong> {!! $dependency_list !!}">{!! $p['display_name'] !!} <small><strong>(D)</strong></small></a>
                                                @else
                                                    {!! $p['display_name'] !!}
                                                    @endif

                                                    </label></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @else
                            {{ trans('labels.backend.access.users.no_other_permissions') }}
                        @endif
                    </div><!--col 3-->
                </div><!--form control-->
                 <div class="pull-left">
                    <a href="{{route('admin.access.users.index')}}" style='margin-left:10px' class="btn btn-primary"><< Voltar</a>
                </div>

                <div class="pull-right">
                    <input type="submit" class="btn btn-primary" style='margin-right:10px' value="Criar Usuário" />
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->

               
                <div class="clearfix"></div>

    {!! Form::close() !!}
@endsection

@section('scripts')
    {!! Html::script('js/user/script.js') !!}
@stop