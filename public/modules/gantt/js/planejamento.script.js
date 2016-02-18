$(function() {
    var ganttChartView = document.querySelector("#ganttChartView");

    var obra1 = {
        content: "Obra 1",
        description: "Descrição da Obra 1"
    };
    var obra1etapa1 = {
        content: "Etapa 1",
        indentation: 1,
        start: new Date(2016, 3, 1, 8, 0, 0),
        finish: new Date(2016, 3, 7, 8, 0, 0),
    };
    var obra1etapa2 = {
        content: "Etapa 2",
        indentation: 1,
        start: new Date(2016, 3, 1, 8, 0, 0),
        finish: new Date(2016, 3, 7, 8, 0, 0),
        completedFinish: new Date(2016, 3, 12, 8, 0, 0),
        predecessors: { item: obra1etapa1, dependencyType: "FS" }
    };

    var obra2 = {
        content: "Obra 2",
        start: new Date(2016, 3, 8, 8, 0, 0),
        finish: new Date(2016, 3, 14, 8, 0, 0),
        description: "Descrição da Obra 2"
    };

    var obras = [obra1,
        obra1etapa1,
        obra1etapa2,
        obra2
    ];


    var settings = { currentTime: new Date() };

    var columns = DlhSoft.Controls.GanttChartView.getDefaultColumns(obras, settings);

    columns[0].header = "Obras";
    // columns[0] = {header:"Obras", "width":170};
    columns[0].width = 170;
    columns[0].isSelection = false;
    columns[1].header = "Inicio";
    columns[2].header = "Témino";
    // columns.push({
    //     header: "Descrição xxx",
    //     width: 200,
    //     cellTemplate: function(item) {
    //         return document.createTextNode(item.description);
    //     }
    // });
    settings.columns = columns;
    settings.theme = "Modern";
    settings.displayedTime = new Date(2012, 8, 1);

    console.log(columns);
    // INITIALIZE
    DlhSoft.Controls.GanttChartView.initialize(ganttChartView, obras, settings);
});