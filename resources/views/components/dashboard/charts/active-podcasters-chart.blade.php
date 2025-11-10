@props(['list'])

<div class="card">
    <div class="card-header border-bottom-0">
        <h3>{{ __('label.most_active_podcasters') }}</h3>
    </div>
    <div class="card-body">
        <div id="active_podcasters_chart" class="chart"></div>
    </div>
</div>


@push('js')
    <script>
        const podcastersData = @json($list);

        var chartData = podcastersData.map(podcaster => ({
            podcasts: podcaster.podcasts,
            likes: podcaster.likes,
            views: podcaster.views,
            user_img: podcaster.user_img
        }));


        const richTextStyles = podcastersData.reduce((styles, item, index) => {
            styles[`imageStyle${index}`] = {
                width: 40,
                height: 40,
                align: 'center',
                borderRadius: 20,
                backgroundColor: {
                    image: item.user_img
                }
            };
            return styles;
        }, {});


        // Option configuration similar to chart2
        var option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                },
                textStyle: {
                    fontFamily: 'Bahij_Plain'
                }
            },
            legend: {
                textStyle: {
                    fontSize: 14,
                    fontFamily: 'Bahij_Plain'
                }
            },
            grid: {
                top: "9%",
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                axisLabel: {
                    formatter: function(value, index) {
                        return `{imageStyle${index}|}`;
                    },
                    rich: richTextStyles,
                    textStyle: {
                        fontSize: 14,
                        fontFamily: 'Bahij_Plain'
                    }
                }
            }],
            yAxis: [{
                type: 'value'
            }],
            series: [{
                    name: "{{ __('label.podcasts') }}",
                    type: 'bar',
                    emphasis: {
                        focus: 'series'
                    },
                    data: chartData.map(data => data.podcasts), // Podcast counts
                    color: '#8E44AD'
                },
                {
                    name: "{{ __('label.views') }}",
                    type: 'bar',
                    emphasis: {
                        focus: 'series'
                    },
                    data: chartData.map(data => data.views), // Total views
                    color: '#3498DB'
                },
                {
                    name: "{{ __('label.likes') }}",
                    type: 'bar',
                    emphasis: {
                        focus: 'series'
                    },
                    data: chartData.map(data => data.likes), // Total likes
                    color: '#2ECC71'
                }
            ]
        };

        echarts.init(document.getElementById('active_podcasters_chart')).setOption(option);
    </script>
@endpush
