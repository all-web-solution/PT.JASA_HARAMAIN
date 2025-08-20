@extends('admin.master')
@section('content')
<style>
    :root {
        --haramain-primary: #1a4b8c;
        --haramain-secondary: #2a6fdb;
        --haramain-light: #e6f0fa;
        --haramain-accent: #3d8bfd;
        --text-primary: #2d3748;
        --text-secondary: #4a5568;
        --border-color: #d1e0f5;
        --hover-bg: #f0f7ff;
        --checked-color: #2a6fdb;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
    }
    
    .service-create-container {
        max-width: 100vw;
        margin: 0 auto;
        padding: 2rem;
        background-color: #f8fafd;
    }
    
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .card-title {
        font-weight: 700;
        color: var(--haramain-primary);
        margin: 0;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .card-title i {
        font-size: 1.5rem;
        color: var(--haramain-secondary);
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Form Styles */
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .form-section-title {
        font-size: 1.1rem;
        color: var(--haramain-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-section-title i {
        color: var(--haramain-secondary);
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--haramain-secondary);
        box-shadow: 0 0 0 3px rgba(42, 111, 219, 0.1);
    }
    
    .form-text {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }
    
    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .form-col {
        flex: 1;
    }
    
    /* Service Selection */
    .service-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .service-item {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: white;
    }
    
    .service-item:hover {
        border-color: var(--haramain-secondary);
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .service-item.selected {
        border-color: var(--haramain-secondary);
        background-color: var(--haramain-light);
    }
    
    .service-icon {
        font-size: 2rem;
        color: var(--haramain-secondary);
        margin-bottom: 0.75rem;
    }
    
    .service-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    
    .service-desc {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    
    /* Detail Form */
    .detail-form {
        background-color: var(--haramain-light);
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .detail-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .detail-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .detail-title {
        font-weight: 600;
        color: var(--haramain-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .detail-title i {
        color: var(--haramain-secondary);
    }
    
    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary {
        background-color: var(--haramain-secondary);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: var(--haramain-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(26, 75, 140, 0.3);
    }
    
    .btn-secondary {
        background-color: white;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }
    
    .btn-secondary:hover {
        background-color: #f8f9fa;
    }
    
    .btn-submit {
        background-color: var(--success-color);
        color: white;
    }
    
    .btn-submit:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .service-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="service-create-container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-plus-circle"></i>Tambah Permintaan Service Baru
            </h5>
            <a href="{{ route('admin.services') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                
                <!-- Data Travel Section -->
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-building"></i> Data Travel
                    </h6>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Nama Travel</label>
                                <input type="text" class="form-control" name="travel_name" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Penanggung Jawab</label>
                                <input type="text" class="form-control" name="contact_person" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Telepon</label>
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Tanggal Keberangkatan</label>
                                <input type="date" class="form-control" name="departure_date" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Tanggal Kepulangan</label>
                                <input type="date" class="form-control" name="return_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Jumlah Jamaah</label>
                        <input type="number" class="form-control" name="total_pax" min="1" required>
                    </div>
                </div>
                
                <!-- Pilih Layanan Section -->
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-list-check"></i> Pilih Layanan yang Dibutuhkan
                    </h6>
                    
                    <div class="service-grid">
                        <div class="service-item selected" data-service="transportasi">
                            <div class="service-icon">
                                <i class="bi bi-airplane"></i>
                            </div>
                            <div class="service-name">Transportasi</div>
                            <div class="service-desc">Tiket & Transport</div>
                            <input type="checkbox" name="services[]" value="transportasi" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="hotel">
                            <div class="service-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="service-name">Hotel</div>
                            <div class="service-desc">Akomodasi</div>
                            <input type="checkbox" name="services[]" value="hotel" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="dokumen">
                            <div class="service-icon">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="service-name">Dokumen</div>
                            <div class="service-desc">Visa & Administrasi</div>
                            <input type="checkbox" name="services[]" value="dokumen" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="handling">
                            <div class="service-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <div class="service-name">Handling</div>
                            <div class="service-desc">Bandara & Hotel</div>
                            <input type="checkbox" name="services[]" value="handling" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="pendamping">
                            <div class="service-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="service-name">Pendamping</div>
                            <div class="service-desc">Tour Leader & Mutawwif</div>
                            <input type="checkbox" name="services[]" value="pendamping" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="konten">
                            <div class="service-icon">
                                <i class="bi bi-camera"></i>
                            </div>
                            <div class="service-name">Konten</div>
                            <div class="service-desc">Dokumentasi</div>
                            <input type="checkbox" name="services[]" value="konten" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="reyal">
                            <div class="service-icon">
                                <i class="bi bi-currency-exchange"></i>
                            </div>
                            <div class="service-name">Reyal</div>
                            <div class="service-desc">Penukaran Mata Uang</div>
                            <input type="checkbox" name="services[]" value="reyal" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="tour">
                            <div class="service-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="service-name">Tour</div>
                            <div class="service-desc">City Tour & Ziarah</div>
                            <input type="checkbox" name="services[]" value="tour" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="meals">
                            <div class="service-icon">
                                <i class="bi bi-egg-fried"></i>
                            </div>
                            <div class="service-name">Meals</div>
                            <div class="service-desc">Makanan</div>
                            <input type="checkbox" name="services[]" value="meals" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="katering">
                            <div class="service-icon">
                                <i class="bi bi-basket"></i>
                            </div>
                            <div class="service-name">Katering</div>
                            <div class="service-desc">Katering Box</div>
                            <input type="checkbox" name="services[]" value="katering" checked hidden>
                        </div>
                        
                        <div class="service-item selected" data-service="waqaf">
                            <div class="service-icon">
                                <i class="bi bi-gift"></i>
                            </div>
                            <div class="service-name">Waqaf</div>
                            <div class="service-desc">Sedekah & Waqaf</div>
                            <input type="checkbox" name="services[]" value="waqaf" checked hidden>
                        </div>
                    </div>
                </div>
                
                <!-- Detail Layanan Section -->
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-card-checklist"></i> Detail Permintaan per Divisi
                    </h6>
                    
                    <!-- Transportasi -->
                    <div class="detail-form" id="transportasi-details">
                        <h6 class="detail-title">
                            <i class="bi bi-airplane"></i> Transportasi
                        </h6>
                        
                        <div class="detail-section">
                            <div class="form-group">
                                <label class="form-label">Tiket Pesawat</label>
                                <input type="text" class="form-control" name="transportasi[tiket_pesawat]" placeholder="Jumlah pax, rute, tanggal, maskapai">
                                <div class="form-text">Contoh: 20 pax, Jakarta-Jeddah PP transit Malaysia, 1 Jan 2024, Garuda Indonesia</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Bus</label>
                                <input type="text" class="form-control" name="transportasi[bus]" placeholder="Jumlah, kapasitas, kebutuhan">
                                <div class="form-text">Contoh: 1 bus, kapasitas 45 seat, AC + WiFi</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hotel -->
                    <div class="detail-form" id="hotel-details">
                        <h6 class="detail-title">
                            <i class="bi bi-building"></i> Hotel
                        </h6>
                        
                        <div class="detail-section">
                            <div class="form-group">
                                <label class="form-label">Makkah</label>
                                <input type="text" class="form-control" name="hotel[makkah]" placeholder="Checkin, checkout, tipe kamar, bintang">
                                <div class="form-text">Contoh: Checkin 2 Jan, Checkout 7 Jan, 4 quad + 1 queen, bintang 4</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Madinah</label>
                                <input type="text" class="form-control" name="hotel[madinah]" placeholder="Checkin, checkout, tipe kamar, bintang">
                                <div class="form-text">Contoh: Checkin 8 Jan, Checkout 13 Jan, 4 quad + 1 queen, bintang 4</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dokumen -->
                    <div class="detail-form" id="dokumen-details">
                        <h6 class="detail-title">
                            <i class="bi bi-file-text"></i> Dokumen
                        </h6>
                        
                        <div class="detail-section">
                            <div class="form-group">
                                <label class="form-label">Visa</label>
                                <input type="text" class="form-control" name="dokumen[visa]" placeholder="Jumlah pax, jenis visa">
                                <div class="form-text">Contoh: 20 pax, visa umroh</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Vaksin</label>
                                <input type="text" class="form-control" name="dokumen[vaksin]" placeholder="Jenis vaksin, jumlah pax">
                                <div class="form-text">Contoh: Meningitis & Polio, 20 pax</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Tasreh Roudoh</label>
                                <input type="text" class="form-control" name="dokumen[tasreh_roudoh]" placeholder="Jumlah pax">
                                <div class="form-text">Contoh: 20 pax</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Handling -->
                    <div class="detail-form" id="handling-details">
                        <h6 class="detail-title">
                            <i class="bi bi-briefcase"></i> Handling
                        </h6>
                        
                        <div class="detail-section">
                            <div class="form-group">
                                <label class="form-label">Bandara Indonesia</label>
                                <input type="text" class="form-control" name="handling[bandara_indonesia]" placeholder="Detail handling bandara Indonesia">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Bandara Jeddah</label>
                                <input type="text" class="form-control" name="handling[bandara_jeddah]" placeholder="Detail handling bandara Jeddah">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Checkin/Checkout Hotel</label>
                                <input type="text" class="form-control" name="handling[hotel]" placeholder="Detail handling hotel Makkah & Madinah">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tambahkan detail untuk divisi lainnya di sini -->
                    
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="reset" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-check-circle"></i> Simpan Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle seleksi service item
        const serviceItems = document.querySelectorAll('.service-item');
        serviceItems.forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('selected');
                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
                
                // Toggle tampilan detail form
                const serviceType = item.getAttribute('data-service');
                const detailForm = document.getElementById(`${serviceType}-details`);
                if (detailForm) {
                    detailForm.style.display = checkbox.checked ? 'block' : 'none';
                }
            });
        });
        
        // Validasi form sebelum submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'var(--danger-color)';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Harap isi semua field yang wajib diisi!');
            }
        });
    });
</script>
@endsection