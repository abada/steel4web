@extends ('frontend.layouts.master')

@section ('title', trans('labels.backend.access.users.management'))



@section('content')
{!! Breadcrumbs::render('Users::obras') !!}
    <div class="box">
        <div class="box-header with-border bg-padrao">
            <h3 class="box-title">Selecione as obras que {{$user->name}} tera permissão de visualizar</h3>

           <div class="box-tools pull-right">
                @include('backend.access.includes.partials.header-buttons')
            </div> 
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" width='2%'><i class="fa fa-check-square-o"></i></th>
                        <th>Obra</th>

                    </tr>
                    </thead>
                    <tbody>
                    	{!! Form::open(['route' => 'admin.access.users.obrastore', 'role' => 'form', 'method' => 'post']) !!}
                        @foreach ($obras as $obra)
                            <tr>
                                <td class="text-center">
                                	
									<input type="checkbox" value="{{$obra->id}}" name="assignees_obras[]" id="obra-{{$obra->id}}" <?php if($obra->users->contains($user->id)) echo ' checked="checked"' ?> />    
									
                                </td>
                                <td>{!! $obra->nome !!}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
			
			<div class="pull-right">
				<input type="hidden" name='id' value='{{$user->id}}'>
                    <input type="submit" class="btn btn-primary" style='margin-right:10px' value="Atribuir Obras" />
                </div>
                {{ Form::close() }}

            <div class="pull-left">
                <a href="javascript:history.back()" style='margin-left:10px' class="btn btn-primary"><< Voltar</a>
            </div>


            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection
