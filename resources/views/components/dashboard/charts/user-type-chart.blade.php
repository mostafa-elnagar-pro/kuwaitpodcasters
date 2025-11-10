@props(['podcasters', 'users'])

<div class="card">
    <div class="card-header border-bottom-0">
        <h3>{{ __('label.user_type_proportion') }}</h3>
    </div>
    <div class="card-body">
        <div id="user_type_chart" class="chart"></div>
    </div>
</div>

@push('js')
    <script>
        var userCount = @json($users);
        var podcastersCount = @json($podcasters);

        echarts.init(document.getElementById('user_type_chart')).setOption({
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
                data: [{
                        value: userCount,
                        name: "{{ __('label.user') }}"
                    },
                    {
                        value: podcastersCount,
                        name: "{{ __('label.podcasters') }}"
                    }
                ],
                color: ['#4169E1', '#4CAF50']
            }],
        });
    </script>
@endpush
