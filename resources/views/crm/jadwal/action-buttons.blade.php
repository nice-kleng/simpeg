<a href="{{ route('crm.jadwalKunjungan.jawabanMitra', $row->id) }}"
    class="btn btn-success btn-sm">{{ $row->pertanyaan && $row->pertanyaan()->count() < 1 ? 'Isi Jawaban' : 'Lihat Jawaban' }}</a>
<a href="javascript:void(0)" class="btn btn-warning btn-sm edit" data-id="{{ $row->id }}">Edit</a>
<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="{{ $row->id }}">Delete</a>
