@props(['videos', 'audios'])

<div class="card">
    <div class="card-header border-bottom-0">
        <h3>{{ __('label.content_type_proportion') }}</h3>
    </div>
    <div class="card-body">
        <div id="content_type_chart" class="chart"></div>
    </div>
</div>

@push('js')
    <script>
        // Pass PHP variables to JavaScript
        var videosCount = @json($videos);
        var audiosCount = @json($audios);

        var chartData = [{
                value: videosCount,
                name: "{{ __('label.videos') }}"
            },
            {
                value: audiosCount,
                name: "{{ __('label.audios') }}"
            }
        ];

        var option = {
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b}: {c} ({d}%)',
                textStyle: {
                    fontFamily: 'Bahij_Plain'
                }
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                textStyle: {
                    fontFamily: 'Bahij_Plain'
                }
            },
            series: [{
                name: '',
                type: 'pie',
                radius: ['0%', '100%'], // Full circle radius for pie chart
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                labelLine: {
                    show: false
                },
                data: chartData,
                color: ['#FF6384', '#FFCE56']
            }],
        };

        echarts.init(document.getElementById('content_type_chart')).setOption(option);
    </script>
@endpush
