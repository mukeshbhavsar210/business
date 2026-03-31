<div class="col-md-12 col-lg-6 col-xl-12">
    <div class="card">
        <div class="card-body border-dashed-bottom pb-3">
            <div class="row d-flex justify-content-between">
                <div class="col-auto">
                    <div class="d-flex justify-content-center align-items-center thumb-xl border border-secondary rounded-circle">
                        <i class="icofont-money-bag h1 align-self-center mb-0 text-secondary"></i>
                    </div> 
                    <h5 class="mt-2 mb-0 fs-14">Total Revenue</h5>
                </div>
                <div class="col align-self-center">                     
                     
                </div>
            </div>
        </div>
        <div class="card-body"> 
            <div class="row d-flex justify-content-center ">
                <div class="col-12 col-md-6">
                    <h2 class="fs-22 mt-0 mb-1 fw-bold">₹{{ number_format($totalRevenue, 2) }}</h2>
                    <p class="mb-0 text-truncate text-muted {{ $percentageChange >= 0 ? 'text-success' : 'text-danger' }}">
                        <span class="text-success">
                            <i class="mdi mdi-trending-up"></i>{{ $percentageChange >= 0 ? '+' : '' }}{{ number_format($percentageChange, 1) }}%
                        </span> 
                        New Sessions Today
                    </p>
                </div>
                <div class="col-12 col-md-6 align-self-center text-start text-md-end">
                    <button type="button" class="btn btn-primary btn-sm px-2 mt-2 mt-md-0 ">View Report</button>  
                </div>
            </div>  
        </div> 
    </div>
</div>