//[custom Javascript]
//Project:	Oreo - Responsive Bootstrap 4 Template
//Primary use:	Oreo - Responsive Bootstrap 4 Template
//should be included in all pages. It controls some layout

$(function() {
    "use strict";

    // Customized line Index page
    $('#linecustom1').sparkline('html',{
        height: '35px',
        width: '100%',
        lineColor: '#e5d1e4',
        fillColor: '#f3e8f2',
        minSpotColor: true,
        maxSpotColor: true,
        spotColor: '#e2a8df',
        spotRadius: 1
    });
    $('#linecustom2').sparkline('html',{
        height: '35px',
        width: '100%',
        lineColor: '#c9e3f4',
        fillColor: '#dfeefa',
        minSpotColor: true,
        maxSpotColor: true,
        spotColor: '#8dbfe0',
        spotRadius: 1
    });
    $('#linecustom3').sparkline('html',{
        height: '35px',
        width: '100%',
        lineColor: '#efded3',
        fillColor: '#f8f0ea',
        minSpotColor: true,
        maxSpotColor: true,
        spotColor: '#e0b89d',
        spotRadius: 1
    });
    $('#linecustom4').sparkline('html',{
        height: '35px',
        width: '100%',
        lineColor: '#a0d6be',
        fillColor: '#cde6db',
        minSpotColor: true,
        maxSpotColor: true,
        spotColor: '#e0b89d',
        spotRadius: 1
    });

    // 
    $('.knob').knob({
        draw: function() {
        }
    });

    setTimeout(function(){
        // Total Properties
        $(document).ready(function(){
            var chart = c3.generate({
                bindto: '#c3chart-properties', // id of chart wrapper
                data: {
                    columns: [
                        // each columns data
                        ['data1', 40],
                        ['data2', 10],
                        ['data3', 35],
                        ['data4', 15],
                    ],
                    type: 'donut', // default type of chart
                    labels: false,
                    colors: {
                        'data1': '#e96875',
                        'data2': '#ff9e47',
                        'data3': '#62bad9',
                        'data4': '#7e6990'
                    },
                    names: {
                        // name of each serie
                        'data1': 'Commercial',
                        'data2': 'Residential',
                        'data3': 'Purchased',
                        'data4': 'Rented',
                    }
                },
                axis: {
                },
                donut: {
                    label: {
                        show: false
                    }
                },
                legend: {
                    show: true, //hide legend
                    position: 'right'
                },
                padding: {
                    bottom: 0,
                    top: 0
                },
            });
        });
        // Graph this year
        $(document).ready(function(){
            var chart = c3.generate({
                bindto: '#chart-bar-rotated', // id of chart wrapper
                data: {
                    columns: [
                        // each columns data
                        ['data1', 112, 58, 215, 180, 195, 173],
                        ['data2', 70, 78, 59, 76, 92, 128]
                    ],
                    type: 'bar', // default type of chart
                    colors: {
                        'data1': '#7e6990',
                        'data2': '#ff9e47'
                    },
                    names: {
                        // name of each serie
                        'data1': 'Buying',
                        'data2': 'Selling'
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        // name of each category
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                    },
                    y: {
                        tick: {
                          format: d3.format('$,')
                        }
                    },
                    rotated: true,
                },
                bar: {
                    width: 16
                },
                legend: {
                    show: true, //hide legend
                },
                padding: {
                    bottom: 0,
                    top: 0
                },
            });
        });
        // Browser Usage
        $(document).ready(function(){
            var chart = c3.generate({
                bindto: '#c3chart-Browser-Usage', // id of chart wrapper
                data: {
                    columns: [
                        // each columns data
                        ['data1', 40],
                        ['data2', 10],
                        ['data3', 35],
                        ['data4', 15],
                    ],
                    type: 'donut', // default type of chart
                    colors: {
                        'data1': '#e96875',
                        'data2': '#ff9e47',
                        'data3': '#62bad9',
                        'data4': '#7e6990'
                    },
                    names: {
                        // name of each serie
                        'data1': 'Chrome',
                        'data2': 'Safari',
                        'data3': 'Firefox',
                        'data4': 'Edge',
                    }
                },
                axis: {
                },
                legend: {
                    show: true, //hide legend
                    position: 'bottom'
                },
                padding: {
                    bottom: 0,
                    top: 0
                },
            });
        });
    }, 100);

    // Visitors Statistics
    $('#world-map-markers').vectorMap({
        map: 'world_mill_en',
        normalizeFunction: 'polynomial',
        hoverOpacity: 0.7,
        hoverColor: false,
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: 'rgba(210, 214, 222, 1)',
                "fill-opacity": 1,
                stroke: 'none',
                "stroke-width": 0,
                "stroke-opacity": 1
            },
            hover: {
                fill: 'rgba(255, 193, 7, 2)',
                cursor: 'pointer'
            },
            selected: {
                fill: 'yellow'
            },
            selectedHover: {}
        },
        markerStyle: {
            initial: {
                fill: '#fff',
                stroke: '#FFC107 '
            }
        },
        markers: [{
                latLng: [37.09, -95.71],
                name: 'America'
            },
            {
                latLng: [51.16, 10.45],
                name: 'Germany'
            },
            {
                latLng: [-25.27, 133.77],
                name: 'Australia'
            },
            {
                latLng: [56.13, -106.34],
                name: 'Canada'
            },
            {
                latLng: [20.59, 78.96],
                name: 'India'
            },
            {
                latLng: [55.37, -3.43],
                name: 'United Kingdom'
            },
        ]
    });
});


//======
$(window).on('scroll',function() {
    $('.card .sparkline').each(function() {
        var imagePos = $(this).offset().top;

        var topOfWindow = $(window).scrollTop();
        if (imagePos < topOfWindow + 400) {
            $(this).addClass("pullUp");
        }
    });
});
