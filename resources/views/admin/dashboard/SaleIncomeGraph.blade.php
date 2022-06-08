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
                    text: '<?=date('Y')?> Income & Sale Summary'
                },
                subtitle: {
                    text: 'Show monthly wise income & sale graph.'
                },
                xAxis: {
                    categories: ['January','February','March','April','May','June','July','August','September','October','November','December'],
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Amount & Sale',
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
                        name: 'Sale',
                        data: [
                            <?php
                                foreach ($months as $key => $month) {
                                    if(isset($monthWiseTotalSale[$key])) {
                                        echo "{y:".$monthWiseTotalSale[$key].", monthID:'".$key."', monthName:'".$month."', 'dayWiseData': '".json_encode($monthDayWiseTotalSale[$key])."', 'type': 'sale'},";
                                    } else {
                                        echo "{y:0, monthID:'".$key."', monthName:'".$month."', 'dayWiseData': '{\"01\":0}', 'type': 'sale'},";
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
                tooltipTitle = 'Sale';
                sidebarTitle = 'Sale';
            }

            $.ajax({
                type: 'POST',
                url: "<?=route('admin.dashboard.day-wise-income-sale')?>",
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

        "use strict";

        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January','February','March','April','May','June','July','August','September','October','November','December'],
                datasets: [{
                    label: 'Sales',
                    data:  [<?php
                        foreach ($months as $key => $month) {
                            if(isset($monthWiseTotalIncome[$key])) {
                                echo "$monthWiseTotalIncome[$key],";
                            }else{
                                echo "0.0,";
                            }
                        }
                        ?>
                    ],
                    borderWidth: 2,
                    backgroundColor: 'rgba(63,82,227,.8)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                },
                    {
                        label: 'Purchases',
                        data:  [<?php
                            foreach ($months as $key => $month) {
                                if(isset($monthWiseTotalPurchase[$key])) {
                                    echo "$monthWiseTotalPurchase[$key],";
                                }else{
                                    echo "0.0,";
                                }
                            }
                            ?>
                        ],
                        borderWidth: 2,
                        backgroundColor: 'rgba(254,86,83,.7)',
                        borderWidth: 0,
                        borderColor: 'transparent',
                        pointBorderWidth: 0 ,
                        pointRadius: 3.5,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
                    }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1500,
                            callback: function(value, index, values) {
                                return '$' + value;
                            }
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            tickMarkLength: 15,
                        }
                    }]
                },
            }
        });

        var balance_chart = document.getElementById("balance-chart").getContext('2d');

        var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var myChart = new Chart(balance_chart, {
            type: 'line',
            data: {
                labels: ['January','February','March','April','May','June','July','August','September','October','November','December'],
                datasets: [{
                    label: 'Amount',
                    data:  [<?php
                        foreach ($months as $key => $month) {
                            if(isset($monthWiseTotalPurchase[$key])) {
                                echo "$monthWiseTotalPurchase[$key],";
                            }else{
                                echo "0.0,";
                            }
                        }
                        ?>
                    ],
                    backgroundColor: balance_chart_bg_color,
                    borderWidth: 3,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1
                    }
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }]
                },
            }
        });

        var sales_chart = document.getElementById("sales-chart").getContext('2d');

        var sales_chart_bg_color = sales_chart.createLinearGradient(0, 0, 0, 80);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var myChart = new Chart(sales_chart, {
            type: 'line',
            data: {
                labels: ['January','February','March','April','May','June','July','August','September','October','November','December'],
                datasets: [{
                    label: 'Amount',
                    data:  [<?php
                        foreach ($months as $key => $month) {
                            if(isset($monthWiseTotalIncome[$key])) {
                                echo "$monthWiseTotalIncome[$key],";
                            }else{
                                echo "0.0,";
                            }
                        }
                        ?>
                    ],
                    borderWidth: 2,
                    backgroundColor: balance_chart_bg_color,
                    borderWidth: 3,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1
                    }
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }]
                },
            }
        });

        $("#products-carousel").owlCarousel({
            items: 3,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 5000,
            loop: true,
            responsive: {
                0: {
                    items: 2
                },
                768: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        });

    });
</script>
