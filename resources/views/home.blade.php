@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="{{ $settings1['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings1['total_number']) }}</div>
                                    <div>{{ $settings1['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings2['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings2['total_number']) }}</div>
                                    <div>{{ $settings2['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings3['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings3['total_number']) }}</div>
                                    <div>{{ $settings3['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        {{-- Widget - latest entries --}}
                        <div class=" col-12">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{DB::table('visits')->whereMonth('created_at', '=', now()->format('m'))->count()}}</div>
                                    <div>API Calls in {{now()->format('F')}}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                        <canvas id="myChart4" width="400" height="100"></canvas>
            {{--Data Sources--}}
    
          

<script>
var ctx = document.getElementById('myChart4');
var myChart4 = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [      
            @for ($i = 0; $i < 30; $i++)
            {{Carbon\Carbon::today()->subDays(30-$i)->format('d')}},
            @endfor
            {{Carbon\Carbon::today()->format('d')}},
            ],
        datasets: [{
            label: 'Daily API Calls',
            data:

             [
            @for ($i = 0; $i < 30; $i++)

    {{DB::table('visits')->whereDate('created_at', '=', now()->subDays(30-$i)->format('Y-m-d'))->count()}},
            @endfor
            {{DB::table('visits')->whereDate('created_at', '=', now()->format('Y-m-d'))->count()}},
             ],

 fill: false,
    borderColor: 'rgba(153, 102, 255, 1)',
    tension: 0.1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
@endsection