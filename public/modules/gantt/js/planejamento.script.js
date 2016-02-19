$(function() {
    var ganttChartView = document.querySelector("#ganttChartView");

    var obra1 = {
        content: "Obra 1",
        description: "Descrição da Obra 1"
    };
    var obra1etapa1 = {
        content: "Etapa 1",
        indentation: 1,
        start: new Date(2016, 2, 1),
        finish: new Date(2016, 2, 8),
    };
    var obra1etapa2 = {
        content: "Etapa 2",
        indentation: 1,
        start: new Date(2016, 2, 8),
        finish: new Date(2016, 2, 14),        
        predecessors: { item: obra1etapa1, dependencyType: "FS" }
    };

    var obra2 = {
        content: "Obra 2",        
        description: "Descrição da Obra 2"
    };
    var obra2etapa1 = {
        content: "Etapa 1",
        indentation: 1,
        start: new Date(2016, 2, 15),
        finish: new Date(2016, 2, 22),
    };
    var obra2etapa2 = {
        content: "Etapa 2",
        indentation: 1,
        start: new Date(2016, 2, 22),
        finish: new Date(2016, 2, 30),        
        predecessors: { item: obra1etapa1, dependencyType: "SF" }
    };


    var obras = [
        obra1,
        obra1etapa1,
        obra1etapa2,
        obra2,
        obra2etapa1,
        obra2etapa2
    ];


    var settings = { currentTime: new Date() };

    var columns = DlhSoft.Controls.GanttChartView.getDefaultColumns(obras, settings);

    columns[0].header = "Obras";
    // columns[0] = {header:"Obras", "width":170};
    columns[0].width = 170;
    columns[0].isSelection = false;
    columns[1].header = "Início";
    columns[2].header = "Término";
    // columns.push({
    //     header: "Descrição xxx",
    //     width: 200,
    //     cellTemplate: function(item) {
    //         return document.createTextNode(item.description);
    //     }
    // });
    settings.columns = columns;
    settings.theme = "Modern";
    settings.displayedTime = new Date('d-m-Y');
    settings.dateFormatter = function(a) {
        return a.toLocaleDateString();
    }
    settings.dateTimeFormatter = function(a) {
        return a.toLocaleDateString();
    }
    settings.daysOfWeek = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

    console.table(settings);

    // INITIALIZE
    DlhSoft.Controls.GanttChartView.initialize(ganttChartView, obras, settings);
});
