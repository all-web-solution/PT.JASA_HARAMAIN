@extends('admin.master')
@section('title', 'Timeline Agenda Kerja')

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <style>
        :root {
            --fc-border-color: #f0f2f5;
            --fc-button-bg-color: #ffffff;
            --fc-button-border-color: #e4e6eb;
            --fc-button-text-color: #65676b;
            --fc-button-active-bg-color: #f0f2f5;
            --fc-button-active-border-color: #e4e6eb;
        }

        /* Calendar Container Styling */
        #calendar-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            padding: 25px;
        }

        /* FullCalendar Overrides */
        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .fc .fc-button {
            border-radius: 8px;
            font-weight: 600;
            text-transform: capitalize;
            box-shadow: none !important;
        }

        .fc .fc-col-header-cell-cushion {
            padding: 10px;
            color: #6c757d;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .fc-daygrid-day-number {
            font-weight: 600;
            color: #495057;
            text-decoration: none;
            padding: 8px 12px;
        }

        .fc-event {
            border: none;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 2px 4px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .fc-event:hover {
            transform: scale(1.02);
            filter: brightness(0.95);
            cursor: pointer;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 16px;
            border: none;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-radius: 16px 16px 0 0;
            border-bottom: 1px solid #eee;
        }

        /* --- MOBILE RESPONSIVE TWEAKS --- */
        @media (max-width: 768px) {

            /* 1. Header Toolbar Stack ke Bawah */
            .fc .fc-toolbar {
                flex-direction: column;
                gap: 15px;
            }

            .fc .fc-toolbar-title {
                font-size: 1.2rem;
            }

            /* 2. Tombol Navigasi Full Width */
            .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                width: 100%;
                flex-wrap: wrap;
                gap: 5px;
            }

            /* 3. Container Kalender Lebih Tipis Paddingnya */
            #calendar-container {
                padding: 15px;
                border-radius: 12px;
            }

            /* 5. Sembunyikan tombol view yang kurang berguna di HP (FORCE LIST VIEW) */
            .fc-dayGridMonth-button,
            .fc-timeGridWeek-button,
            .fc-dayGridMonth-button {
                display: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-12">
                <div id="calendar-container">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fs-5" id="modalTitle">Detail Agenda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 p-md-4">
                    <div id="modalBodyContent"></div>
                </div>
                <div class="modal-footer bg-light border-0 rounded-bottom-4 py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modalEl = document.getElementById('eventDetailModal');
            const detailModal = new bootstrap.Modal(modalEl);

            const isMobile = window.innerWidth < 768;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: isMobile ? 'listMonth' : 'dayGridMonth',
                themeSystem: 'bootstrap5',
                locale: 'id',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: isMobile ? 'listMonth,dayGridMonth' : 'dayGridMonth,timeGridWeek,listMonth'
                },

                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari',
                    list: 'List Agenda'
                },

                height: isMobile ? 'auto' : 800,
                events: "{{ route('api.agenda.events') }}",

                // EVENT CLICK
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    const titleEl = document.getElementById('modalTitle');
                    titleEl.innerText = info.event.title;

                    document.querySelector('.modal-header').style.borderBottomColor = info.event
                        .backgroundColor || info.event.borderColor || '#eee';
                    document.querySelector('.modal-header').style.borderBottomWidth = '3px';

                    let rawDesc = info.event.extendedProps.description || 'Tidak ada detail tambahan.';
                    let formattedDesc = formatDescriptionToHtml(rawDesc);

                    document.getElementById('modalBodyContent').innerHTML = formattedDesc;
                    detailModal.show();
                },
            });

            calendar.render();

            function formatDescriptionToHtml(text) {
                let lines = text.split('\n');
                let html = '<div class="d-flex flex-column gap-2">';

                lines.forEach(line => {
                    if (line.includes('---')) {
                        html += '<hr class="my-1 border-secondary opacity-10">';
                        return;
                    }
                    if (line.trim().endsWith(':')) {
                        html += `<h6 class="fw-bold mt-2 text-primary small text-uppercase">${line}</h6>`;
                        return;
                    }
                    if (line.trim().startsWith('•') || line.trim().startsWith('- ')) {
                        html +=
                            `<div class="ms-3 text-secondary small"><i class="bi bi-dot"></i> ${line.replace(/^[•-]\s*/, '')}</div>`;
                        return;
                    }

                    let parts = line.split(':');
                    if (parts.length > 1) {
                        let label = parts[0].trim();
                        let value = parts.slice(1).join(':').trim();

                        let icon = '';
                        if (label.toLowerCase().includes('customer')) icon =
                            '<i class="bi bi-people me-2"></i>';
                        else if (label.toLowerCase().includes('status')) icon =
                            '<i class="bi bi-info-circle me-2"></i>';
                        else if (label.toLowerCase().includes('tanggal') || label.toLowerCase().includes(
                                'periode') || label.toLowerCase().includes('check')) icon =
                            '<i class="bi bi-calendar-event me-2"></i>';
                        else if (label.toLowerCase().includes('hotel')) icon =
                            '<i class="bi bi-building me-2"></i>';
                        else if (label.toLowerCase().includes('pax') || label.toLowerCase().includes(
                                'jumlah')) icon = '<i class="bi bi-person-badge me-2"></i>';

                        html += `
                            <div class="d-flex justify-content-between align-items-start border-bottom pb-1 mb-1">
                                <span class="text-muted small" style="min-width:100px;">${icon}${label}</span>
                                <span class="fw-medium text-end text-dark small text-break" style="max-width: 60%;">${value}</span>
                            </div>
                        `;
                    } else {
                        if (line.trim() !== '') {
                            html += `<div class="text-dark small">${line}</div>`;
                        }
                    }
                });
                html += '</div>';
                return html;
            }
        });
    </script>
@endpush
