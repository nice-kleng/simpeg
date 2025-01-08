@extends('layouts.app', ['pageTitle' => 'Report Leads'])

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Report Leads</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="s_date" name="s_date">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="e_date" name="e_date">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="preview-btn">Preview</button>
                        </div>
                    </div>

                    <div id="preview-table" class="mt-4" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" style="width: 100%;">
                                <thead>
                                    <tr id="header-row">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Maps</th>
                                        <th>Rating</th>
                                        <th>Alamat</th>
                                        <th>No. Telp</th>
                                        <th>Tanggal</th>
                                        <th>Status Prospek</th>
                                        <th>PIC</th>
                                    </tr>
                                </thead>
                                <tbody id="preview-data"></tbody>
                            </table>

                            <form action="{{ route('leads.export.excel') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="s_date" id="export_s_date">
                                <input type="hidden" name="e_date" id="export_e_date">
                                <button type="submit" class="btn btn-success" id="export-btn" style="display: none;">
                                    <i class="fa fa-file-excel"></i> Export to Excel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#preview-btn').click(function() {
                    var s_date = $('#s_date').val();
                    var e_date = $('#e_date').val();

                    if (!s_date || !e_date) {
                        alert('Please select both dates');
                        return;
                    }

                    $.ajax({
                        url: '{{ route('leads.preview.data') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            s_date: s_date,
                            e_date: e_date
                        },
                        success: function(response) {
                            // Clear existing headers first
                            const headerRow = $('#header-row');
                            headerRow.find('th:gt(8)').remove();

                            // Add follow-up headers using maxFollowUps from response
                            for (let i = 0; i < response.maxFollowUps; i++) {
                                headerRow.append(`
                                <th>Follow Up ${i + 1}</th>
                                <th>Keterangan FU ${i + 1}</th>
                            `);
                            }

                            // Generate table rows
                            let tbody = '';
                            response.data.forEach((item, index) => {
                                let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.nama || ''}</td>
                                    <td>${item.maps || ''}</td>
                                    <td>${item.rating || ''}</td>
                                    <td>${item.alamat || ''}</td>
                                    <td>${item.no_telp || ''}</td>
                                    <td>${item.tanggal || ''}</td>
                                    <td>${item.status_prospek || ''}</td>
                                    <td>${item.pics ? item.pics.map(pic => pic.name).join(', ') : ''}</td>
                            `;

                                // Add follow-up cells
                                for (let i = 0; i < response.maxFollowUps; i++) {
                                    const fu = item.follow_up && item.follow_up[i] ? item
                                        .follow_up[i] : {};
                                    row += `
                                    <td>${fu.tanggal || ''}</td>
                                    <td>${fu.keterangan || ''}</td>
                                `;
                                }

                                row += '</tr>';
                                tbody += row;
                            });

                            $('#preview-data').html(tbody);
                            $('#preview-table').show();
                            $('#export-btn').show();

                            $('#export_s_date').val(s_date);
                            $('#export_e_date').val(e_date);
                        },
                        error: function(xhr) {
                            alert('Error fetching data');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
