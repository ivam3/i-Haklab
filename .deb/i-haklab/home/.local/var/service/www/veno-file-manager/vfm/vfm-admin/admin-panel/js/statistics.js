var logvars = JSON.parse(LOGvars);

$(document).ready(function() {
    var table = $('#sortanalytics').DataTable({
        dom        : '<"table-controls-top"lp>rt<"table-controls-bottom"ip>',
        pagingType : 'full_numbers',
        order      : [[ 0, 'desc' ], [ 1, 'desc' ]], // Sort by first column descending
        pageLength : 25,
        lengthMenu : [[25, 50, 100, -1], [25, 50, 100, 'All']],

        language : {
            emptyTable     : '--',
            info           : '_START_-_END_ / _TOTAL_ ',
            infoEmpty      : '',
            infoFiltered   : '',
            infoPostFix    : '',
            lengthMenu     : ' _MENU_',
            loadingRecords : '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
            processing     : '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
            search         : '<div class="input-group-text"><i class="bi bi-search"></i></div> ',
            zeroRecords    : '--',
            paginate : {
                first    : '<i class="bi bi-chevron-double-left"></i>',
                last     : '<i class="bi bi-chevron-double-right"></i>',
                previous : '<i class="bi bi-chevron-left"></i>',
                next     : '<i class="bi bi-chevron-right"></i>'
            }
        },
        columnDefs : [ 
            { 
                targets : [ 0 ], 
                orderData: [ 0, 1 ]
            },
            { 
                targets : [ 1 ], 
                orderable  : false
            },
            { 
                targets : [ 2, 3, 4 ]
            },
            { 
                targets : [ 5 ], 
                type : 'natural'
            }
        ],
        initComplete: function () {
            this.api().columns([0, 1, 2, 3, 4]).every( function () {
                var column = this;
                var select = $('<select class="form-select"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    });
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' );
                });
            });

            this.api().columns([5]).every( function () {
                var column = this;
                var srcfield = $('<div class="input-group"><div class="input-group-text"><i class="bi bi-search"></i></div><input class="form-control" id="srcthiscol" type="text" placeholder="Search" /></div>')
                    .appendTo( $(column.footer()).empty() );
                $('#srcthiscol').on( 'keyup change', function () {
                        if ( column.search() !== this.value ) {
                            column
                                .search( this.value )
                                .draw();
                        }
                    } );
            });
            $('#sortanalytics_wrapper .table-controls-top').addClass('d-flex w-100 mb-3');
            $('#sortanalytics_wrapper .table-controls-bottom').addClass('d-flex w-100');
            $('#sortanalytics_wrapper .dataTables_paginate').addClass('ms-auto');
        }
    });
});


/*
 * Legend (chart.js)
 */
function legend(data) {

    var datas = data.datasets[0].data;
    var labels = data.labels;

    datas.forEach(function(value, index) {
        var fa;
        var color = data.datasets[0].backgroundColor[index];
        var label = labels[index];
        var container = $('<div class="list-group-item d-flex justify-content-between align-items-start"></div>');

        if (color == "#5cb85c") {
            fa = "bi-plus-lg";
        } else if (color == "#d9534f") {
            fa = "bi-trash";
        } else if (color == "#f0ad4e") {
            fa = "bi-play";
        } else if (color == "#5bc0de") {
            fa = "bi-download";
        }
        var boxcontent = '<div class="ms-2 me-auto" style="color: '+color+';"><i class="fa '+fa+'"></i> '+label+'</div><span class="badge rounded-pill" style="background-color: '+color+'; color: #fff">'+value+'</span>';
        container.append(boxcontent).hide();
        $("#mainLegend").append(container);
        container.fadeIn();
    });
}

/*
 * Chart.js init
 */
Chart.defaults.responsive = true;
Chart.defaults.tooltipFontSize = 12;
Chart.defaults.plugins.legend.display = false;

function callMainChart(){
    var ctx = document.getElementById("pie").getContext("2d");
    var myPieChart = new Chart(ctx,{
        type : 'pie',
        data : pieData
    });
    legend(pieData);
}

function callDownChart(){

    if ($("#polar-down").length) {
        var ctd = document.getElementById("polar-down").getContext("2d");
        var polarDown = new Chart(ctd,{
            type : 'polarArea',
            data : logvars.polardatadown,
            options : {
                animation:{
                    animateRotate : false,
                    animateScale : true
                },
                scale:{
                  stepSize: 1
                }
            }
        });
    }
}

function callPlayChart(){
    if ($("#polar-play").length) {
        var cty = document.getElementById("polar-play").getContext("2d");
        var polarPlay = new Chart(cty,{
            type : 'polarArea',
            data : logvars.polardataplay,
            options : {
                animation:{
                    animateRotate : false,
                    animateScale : true
                },
                scale:{
                  stepSize: 1
                }
            }
        });
    }
}
function callUpChart(){
    if ($("#polar-up").length) {
        var cty = document.getElementById("polar-up").getContext("2d");
        var polarPlay = new Chart(cty,{
            type : 'polarArea',
            data : logvars.polardataup,
            options : {
                animation:{
                    animateRotate : false,
                    animateScale : true
                },
                scale:{
                  stepSize: 1
                }
            }
        });
    }
}

function callRangeChart(){
    if ($("#ranger").length) {
        var ctr = document.getElementById("ranger").getContext("2d");
        var rangeChart = new Chart(ctr,{
            type : 'line',
            responsive: true,
            data : rangeline,
            options: {
                aspectRatio: false,
                plugins: {
                    legend : {
                        display: true
                    },
                    tooltips: {
                        mode: 'label',
                    }
                }
            }
        });
    }
}

var rangeline = {
    labels: logvars.datalabels,
    datasets: [
        {
            label: logvars.legendlabels.add,
            fill: true,
            tension: 0.4,
            backgroundColor: "rgba(92,184,92,0.1)",
            borderColor: "#5cb85c",
            pointBackgroundColor : "#fff",
            pointBorderWidth : 2,
            borderWidth : 3,
            pointRadius: 6,
            pointHitRadius: 10,
            data: logvars.uploads,
        },
        {
            label: logvars.legendlabels.download,
            fill: true,
            tension: 0.4,
            backgroundColor: "rgba(90,192,222,0.1)",
            borderColor: "#5bc0de",
            pointBackgroundColor : "#fff",
            pointBorderWidth : 2,
            borderWidth : 3,
            pointRadius: 6,
            pointHitRadius: 10,
            data: logvars.downloads,
        },
        {
            label: logvars.legendlabels.remove,
            fill: true,
            tension: 0.4,
            backgroundColor: "rgba(217,83,79,0.1)",
            borderColor: "#d9534f",
            pointBackgroundColor : "#fff",
            pointBorderWidth : 2,
            borderWidth : 3,
            pointRadius: 6,
            pointHitRadius: 10,
            data: logvars.removes,
        },
        {
            label: logvars.legendlabels.play,
            fill: true,
            tension: 0.4,
            backgroundColor: "rgba(240,173,78,0.1)",
            borderColor: "#f0ad4e",
            pointBackgroundColor : "#fff",
            pointBorderWidth : 2,
            borderWidth : 3,
            pointRadius: 6,
            pointHitRadius: 10,
            data: logvars.plays,
        }
    ]
};

var pieData = {
    labels: [
        logvars.legendlabels.add,
        logvars.legendlabels.download,
        logvars.legendlabels.remove,
        logvars.legendlabels.play
    ],
    datasets: [
        {
            data: [logvars.numup, logvars.numdown, logvars.numdel, logvars.numplay],
            borderColor: 'rgba(0,0,0,.125)',
            backgroundColor: [
                "#5cb85c",
                "#5bc0de",
                "#d9534f",
                "#f0ad4e"
            ],
            hoverBackgroundColor: [
                "#32b836",
                "#16b5de",
                "#d9211e",
                "#f09927"
            ]
    }]
};

    $(document).ready(function(){
        callMainChart();
        callRangeChart();
        callDownChart();
        callUpChart();
        callPlayChart();
    });

