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
        --danger-color: #dc3545;
    }
    
    .service-container {
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
        background-color: white;
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
    
    /* Customer Info Section */
    .customer-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }
    
    .info-item {
        margin-bottom: 0;
    }
    
    .info-item label {
        display: block;
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
        font-weight: 500;
    }
    
    .info-item input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background-color: #f8fafd;
        color: var(--text-primary);
    }
    
    /* Service Cards */
    .service-cards-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }
    
    .service-card {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 1.75rem 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        background-color: white;
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    
    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background-color: transparent;
        transition: background-color 0.3s ease;
    }
    
    .service-card:hover {
        border-color: var(--haramain-accent);
        box-shadow: 0 8px 20px rgba(42, 111, 219, 0.15);
        transform: translateY(-3px);
    }
    
    .service-card:hover::before {
        background-color: var(--haramain-accent);
    }
    
    .service-card.selected {
        border-color: var(--haramain-secondary);
        background-color: var(--haramain-light);
        box-shadow: 0 4px 12px rgba(42, 111, 219, 0.2);
    }
    
    .service-card.selected::before {
        background-color: var(--haramain-secondary);
    }
    
    .service-card.selected::after {
        content: '\F26E';
        font-family: bootstrap-icons;
        position: absolute;
        top: 10px;
        right: 10px;
        width: 24px;
        height: 24px;
        background-color: var(--success-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    
    .service-card i {
        font-size: 2.5rem;
        color: var(--haramain-secondary);
        margin-bottom: 1.25rem;
        transition: transform 0.3s ease;
    }
    
    .service-card:hover i {
        transform: scale(1.1);
    }
    
    .service-card h5 {
        font-weight: 700;
        color: var(--haramain-primary);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    
    .service-card p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    
    /* Detail Service Options */
    .service-options-container {
        display: none;
        padding: 1.5rem;
        background-color: var(--haramain-light);
        border-radius: 8px;
        margin: 0 1.5rem 1.5rem;
    }
    
    .service-options-container.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .option-group {
        margin-bottom: 1.75rem;
        background-color: white;
        padding: 1.25rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .option-group:last-child {
        margin-bottom: 0;
    }
    
    .option-group-title {
        font-weight: 600;
        color: var(--haramain-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.05rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .option-group-title i {
        color: var(--haramain-secondary);
        font-size: 1.2rem;
    }
    
    .option-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }
    
    .option-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 1rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        background-color: #f8fafd;
        border: 1px solid var(--border-color);
    }
    
    .option-item:hover {
        background-color: var(--hover-bg);
        border-color: var(--haramain-accent);
    }
    
    .option-item-content {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    
    .option-item input[type="checkbox"],
    .option-item input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: var(--checked-color);
        margin-top: 2px;
        flex-shrink: 0;
    }
    
    .option-item label {
        cursor: pointer;
        color: var(--text-primary);
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.4;
    }
    
    .option-price {
        color: var(--haramain-secondary);
        font-weight: 600;
        font-size: 0.9rem;
        margin-top: 2px;
    }
    
    /* Quantity Input */
    .quantity-container {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px dashed var(--border-color);
    }
    
    .quantity-input {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .quantity-input label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        min-width: 80px;
    }
    
    .quantity-input input {
        width: 80px;
        padding: 0.375rem 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        text-align: center;
        font-weight: 500;
    }
    
    /* Buttons */
    .btn {
        padding: 0.75rem 1.75rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }
    
    .btn-primary {
        background-color: var(--haramain-secondary);
        border-color: var(--haramain-secondary);
    }
    
    .btn-primary:hover {
        background-color: var(--haramain-primary);
        border-color: var(--haramain-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(26, 75, 140, 0.3);
    }
    
    .btn-outline-secondary {
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        background-color: white;
    }
    
    .btn-outline-secondary:hover {
        background-color: var(--haramain-light);
        border-color: var(--haramain-accent);
        color: var(--haramain-primary);
    }
    
    .action-buttons {
        background-color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        border-top: 1px solid var(--border-color);
    }
    
    /* Price Calculation */
    .price-calculation {
        background-color: white;
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
    }
    
    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
    }
    
    .price-row:last-child {
        border-bottom: none;
    }
    
    .price-label {
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .price-value {
        font-weight: 600;
        color: var(--haramain-primary);
    }
    
    .total-price {
        font-size: 1.2rem;
        color: var(--haramain-secondary);
        margin-top: 0.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .service-cards-container {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .service-cards-container {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            padding: 1rem;
        }
        
        .service-card {
            padding: 1.5rem 1rem;
        }
        
        .card-header {
            padding: 1.25rem;
        }
        
        .option-list {
            grid-template-columns: 1fr;
        }
        
        .customer-info-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 576px) {
        .service-container {
            padding: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="service-container">
    <!-- Informasi Pelanggan -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-person-circle"></i> Informasi Pelanggan
            </h5>
        </div>
        <div class="customer-info-grid">
            <div class="info-item">
                <label>Nama Pelanggan</label>
                <select name="pelanggan_id" id="pelanggan_id">
                    <option value="">PILIH PELANGGAN</option>
                </select>
            </div>
            <div class="info-item">
                <label>Penanggung Jawab</label>
                <input type="text" name="penanggung" readonly>
            </div>
            <div class="info-item">
                <label>ID Services</label>
                <input type="text" value="#UMR-2023-001" readonly>
            </div>
            <div class="info-item">
                <label>Tanggal Berangkat</label>
                <input type="date"  >
            </div>
            <div class="info-item">
                <label>Tanggal Pulang</label>
                <input type="date" >
            </div>
            <div class="info-item">
                <label>Total Jamaah</label>
                <input type="text" value="25" >
            </div>
        </div>                                      
    </div>

    <!-- Pemilihan Layanan -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-check2-square"></i> Pilih Layanan
            </h5>
        </div>
        <div class="service-cards-container">
            <!-- 1. PERIZINAN DAN DOKUMEN -->
            <div class="service-card" data-service="perizinan">
                <i class="bi bi-passport"></i>
                <h5>PERIZINAN DAN DOKUMEN</h5>
                <p>Proses visa dan dokumen perjalanan</p>
            </div>

            <!-- 2. TIKET DAN TRANSPORTASI -->
            <div class="service-card" data-service="transportasi">
                <i class="bi bi-airplane"></i>
                <h5>TIKET DAN TRANSPORTASI</h5>
                <p>Tiket pesawat dan transportasi darat</p>
            </div>

            <!-- 3. MUTOWWIF -->
            <div class="service-card" data-service="mutowwif">
                <i class="bi bi-person-video3"></i>
                <h5>MUTOWWIF</h5>
                <p>Pemandu ibadah profesional</p>
            </div>

            <!-- 4. HANDLING -->
            <div class="service-card" data-service="handling">
                <i class="bi bi-briefcase"></i>
                <h5>HANDLING</h5>
                <p>Asistensi bandara dan hotel</p>
            </div>

            <!-- 5. HOTEL -->
            <div class="service-card" data-service="hotel">
                <i class="bi bi-building"></i>
                <h5>HOTEL</h5>
                <p>Pengaturan akomodasi</p>
            </div>

            <!-- 6. TOUR -->
            <div class="service-card" data-service="tour">
                <i class="bi bi-map"></i>
                <h5>TOUR</h5>
                <p>Ziarah dan city tour</p>
            </div>

            <!-- 7. KATERING -->
            <div class="service-card" data-service="katering">
                <i class="bi bi-egg-fried"></i>
                <h5>KATERING</h5>
                <p>Pengaturan makanan</p>
            </div>

            <!-- 8. DOKUMENTASI DAN KONTEN -->
            <div class="service-card" data-service="dokumentasi">
                <i class="bi bi-camera-video"></i>
                <h5>DOKUMENTASI DAN KONTEN</h5>
                <p>Dokumentasi foto/video</p>
            </div>

            <!-- 9. REYAL -->
            <div class="service-card" data-service="reyal">
                <i class="bi bi-currency-exchange"></i>
                <h5>REYAL</h5>
                <p>Layanan penukaran mata uang</p>
            </div>

            <!-- 10. DORONG -->
            <div class="service-card" data-service="dorong">
                <i class="bi bi-wheelchair"></i>
                <h5>DORONG</h5>
                <p>Asistensi kursi roda</p>
            </div>

            <!-- 11. WAQAF DAN SEDEKAH -->
            <div class="service-card" data-service="waqaf">
                <i class="bi bi-heart"></i>
                <h5>WAQAF DAN SEDEKAH</h5>
                <p>Pengaturan amal</p>
            </div>
        </div>
        
        <!-- Container Opsi Layanan -->
        <div id="serviceOptionsContainer">
            <!-- PERIZINAN Options -->
            <div class="service-options-container" id="perizinanOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-passport"></i> VISA
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="visa_umroh" name="perizinan[]" value="visa_umroh" checked>
                                <div>
                                    <label for="visa_umroh">Visa Umroh</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="perizinan_jumlah[visa_umroh]" value="25" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="visa_ziarah" name="perizinan[]" value="visa_ziarah">
                                <div>
                                    <label for="visa_ziarah">Visa Ziarah</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="perizinan_jumlah[visa_ziarah]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="visa_haji" name="perizinan[]" value="visa_haji">
                                <div>
                                    <label for="visa_haji">Visa Haji</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="perizinan_jumlah[visa_haji]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-file-earmark-check"></i> DOKUMEN DALAM NEGERI
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="siskopatuh" name="perizinan[]" value="siskopatuh" checked>
                                <div>
                                    <label for="siskopatuh">Siskopatuh</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="perizinan_jumlah[siskopatuh]" value="25" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="vaksin_meningitis" name="perizinan[]" value="vaksin_meningitis" checked>
                                <div>
                                    <label for="vaksin_meningitis">Vaksin Meningitis</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="perizinan_jumlah[vaksin_meningitis]" value="25" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="vaksin_polio" name="perizinan[]" value="vaksin_polio">
                                <div>
                                    <label for="vaksin_polio">Vaksin Polio</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="perizinan_jumlah[vaksin_polio]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- TIKET DAN TRANSPORTASI Options -->
            <div class="service-options-container" id="transportasiOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-airplane"></i> TIKET PESAWAT
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="tiket_1" name="transportasi[]" value="tiket_1" checked>
                                <div>
                                    <label for="tiket_1">Garuda Indonesia - CGK-JED</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Tiket:</label>
                                    <input type="number" name="transportasi_jumlah[tiket_1]" value="25" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="tiket_2" name="transportasi[]" value="tiket_2">
                                <div>
                                    <label for="tiket_2">Saudi Airlines - JED-CGK</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Tiket:</label>
                                    <input type="number" name="transportasi_jumlah[tiket_2]" value="25" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="tiket_3" name="transportasi[]" value="tiket_3">
                                <div>
                                    <label for="tiket_3">Lion Air - CGK-MED</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Tiket:</label>
                                    <input type="number" name="transportasi_jumlah[tiket_3]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-train-front"></i> TIKET KERETA CEPAT
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="kereta_1" name="transportasi[]" value="kereta_1">
                                <div>
                                    <label for="kereta_1">Kereta Cepat Haramain</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Tiket:</label>
                                    <input type="number" name="transportasi_jumlah[kereta_1]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-bus-front"></i> TRANSPORTASI DARAT
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="bus_1" name="transportasi[]" value="bus_1" checked>
                                <div>
                                    <label for="bus_1">Bus (30 orang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Bus:</label>
                                    <input type="number" name="transportasi_jumlah[bus_1]" value="1" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="minibus_1" name="transportasi[]" value="minibus_1">
                                <div>
                                    <label for="minibus_1">Minibus (12 orang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Minibus:</label>
                                    <input type="number" name="transportasi_jumlah[minibus_1]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="minibus_1" name="transportasi[]" value="minibus_1">
                                <div>
                                    <label for="minibus_1">Coaster (12 orang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Coaster:</label>
                                    <input type="number" name="transportasi_jumlah[minibus_1]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="minibus_1" name="transportasi[]" value="minibus_1">
                                <div>
                                    <label for="minibus_1">HI-ACE (12 orang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah HI-ACE:</label>
                                    <input type="number" name="transportasi_jumlah[minibus_1]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="minibus_1" name="transportasi[]" value="minibus_1">
                                <div>
                                    <label for="minibus_1"> STARIA (8 orang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah STARIA:</label>
                                    <input type="number" name="transportasi_jumlah[minibus_1]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="minibus_1" name="transportasi[]" value="minibus_1">
                                <div>
                                    <label for="minibus_1"> GMC (5 orang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah GMC:</label>
                                    <input type="number" name="transportasi_jumlah[minibus_1]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="minibus_1" name="transportasi[]" value="minibus_1">
                                <div>
                                    <label for="minibus_1"> SEDAN (3 orang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah SEDAN:</label>
                                    <input type="number" name="transportasi_jumlah[minibus_1]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- MUTOWWIF Options -->
            <div class="service-options-container" id="mutowwifOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-person-video3"></i> MUTOWWIF
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="radio" id="mutawwif_1" name="mutawwif" value="mutawwif_1" checked>
                                <div>
                                    <label for="mutawwif_1">Pendamping Class Standar</label>
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="radio" id="mutawwif_2" name="mutawwif" value="mutawwif_2">
                                <div>
                                    <label for="mutawwif_2">Pendamping Class Premium</label>
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="radio" id="mutawwif_3" name="mutawwif" value="mutawwif_3">
                                <div>
                                    <label for="mutawwif_3">Pendamping Class VIP</label>
                                </div>
                            </div>
                        </div>
                         <div class="option-item">
                            <div class="option-item-content">
                                <input type="radio" id="mutawwif_3" name="mutawwif" value="mutawwif_3">
                                <div>
                                    <label for="mutawwif_3">Mutowwifah</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- HANDLING Options -->
            <div class="service-options-container" id="handlingOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-briefcase"></i> HANDLING
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="handlingBandara" name="handling[]" value="bandara" checked>
                                <div>
                                    <label for="handlingBandara">Handling Bandara (Bandara Jakarta)</label>
                                    <div class="option-price">Termasuk dalam paket</div>
                                </div>
                            </div>
                        </div>
                         <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="handlingBandara" name="handling[]" value="bandara" checked>
                                <div>
                                    <label for="handlingBandara">Handling Bandara (Bandara Jeddah)</label>
                                    <div class="option-price">Termasuk dalam paket</div>
                                </div>
                            </div>
                        </div>
                         <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="handlingBandara" name="handling[]" value="bandara" checked>
                                <div>
                                    <label for="handlingBandara">Handling Bandara (Bandara Madinah)</label>
                                    <div class="option-price">Termasuk dalam paket</div>
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="handlingHotel" name="handling[]" value="hotel" checked>
                                <div>
                                    <label for="handlingHotel">Handling Hotel (Hotel Makkah)</label>
                                    <div class="option-price">Termasuk dalam paket</div>
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="handlingHotel" name="handling[]" value="hotel" checked>
                                <div>
                                    <label for="handlingHotel">Handling Hotel (Hotel Madi)</label>
                                    <div class="option-price">Termasuk dalam paket</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- HOTEL Options -->
            <div class="service-options-container" id="hotelOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-building"></i> HOTEL
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="hotel_1" name="hotel[]" value="hotel_1" checked>
                                <div>
                                    <label for="hotel_1">Hotel Al-Safwah (5 bintang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Kamar:</label>
                                    <input type="number" name="hotel_jumlah[hotel_1]" value="13" min="1">
                                </div>
                                <div class="quantity-input" style="margin-top: 8px;">
                                    <label>Malam:</label>
                                    <input type="number" name="hotel_malam[hotel_1]" value="15" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="hotel_2" name="hotel[]" value="hotel_2">
                                <div>
                                    <label for="hotel_2">Hotel Pullman ZamZam (5 bintang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Kamar:</label>
                                    <input type="number" name="hotel_jumlah[hotel_2]" value="0" min="0">
                                </div>
                                <div class="quantity-input" style="margin-top: 8px;">
                                    <label>Malam:</label>
                                    <input type="number" name="hotel_malam[hotel_2]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="hotel_3" name="hotel[]" value="hotel_3">
                                <div>
                                    <label for="hotel_3">Hotel Dar Al Tawhid (4 bintang)</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Kamar:</label>
                                    <input type="number" name="hotel_jumlah[hotel_3]" value="0" min="0">
                                </div>
                                <div class="quantity-input" style="margin-top: 8px;">
                                    <label>Malam:</label>
                                    <input type="number" name="hotel_malam[hotel_3]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- TOUR Options -->
            <div class="service-options-container" id="tourOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-map"></i> CITY TOUR
                    </h6>
                    <div class="option-list">
                         <div class="option-item">
                            <div class="option-item-content">
                                <input type="radio" id="mutawwif_3" name="mutawwif" value="mutawwif_3">
                                <div>
                                    <label for="mutawwif_3">CITY TOUR MAKKAH REGULER</label>
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="radio" id="mutawwif_3" name="mutawwif" value="mutawwif_3">
                                <div>
                                    <label for="mutawwif_3">CITY TOUR MADINAH REGULER</label>
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="radio" id="mutawwif_3" name="mutawwif" value="mutawwif_3">
                                <div>
                                    <label for="mutawwif_3">CITY TOUR MAKKAH REGULER</label>
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="radio" id="mutawwif_3" name="mutawwif" value="mutawwif_3">
                                <div>
                                    <label for="mutawwif_3">CITY TOUR MAKKAH REGULER</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-signpost-split"></i> ZIARAH KHUSUS
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="ziarah_dalam_makkah" name="tour[]" value="ziarah_dalam_makkah">
                                <div>
                                    <label for="ziarah_dalam_makkah">ZIARAH DALAM MAKKAH</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[ziarah_dalam_makkah]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="ziarah_dalam_madinah" name="tour[]" value="ziarah_dalam_madinah">
                                <div>
                                    <label for="ziarah_dalam_madinah">ZIARAH DALAM MADINAH</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[ziarah_dalam_madinah]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-geo-alt"></i> LOKASI KHUSUS
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="jabal_khandamah_kudai" name="tour[]" value="jabal_khandamah_kudai">
                                <div>
                                    <label for="jabal_khandamah_kudai">JABAL KHANDAMAH DAN ATAU KUDAI</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[jabal_khandamah_kudai]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="thaif_miqot_qornun" name="tour[]" value="thaif_miqot_qornun">
                                <div>
                                    <label for="thaif_miqot_qornun">THAIF + MIQOT QORNUN MANAZIL</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[thaif_miqot_qornun]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="al_ula" name="tour[]" value="al_ula">
                                <div>
                                    <label for="al_ula">AL ULA</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[al_ula]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="musium_wahyu_hira" name="tour[]" value="musium_wahyu_hira">
                                <div>
                                    <label for="musium_wahyu_hira">MUSIUM WAHYU + GUA HIRA</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[musium_wahyu_hira]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="musium_as_shafia" name="tour[]" value="musium_as_shafia">
                                <div>
                                    <label for="musium_as_shafia">MUSIUM AS-SHAFIA</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[musium_as_shafia]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="miqot_hudaibiyyah" name="tour[]" value="miqot_hudaibiyyah">
                                <div>
                                    <label for="miqot_hudaibiyyah">MIQOT HUDAIBIYYAH + PETERNAKAN UNTA + MUSIUM KA'BAH</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[miqot_hudaibiyyah]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="pusat_oleh_oleh" name="tour[]" value="pusat_oleh_oleh">
                                <div>
                                    <label for="pusat_oleh_oleh">PUSAT OLEH-OLEH KA'KIYYAH</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[pusat_oleh_oleh]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="miqot_tanim" name="tour[]" value="miqot_tanim">
                                <div>
                                    <label for="miqot_tanim">MIQOT TAN'IM</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[miqot_tanim]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="miqot_yalamlam" name="tour[]" value="miqot_yalamlam">
                                <div>
                                    <label for="miqot_yalamlam">MIQOT YALAM-LAM</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[miqot_yalamlam]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="madinah_musium_night" name="tour[]" value="madinah_musium_night">
                                <div>
                                    <label for="madinah_musium_night">MADINAH MUSIUM NIGHT</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[madinah_musium_night]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="jabal_magnet" name="tour[]" value="jabal_magnet">
                                <div>
                                    <label for="jabal_magnet">JABAL MAGNET + PERCETAKAN AL-QURAN</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[jabal_magnet]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="bir_gharas_uhud" name="tour[]" value="bir_gharas_uhud">
                                <div>
                                    <label for="bir_gharas_uhud">BIR GHARAS + LOKASI PERANG UHUD</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[bir_gharas_uhud]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="lokasi_perang_badar" name="tour[]" value="lokasi_perang_badar">
                                <div>
                                    <label for="lokasi_perang_badar">LOKASI PERANG BADAR</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[lokasi_perang_badar]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="jamarat" name="tour[]" value="jamarat">
                                <div>
                                    <label for="jamarat">JAMARAT</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="tour_jumlah[jamarat]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- KATERING Options -->
            <div class="service-options-container" id="kateringOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-egg-fried"></i> KATERING
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="katering_1" name="katering[]" value="katering_1" checked>
                                <div>
                                    <label for="katering_1">Paket Standar</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="katering_jumlah[katering_1]" value="25" min="1">
                                </div>
                                <div class="quantity-input" style="margin-top: 8px;">
                                    <label>Hari:</label>
                                    <input type="number" name="katering_hari[katering_1]" value="15" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="katering_2" name="katering[]" value="katering_2">
                                <div>
                                    <label for="katering_2">Paket Premium</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="katering_jumlah[katering_2]" value="0" min="0">
                                </div>
                                <div class="quantity-input" style="margin-top: 8px;">
                                    <label>Hari:</label>
                                    <input type="number" name="katering_hari[katering_2]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="katering_3" name="katering[]" value="katering_3">
                                <div>
                                    <label for="katering_3">Paket Khusus</label>
                                    
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah Jamaah:</label>
                                    <input type="number" name="katering_jumlah[katering_3]" value="0" min="0">
                                </div>
                                <div class="quantity-input" style="margin-top: 8px;">
                                    <label>Hari:</label>
                                    <input type="number" name="katering_hari[katering_3]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- DOKUMENTASI DAN KONTEN Options -->
            <div class="service-options-container" id="dokumentasiOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-camera-video"></i> DOKUMENTASI DAN KONTEN
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="dokumentasi" name="dokumentasi[]" value="dokumentasi" checked>
                                <div>
                                    <label for="dokumentasi">Dokumentasi (Foto & Video)</label>
                                    <div class="option-price">Rp2.000.000</div>
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="konten" name="dokumentasi[]" value="konten">
                                <div>
                                    <label for="konten">Konten Sosial Media</label>
                                    <div class="option-price">Rp3.500.000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- REYAL Options -->
            <div class="service-options-container" id="reyalOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-currency-exchange"></i> PENUKARAN MATA UANG
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="quantity-input">
                                <label>Jumlah Riyal (SAR):</label>
                                <input type="number" class="form-control" name="jumlah_riyal" value="5000" min="0">
                            </div>
                            <div style="margin-top: 8px; font-size: 0.9rem; color: var(--text-secondary);">
                                <i class="bi bi-info-circle"></i> Kurs saat ini: 1 SAR = Rp3.850
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- DORONG Options -->
            <div class="service-options-container" id="dorongOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-wheelchair"></i> LAYANAN DORONG
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="dorongUmroh" name="dorong[]" value="umroh" checked>
                                <div>
                                    <label for="dorongUmroh">Umroh</label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah:</label>
                                    <input type="number" name="dorong_jumlah[umroh]" value="2" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="dorongTawaf" name="dorong[]" value="tawaf_wada">
                                <div>
                                    <label for="dorongTawaf">TAWAF WADA
	                        </label>
                                </div>
                            </div>
                            <div class="quantity-container">
                                <div class="quantity-input">
                                    <label>Jumlah:</label>
                                    <input type="number" name="dorong_jumlah[tawaf_wada]" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="option-item">
                            <div class="option-item-content">
                                <input type="checkbox" id="dorongMesjid" name="dorong[]" value="mesjid">
                                <div>
                                    <label for="dorongMesjid">MESJID </label>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- WAQAF DAN SEDEKAH Options -->
            <div class="service-options-container" id="waqafOptions">
                <div class="option-group">
                    <h6 class="option-group-title">
                        <i class="bi bi-heart"></i> WAQAF DAN SEDEKAH
                    </h6>
                    <div class="option-list">
                        <div class="option-item">
                            <div class="quantity-input">
                                <label>Jenis:</label>
                                <input type="text" class="form-control" name="jenis_waqaf" value="Air Minum">
                            </div>
                            <div class="quantity-input" style="margin-top: 8px;">
                                <label>Jumlah (Rp):</label>
                                <input type="number" class="form-control" name="jumlah_waqaf" value="5000000" min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Price Calculation -->
        <div class="price-calculation">
            <div class="price-row">
                <span class="price-label">Subtotal:</span>
                <span class="price-value">Rp 125,000,000</span>
            </div>
            <div class="price-row">
                <span class="price-label">Diskon:</span>
                <span class="price-value">- Rp 5,000,000</span>
            </div>
            <div class="price-row">
                <span class="price-label">Pajak (10%):</span>
                <span class="price-value">+ Rp 12,000,000</span>
            </div>
            <div class="price-row total-price">
                <span class="price-label">Total:</span>
                <span class="price-value">Rp 132,000,000</span>
            </div>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="action-buttons">
            <button type="button" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </button>
            <button type="button" class="btn btn-primary" id="saveServices">
                <i class="bi bi-save"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi pemilihan kartu layanan
        const serviceCards = document.querySelectorAll('.service-card');
        const saveButton = document.getElementById('saveServices');
        const optionContainers = document.querySelectorAll('.service-options-container');
        let selectedServices = ['perizinan', 'transportasi', 'mutowwif', 'handling', 'hotel', 'tour', 'katering', 'dokumentasi'];
        
        // Tampilkan container opsi untuk layanan yang sudah dipilih
        selectedServices.forEach(service => {
            const card = document.querySelector(`.service-card[data-service="${service}"]`);
            if (card) {
                card.classList.add('selected');
            }
            
            const optionsId = `${service}Options`;
            const optionsContainer = document.getElementById(optionsId);
            if (optionsContainer) {
                optionsContainer.style.display = 'block';
            }
        });
        
        serviceCards.forEach(card => {
            card.addEventListener('click', function() {
                // Toggle class selected
                this.classList.toggle('selected');
                
                const serviceName = this.getAttribute('data-service');
                const optionsId = `${serviceName}Options`;
                const optionsContainer = document.getElementById(optionsId);
                
                // Update array layanan yang dipilih
                if (this.classList.contains('selected')) {
                    if (!selectedServices.includes(serviceName)) {
                        selectedServices.push(serviceName);
                    }
                    
                    // Tampilkan container opsi dengan animasi
                    if (optionsContainer) {
                        optionsContainer.style.display = 'block';
                        optionsContainer.classList.add('active');
                    }
                } else {
                    selectedServices = selectedServices.filter(item => item !== serviceName);
                    
                    // Sembunyikan container opsi
                    if (optionsContainer) {
                        optionsContainer.style.display = 'none';
                        optionsContainer.classList.remove('active');
                    }
                }
                
                console.log('Layanan Terpilih:', selectedServices);
                updatePriceCalculation();
            });
        });
        
        // Fungsi tombol simpan
        saveButton.addEventListener('click', function() {
            // Kumpulkan semua opsi yang dipilih
            const formData = {
                booking_id: "UMR-2023-001",
                services: {},
                quantities: {},
                totals: {}
            };
            
            selectedServices.forEach(service => {
                const serviceElements = document.querySelectorAll(`[name^="${service}"]:checked`);
                const values = Array.from(serviceElements).map(el => el.value);
                
                // Untuk radio button
                if (values.length === 0) {
                    const radio = document.querySelector(`[name="${service}"]:checked`);
                    if (radio) {
                        values.push(radio.value);
                    }
                }
                
                // Untuk input teks
                if (values.length === 0) {
                    const textInputs = document.querySelectorAll(`#${service}Options input[type="text"], #${service}Options input[type="number"]`);
                    const textValues = {};
                    
                    textInputs.forEach(input => {
                        if (input.value.trim() !== '' && !input.name.includes('_jumlah') && !input.name.includes('_hari') && !input.name.includes('_malam')) {
                            textValues[input.name] = input.value.trim();
                        }
                    });
                    
                    if (Object.keys(textValues).length > 0) {
                        formData.services[service] = textValues;
                    }
                }
                
                if (values.length > 0) {
                    formData.services[service] = values;
                }
                
                // Kumpulkan jumlah untuk layanan ini
                const quantityInputs = document.querySelectorAll(`[name^="${service}_jumlah"]`);
                if (quantityInputs.length > 0) {
                    formData.quantities[service] = {};
                    quantityInputs.forEach(input => {
                        const key = input.name.match(/\[(.*?)\]/)[1];
                        formData.quantities[service][key] = input.value;
                    });
                }
                
                // Kumpulkan hari/malam untuk layanan tertentu
                const dayInputs = document.querySelectorAll(`[name^="${service}_hari"], [name^="${service}_malam"]`);
                if (dayInputs.length > 0) {
                    formData.totals[service] = {};
                    dayInputs.forEach(input => {
                        const key = input.name.match(/\[(.*?)\]/)[1];
                        formData.totals[service][key] = input.value;
                    });
                }
            });
            
            // Tampilkan data yang akan dikirim (untuk demo)
            console.log('Data yang akan dikirim:', formData);
            alert('Data layanan berhasil disimpan (simulasi)\nLihat console untuk detail data');
            
            // Simulasi pengiriman data ke backend
            /*
            fetch('/api/save-booking-services', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Layanan berhasil disimpan!');
                    window.location.reload();
                } else {
                    alert('Gagal menyimpan layanan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan layanan');
            });
            */
        });
        
        // Fungsi untuk mengupdate jumlah berdasarkan checkbox
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const name = this.name.replace('[]', '');
                const quantityInput = document.querySelector(`input[name^="${name}_jumlah"][value="${this.value}"]`);
                
                if (quantityInput) {
                    if (this.checked) {
                        // Set default value 1 if currently 0
                        if (parseInt(quantityInput.value) === 0) {
                            quantityInput.value = '1';
                        }
                    } else {
                        quantityInput.value = '0';
                    }
                }
                
                // Update related day/night inputs
                const dayInput = document.querySelector(`input[name^="${name}_hari"][value="${this.value}"]`) || 
                                document.querySelector(`input[name^="${name}_malam"][value="${this.value}"]`);
                if (dayInput) {
                    if (this.checked) {
                        if (parseInt(dayInput.value) === 0) {
                            dayInput.value = '1';
                        }
                    } else {
                        dayInput.value = '0';
                    }
                }
                
                updatePriceCalculation();
            });
        });
        
        // Update when quantity inputs change
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('change', updatePriceCalculation);
        });
        
        // Update when radio buttons change
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', updatePriceCalculation);
        });
        
        // Function to calculate and update prices
        function updatePriceCalculation() {
            // This would be replaced with actual calculation logic
            console.log('Updating price calculation...');
            
            // For demo purposes, we'll just show some sample values
            const subtotal = 125000000;
            const discount = 5000000;
            const tax = 12000000;
            const total = subtotal - discount + tax;
            
            // Format numbers with Indonesian formatting
            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID', { 
                    style: 'currency', 
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number).replace('Rp', 'Rp ');
            };
            
            // Update the UI
            document.querySelector('.price-row:nth-child(1) .price-value').textContent = formatRupiah(subtotal);
            document.querySelector('.price-row:nth-child(2) .price-value').textContent = '- ' + formatRupiah(discount);
            document.querySelector('.price-row:nth-child(3) .price-value').textContent = '+ ' + formatRupiah(tax);
            document.querySelector('.total-price .price-value').textContent = formatRupiah(total);
        }
        
        // Initial price calculation
        updatePriceCalculation();
    });
</script>
@endsection