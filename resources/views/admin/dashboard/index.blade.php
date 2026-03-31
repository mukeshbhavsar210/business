@extends('admin.layouts.app')

@section('content')
@include('admin.message')

    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-4">
            <div class="row">
                @include('admin.dashboard.total_revenue')
                @include('admin.dashboard.new_order')            
            </div>  
        </div> 
        <div class="col-md-12 col-lg-12 col-xl-8">
            @include('admin.dashboard.monthly_income')
        </div>           
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-8">
            @include('admin.dashboard.popular_products')
        </div>
        
        <div class="col-md-6 col-lg-4">
            @include('admin.dashboard.customers')
        </div>                              
    </div>

    <div class="row justify-content-center">
        @include('admin.dashboard.categories_data')
        @include('admin.dashboard.recent_order')                                
    </div>

@endsection

@section('customJs')
    <script>
        $(document).ready(function(){
            loadDashboard('year'); // default load
        });

        function loadDashboard(filter = 'year'){
            $.get("{{ route('admin.dashboard.stats') }}", {filter: filter}, function(res){

                let chartHeight = 200;
                let html = '';

                let labels = res.data;
                let growthData = res.growth;

                let values = Object.values(labels);

                let maxValue = Math.max(...values, 1000);
                maxValue = Math.ceil(maxValue / 5000) * 5000;

                // Y Axis
                let steps = 5;
                let stepValue = maxValue / steps;

                let yHtml = '';
                for(let i=steps; i>=0; i--){
                    yHtml += `<span>${Math.round((stepValue*i)/1000)}k</span>`;
                }
                $(".y-axis").html(yHtml);

                let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

                let index = 0;

                Object.keys(labels).forEach(function(label){
                    let total = labels[label];
                    let growth = growthData[label] ?? 0;
                    let height = (total / maxValue) * chartHeight;
                    let displayLabel = label;

                    if(res.filter == 'year'){
                        displayLabel = months[index];
                        index++;
                    }

                    if(res.filter == 'today'){
                        displayLabel = label + ':00';
                    }

                    html += `
                            <div class="col">
                                <div class="months">${displayLabel}</div>
                                <div class="${growth >= 0 ? 'text-dark' : 'text-danger'}">${growth}%</div>
                                <div class="bar ${total > 10000 ? 'bg-success active' : 'bg-secondary'}" style="height:${height}px;"></div>
                            </div>
                        `;
                });

                $("#chartContainer").html(html);
            });
        }

        $('#orderFilter').on('change', function(){            
            let filter = $(this).val();

            $.ajax({
                url: '{{ route("admin.recentOrders") }}',
                type: 'GET',
                data: { filter: filter },
                success: function(response){
                    $('#recentOrdersContainer').html(response.html);
                }
            });
        });
    </script>
@endsection