	var ganttChartView = document.querySelector("#ganttChartView");

	var obra1 = {
	    content: "Obra 1",
	    description: "Descrição da Obra 1"
	};
	var obra1e1 = {
	    content: "Etapa 1",
	    indentation: 1,
	    start: new Date(2016, 3, 1, 8, 0, 0),
	    finish: new Date(2016, 3, 7, 8, 0, 0),
	    completedFinish: new Date(2016, 3, 12, 8, 0, 0)	    
	};

	var obra2 = {
	    content: "Obra 2",
	    description: "Descrição da Obra 2"
	};

	var item1 = { content: "Obra Death Star", description: "Descrição da Obra" };
	var item2 = {
	    content: "Etapa 1",
	    indentation: 1,
	    start: new Date(2016, 2, 14, 8, 0, 0),
	    finish: new Date(2016, 3, 14, 8, 0, 0),
	    completedFinish: new Date(2016, 3, 12, 8, 0, 0),
	    assignmentsContent: "Meu Recurso"
	};
	var items = [item1, item2];
	var item3 = {
	    content: "Etapa 2",
	    indentation: 1,
	    isMilestone: true
	};

	var obra2 = { content: "Obra 2" };
	var obra2etapa1 = {
	    content: "Etapa 1",
	    indentation: 1,
	    start: new Date(2016, 1, 14, 8, 0, 0),
	    finish: new Date(2016, 2, 13, 16, 0, 0),
	    completedFinish: new Date(2016, 2, 12, 12, 30, 0),
	    assignmentsContent: "Recurso A"
	};
	var obra2etapa1subetapa1 = { content: "Subetapa 1", indentation: 2, start: new Date(2016, 2, 13, 16, 0, 0), finish: new Date(2016, 2, 23, 16, 0, 0), assignmentsContent: "Recurso C" };
	var obra2etapa1subetapa2 = { content: "Subetapa 2", indentation: 2, start: new Date(2016, 2, 23, 16, 0, 0), finish: new Date(2016, 2, 28, 16, 0, 0), assignmentsContent: "Recurso C" };

	var obra2etapa2 = {
	    content: "Etapa 2",
	    indentation: 1,
	    start: new Date(2016, 2, 13, 16, 0, 0),
	    finish: new Date(2016, 2, 20, 12, 0, 0),
	    assignmentsContent: "Recurso B"
	};

	items.push(item3);
	items.push(obra2);
	items.push(obra2etapa1);
	items.push(obra2etapa1subetapa1);
	items.push(obra2etapa1subetapa2);
	items.push(obra2etapa2);


	item3.predecessors = [{ item: item2, dependencyType: "FS" }];

	obra2etapa2.predecessors = [{ item: obra2etapa1, dependencyType: "FS" }];


	var settings = { currentTime: new Date(2016, 1, 1, 10, 30, 0) };

	var columns = DlhSoft.Controls.GanttChartView.getDefaultColumns(items, settings);
	columns[0].header = "Obras";
	columns[0].width = 170;
	columns[1].header = "Inicio";
	columns[2].header = "Fim";
	columns.push({ header: "Descrição xxx", width: 200, cellTemplate: function(item) {
	        return document.createTextNode(item.description); } });
	settings.columns = columns;

	// INITIALIZE
	DlhSoft.Controls.GanttChartView.initialize(ganttChartView, items, settings);
