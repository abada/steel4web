@extends('frontend.layouts.master')

@section('styles')
{{ Html::style('modules/'.Module::find('Gantt')->getLowerName().'/css/gantt.style.css') }}
@stop

@section('content')

<div class="box">
	<div class="box-header bg-padrao">
		<i class="fa fa-line-chart"></i>
		<h3 class="box-title">GANTT</h3>

		<div class="pull-right box-tools"></div>
	</div>
	<div class="box-body">
		<div id="ganttChartView"></div>
	</div>

</div>

@stop

@section('scripts')

{{ Html::script('modules/'.Module::find('Gantt')->getLowerName().'/js/DlhSoft.ProjectData.GanttChart.HTML.Controls.js') }}
{{ Html::script('modules/'.Module::find('Gantt')->getLowerName().'/js/DlhSoft.Data.HTML.Controls.js') }}
{{ Html::script('modules/'.Module::find('Gantt')->getLowerName().'/js/DlhSoft.ProjectData.GanttChart.HTML.Controls.Extras.js') }}
{{ Html::script('modules/'.Module::find('Gantt')->getLowerName().'/js/DlhSoft.HierarchicalData.HTML.Controls.js') }}
{{ Html::script('modules/'.Module::find('Gantt')->getLowerName().'/js/DlhSoft.ProjectData.PertChart.HTML.Controls.js') }}
{{ Html::script('modules/'.Module::find('Gantt')->getLowerName().'/js/gantt.script.js') }}

@stop