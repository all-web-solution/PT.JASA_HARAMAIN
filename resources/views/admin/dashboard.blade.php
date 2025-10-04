@extends('admin.master')
@section('content')<div class="container-fluid p-4">
                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stat h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-subtitle mb-1">Total Request</h6>
                                        <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">128</h3>
                                        <p class="card-text text-success mb-0"><small>+5% dari bulan lalu</small></p>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                                        <i class="bi bi-file-earmark-text fs-4" style="color: var(--haramain-secondary);"></i>
                                    </div>
                                </div>
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
                                        <p class="card-text text-danger mb-0"><small>3 overdue</small></p>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 p-3 rounded">
                                        <i class="bi bi-currency-dollar fs-4" style="color: #ff9800;"></i>
                                    </div>
                                </div>
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
                                        <p class="card-text text-success mb-0"><small>+12% dari bulan lalu</small></p>
                                    </div>
                                    <div class="bg-success bg-opacity-10 p-3 rounded">
                                        <i class="bi bi-people fs-4" style="color: #4caf50;"></i>
                                    </div>
                                </div>
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
                                        <p class="card-text text-success mb-0"><small>+8% dari bulan lalu</small></p>
                                    </div>
                                    <div class="bg-info bg-opacity-10 p-3 rounded">
                                        <i class="bi bi-graph-up fs-4" style="color: #00acc1;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Recent Activity -->
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="chart-container h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0" style="color: var(--haramain-primary);">
                                    <i class="bi bi-bar-chart-line me-2"></i>Monthly Performance
                                </h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" 
                                            style="background-color: var(--haramain-light); color: var(--haramain-primary); border: 1px solid rgba(0, 0, 0, 0.08);">
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
                            <div style="height: 300px; background: linear-gradient(45deg, #f5f7fa, #e8eff8); border-radius: 8px; 
                                        display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                                <div class="text-center">
                                    <i class="bi bi-bar-chart fs-1 mb-2"></i>
                                    <p>Monthly Performance Chart</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="chart-container h-100">
                            <h5 class="fw-bold mb-3" style="color: var(--haramain-primary);">
                                <i class="bi bi-pie-chart me-2"></i>Service Distribution
                            </h5>
                            <!-- Placeholder for Pie Chart -->
                            <div style="height: 300px; background: linear-gradient(45deg, #f5f7fa, #e8eff8); border-radius: 8px; 
                                        display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                                <div class="text-center">
                                    <i class="bi bi-pie-chart fs-1 mb-2"></i>
                                    <p>Service Distribution Chart</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Table -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 pb-0 pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-2" style="color: var(--haramain-primary);">
                                        <i class="bi bi-clock-history me-2"></i>Recent Activity
                                    </h5>
                                    <a href="#" class="btn btn-haramain btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i>New Order
                                    </a>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div class="table-responsive">
                                    <table class="table table-hover">
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
                                                <td>Group Al-Falah</td>
                                                <td>Umroh Plus</td>
                                                <td><span class="badge bg-warning text-dark">Processing</span></td>
                                                <td>12 Jun 2023</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold" style="color: var(--haramain-primary);">#UMR-2023-002</td>
                                                <td>Group Ar-Rahman</td>
                                                <td>Umroh Regular</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>5 Jun 2023</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold" style="color: var(--haramain-primary);">#UMR-2023-003</td>
                                                <td>Group An-Nur</td>
                                                <td>Umroh Plus</td>
                                                <td><span class="badge bg-info">Payment Pending</span></td>
                                                <td>1 Jun 2023</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> View
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