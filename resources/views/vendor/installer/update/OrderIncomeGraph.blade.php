<script type="application/javascript">
    $(function() {
        'use strict';
        LoadEarningMonthly();

        function LoadEarningMonthly() {
            'use strict';
            $( "#earning_top_right_graph_back_btn" ).hide();
            $('#earningGraph').highcharts({
                chart: {
                    type: 'areaspline'
                },
                title: {
                    text: '<?=date('Y')?> Income & Order Summary'
                },
                subtitle: {
                    text: 'Show monthly wise income & order graph.'
                },
                xAxis: {
                    categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
                    title: {
                        text: 'Month',
                        align: 'low'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Amount & Order',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function (e) {
                                    LoadDayWiseExpenseOrIncome(this.type, this.monthID, this.monthName, this.dayWiseData);
                                }
                            }
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    verticalAlign: 'top',
                    x: 5,
                    y: -10,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [
                    {
                        name: 'Income',
                        data: [
                            <?php
                                foreach ($months as $key => $month) {
                                    if(isset($monthWiseTotalIncome[$key])) {
                                        echo "{y:".$monthWiseTotalIncome[$key].", monthID:'".$key."', monthName:'".$month."', 'dayWiseData': '".json_encode($monthDayWiseTotalIncome[$key])."', 'type': 'income'},";
                                    } else {
                                        echo "{y:0, monthID:'".$key."', monthName:'".$month."', 'dayWiseData': '{\"01\":0}', 'type': 'income'},";
                                    }
                                }
                            ?>
                        ],
                        color: 'rgb(103,119,239)'
                    },
                    {
                        name: 'Order',
                        data: [
                            <?php
                                foreach ($months as $key => $month) {
                                    if(isset($monthWiseTotalOrder[$key])) {
                                        echo "{y:".$monthWiseTotalOrder[$key].", monthID:'".$key."', monthName:'".$month."', 'dayWiseData': '".json_encode($monthDayWiseTotalOrder[$key])."', 'type': 'order'},";
                                    } else {
                                        echo "{y:0, monthID:'".$key."', monthName:'".$month."', 'dayWiseData': '{\"01\":0}', 'type': 'order'},";
                                    }
                                }
                            ?>
                        ],
                        color: 'rgb(252,84,75)'
                    }
                ]
            });
        }

        function LoadDayWiseExpenseOrIncome(type, monthID, monthName, dayWiseData) {
          'use strict';
            $( '#earning_top_right_graph_title').html(monthName+" month "+type);
            $( "#earning_top_right_graph_back_btn" ).show().unbind( "click" ).on( "click",  function() {
                LoadEarningMonthly();
            });
            let categories = [];
            let series = [];
            let chartDayWiseData = [];
            let color = '#000';
            let tooltipTitle = '';
            let sidebarTitle = '';

            if(type === 'income') {
                color        = 'rgb(87,200,241)';
                tooltipTitle = 'Income';
                sidebarTitle = 'Amount';
            } else {
                color        = 'rgb(216,27,96)';
                tooltipTitle = 'Order';
                sidebarTitle = 'Order';
            }

            $.ajax({
                type: 'POST',
                url: "<?=route('admin.dashboard.daywise-income-order')?>",
                data: {"dayWiseData" : dayWiseData, 'type': type, 'monthID': monthID, 'monthName': monthName},
                dataType: "html",
                success: function(data) {
                    data = $.parseJSON(data);
                    $.each(data, function (i, value) {
                        categories.push('Day '+i);
                        chartDayWiseData.push(value);
                    });
                    $('#earningGraph').highcharts({
                        chart: {
                            type: 'areaspline',
                            events: {
                                drillup: function (e) {
                                }
                            }
                        },
                        title: {
                            text: monthName+" month "+type
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            categories: categories,
                            title: {
                                text: null
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: sidebarTitle,
                                align: 'high'
                            },
                            labels: {
                                overflow: 'justify'
                            }
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.y}</b>'
                        },
                        plotOptions: {
                            bar: {
                                dataLabels: {
                                    enabled: true
                                }
                            },
                            series: {
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function (e) {
                                        }
                                    }
                                }
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'left',
                            verticalAlign: 'top',
                            x: 0,
                            y: 0,
                            floating: true,
                            borderWidth: 1,
                            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                            shadow: true
                        },
                        credits: {
                            enabled: false
                        },
                        exporting: {
                            buttons: {
                                customButton: {
                                    x: -40,
                                    onclick: function () {
                                       LoadEarningMonthly();
                                    },
                                    text: "<< Back",
                                }
                            }
                        },
                        series: [{
                            name: tooltipTitle,
                            data: chartDayWiseData,
                            color: color
                        }]
                    });
                }
            });
        }
    });
</script>