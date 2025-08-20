@extends('admin.master')
@section('content')
    

<div class="container-fluid p-3">
                <!-- Stats Cards -->
                <div class="row g-3 mb-3">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stat h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-subtitle mb-1">Total Request</h6>
                                        <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">128</h3>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 p-2 rounded">
                                        <i class="bi bi-file-earmark-text" style="color: var(--haramain-secondary);"></i>
                                    </div>
                                </div>
                                <p class="card-text text-success mt-1"><small>+5% dari bulan lalu</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stat h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-subtitle mb-1">Pending Payment</h6>
                                        <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">24</h3>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 p-2 rounded">
                                        <i class="bi bi-currency-dollar" style="color: #ff9800;"></i>
                                    </div>
                                </div>
                                <p class="card-text text-danger mt-1"><small>3 overdue</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stat h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-subtitle mb-1">Jamaah Bulan Ini</h6>
                                        <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">156</h3>
                                    </div>
                                    <div class="bg-success bg-opacity-10 p-2 rounded">
                                        <i class="bi bi-people" style="color: #4caf50;"></i>
                                    </div>
                                </div>
                                <p class="card-text text-success mt-1"><small>+12% dari bulan lalu</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stat h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-subtitle mb-1">Revenue</h6>
                                        <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">Rp 1.2M</h3>
                                    </div>
                                    <div class="bg-info bg-opacity-10 p-2 rounded">
                                        <i class="bi bi-graph-up" style="color: #00acc1;"></i>
                                    </div>
                                </div>
                                <p class="card-text text-success mt-1"><small>+8% dari bulan lalu</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Recent Activity -->
                <div class="row g-3">
                    <div class="col-lg-12">
                        <div class="chart-container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0" style="color: var(--haramain-primary);">
                                    <i class="bi bi-bar-chart-line me-2"></i>Monthly Performance
                                </h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" 
                                            style="background-color: var(--haramain-light); color: var(--haramain-primary); border: 1px solid rgba(0, 0, 0, 0.08); font-size: 0.75rem;">
                                        This Year
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                        <li><a class="dropdown-item" href="#">Last Year</a></li>
                                        <li><a class="dropdown-item" href="#">Custom Range</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Placeholder for Chart -->
                            <div style="height: 280px; background-color: #f5f7fa; border-radius: 6px; 
                                        display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.8125rem;">
                                [Chart Area - Monthly Performance]
                            </div>
                        </div>
                    </div>
                    
                   
                </div>

                <!-- Recent Activity Table -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-2" style="color: var(--haramain-primary);">
                                        <i class="bi bi-clock-history me-2"></i>Recent Activity
                                    </h5>
                                    <a href="#" class="text-decoration-none" style="color: var(--haramain-secondary); font-size: 0.8125rem;">View All</a>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div class="table-responsive">
                                    <table class="table table-hover table-haramain">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer</th>
                                                <th>Service</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="color: var(--haramain-primary);">#UMR-2023-001</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2" style="width: 28px; height: 28px; background-color: #e3f2fd; border-radius: 50%; 
                                                                               display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-person" style="color: var(--haramain-secondary); font-size: 0.75rem;"></i>
                                                        </div>
                                                        <span>Group Al-Falah</span>
                                                    </div>
                                                </td>
                                                <td>Umroh Plus</td>
                                                <td><span class="badge badge-processing">Processing</span></td>
                                                <td>12 Jun 2023</td>
                                                <td>
                                                    <button class="btn btn-sm" style="background-color: var(--haramain-light); color: var(--haramain-primary); padding: 0.25rem 0.5rem;">
                                                        <i class="bi bi-eye" style="font-size: 0.8125rem;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold" style="color: var(--haramain-primary);">#UMR-2023-002</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2" style="width: 28px; height: 28px; background-color: #e3f2fd; border-radius: 50%; 
                                                                               display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-person" style="color: var(--haramain-secondary); font-size: 0.75rem;"></i>
                                                        </div>
                                                        <span>Group Ar-Rahman</span>
                                                    </div>
                                                </td>
                                                <td>Umroh Regular</td>
                                                <td><span class="badge badge-completed">Completed</span></td>
                                                <td>5 Jun 2023</td>
                                                <td>
                                                    <button class="btn btn-sm" style="background-color: var(--haramain-light); color: var(--haramain-primary); padding: 0.25rem 0.5rem;">
                                                        <i class="bi bi-eye" style="font-size: 0.8125rem;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold" style="color: var(--haramain-primary);">#UMR-2023-003</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2" style="width: 28px; height: 28px; background-color: #e3f2fd; border-radius: 50%; 
                                                                               display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-person" style="color: var(--haramain-secondary); font-size: 0.75rem;"></i>
                                                        </div>
                                                        <span>Group An-Nur</span>
                                                    </div>
                                                </td>
                                                <td>Umroh Plus</td>
                                                <td><span class="badge badge-pending">Payment Pending</span></td>
                                                <td>1 Jun 2023</td>
                                                <td>
                                                    <button class="btn btn-sm" style="background-color: var(--haramain-light); color: var(--haramain-primary); padding: 0.25rem 0.5rem;">
                                                        <i class="bi bi-eye" style="font-size: 0.8125rem;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection