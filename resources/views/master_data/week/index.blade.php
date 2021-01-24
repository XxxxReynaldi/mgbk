@extends('layouts.template_app')

@section('title', '- Menu Sekolah')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column is-8">
            <h1 class="title ">Sekolah</h1>
            @if (session('status'))
                <div class="notification is-info column is-5">
                    <button class="delete deleteNotif"></button>
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="column is-4">
            <a href="#" class="button is-link importBtn is-pulled-right">Import </a>
            <a href="#" class="button is-info addBtn is-pulled-right">Tambah </a>
        </div>
    </div>
    <div class="columns is-multiline">

        <div class="column is-12 ">
            
            <div class="columns">
                <div class="column">
                    <div class="tabel-container">
                        <table class="table" id="table_weeks">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="is-hidden">ID</th>
                                    <th>Week</th>
                                    <th>Year</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th class="is-hidden">ID</th>
                                    <th>Week</th>
                                    <th>Year</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Opsi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($weeks as $week)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td class="is-hidden">{{ $week['id_week'] }}</td>
                                    <td>{{ $week['week'] }}</td>
                                    <td>{{ $week['year'] }}</td>
                                    <td>{{ $week['start_date'] }}</td>
                                    <td>{{ $week['end_date'] }}</td>
                                    <td>
                                        <button data-idWeek="{{ $week['id_week'] }}" class="button is-small is-success editBtn"> Edit </button>
                                        <button data-idWeek="{{ $week['id_week'] }}" class="button is-small is-danger deleteBtn"> Hapus </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

    <div class="modal" id="modal_import">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">
                <span class="icon-text has-text-info">
                    <span class="icon">
                        <i class="fas fa-calendar-week"></i>  
                    </span>
                    <span>Import week</span>
                </span>
            </p>
            <button class="delete modal-closed" aria-label="close"></button>
          </header>
          <form method="post" action="{{ route('week.import') }}" id="importForm">
            <section class="modal-card-body">
                @csrf
                <div class="field">
                    <label class="label" >File Excel</label>
                    <div id="file-js-example" class="file has-name">
                        <label class="file-label">
                            <input class="file-input" type="file" name="file_excel">
                            <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choose a file…
                            </span>
                            </span>
                            <span class="file-name">
                            No file uploaded
                            </span>
                        </label>
                    </div>
                </div>
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-link">Import</button>
                    <a href="#" class="button modal-closed">Batal</a> 
                </footer>
            </form>
        </div>
    </div>

    <div class="modal" id="modal_tambah">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">
                <span class="icon-text has-text-info">
                    <span class="icon">
                        <i class="fas fa-plus"></i>  
                    </span>
                    <span>Tambah Week</span>
                </span>
            </p>
            <button class="delete modal-closed" aria-label="close"></button>
          </header>
          <form method="post" action="{{ url('week') }}" id="addForm">
            <section class="modal-card-body">
                @csrf
                <div class="field">
                    <label class="label" for="week">Week</label>
                    <div class="field">
                        <div class="control">
                            <input name="week" id="week" class="input" type="text" placeholder="week">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="year">Year</label>
                    <div class="field">
                        <div class="control">
                            <input name="year" id="year" class="input" type="text" placeholder="year">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Start Date</label>
                    <p class="control has-icons-left">
                      <input class="input" type="date" id="addStartDate" name="start_date">
                      <span class="icon is-small is-left">
                        <i class="fas fa-calendar-alt"></i>
                      </span>
                    </p>
                  </div>
                <div class="field">
                    <label class="label">End Date</label>
                    <p class="control has-icons-left">
                        <input class="input" type="date" id="addEndDate" name="start_date">
                        <span class="icon is-small is-left">
                          <i class="fas fa-calendar-alt"></i>
                        </span>
                      </p>
                </div>
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-link">Tambah</button>
                    <a href="#" class="button modal-closed">Batal</a> 
                </footer>
            </form>
        </div>
    </div>

    <div class="modal" id="modal_edit">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">
                <span class="icon-text has-text-success">
                    <span class="icon">
                        <i class="fas fa-edit"></i>  
                    </span>
                    <span>Edit Week</span>
                </span>
            </p>
            <button class="delete modal-closed" aria-label="close"></button>
          </header>
          <form method="post" action="" id="editForm">
            <section class="modal-card-body">
                @method('put')
                @csrf
                <div class="field">
                    <label class="label" for="week">Week</label>
                    <div class="field">
                        <div class="control">
                            <input name="week" id="week" class="input" type="text" placeholder="week">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="year">Year</label>
                    <div class="field">
                        <div class="control">
                            <input name="year" id="year" class="input" type="text" placeholder="year">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="start_date">Start Date</label>
                    <div class="field">
                        <div class="control">
                            <input name="start_date" id="start_date" class="input" type="text" placeholder="start_date">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="end_date">End Date</label>
                    <div class="field">
                        <div class="control">
                            <input name="end_date" id="end_date" class="input" type="text" placeholder="end_date">
                        </div>
                    </div>
                </div>
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-success">Edit</button>
                    <a href="#" class="button modal-closed">Batal</a>
                </footer>
            </form>
        </div>
    </div>

    <div class="modal" id="modal_hapus">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">
                <span class="icon-text has-text-danger">
                    <span class="icon">
                        <i class="fas fa-exclamation-triangle"></i>  
                    </span>
                    <span>Konfirmasi Hapus</span>
                </span>
            </p>
            <button class="delete modal-closed" aria-label="close"></button>
          </header>
          <form method="post" action="" id="deleteForm">
            <section class="modal-card-body">
                @method('delete')
                @csrf
                <p>Apa anda yakin ingin menghapus data <span id="namaSekolahHps"></span> ?</p>
                <input type="hidden" name="id_sekolah" id="id_sekolah">
            </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-danger">Hapus</button>
                    <a href="#" class="button modal-closed">Batal</a>
                </footer>
            </form>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        
        var table = $('#table_weeks').DataTable();

        $('.addBtn').click(function () {
            $('#modal_tambah').addClass('is-active');
        })

        $('.importBtn').click(function () {
            $('#modal_import').addClass('is-active');
        })

        $('#table_weeks tbody').on('click', '.editBtn', function(){

            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#idSekolah').val(data[1]);
            $('#nama_sekolah').val(data[2]);
            $('#editForm').attr('action', '/sekolah/'+data[1]);

            $('#modal_edit').addClass('is-active');

        })

        $('#table_weeks tbody').on('click', '.deleteBtn', function(){

            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
            
            $('#idSekolah').val(data[1]);
            $('#namaSekolahHps').html(data[2]);
            $('#deleteForm').attr('action', '/sekolah/'+data[1]);

            $('#modal_hapus').addClass('is-active');
            
        })

        $('.modal-closed').on('click', function () {
            $('#modal_tambah').removeClass('is-active');
            $('#modal_edit').removeClass('is-active');
            $('#modal_hapus').removeClass('is-active');
            $('#modal_import').removeClass('is-active');
        })

        $('.deleteNotif').on('click', function () {
            $('.notification').addClass('is-hidden')
        })


        const fileInput = document.querySelector('#file-js-example input[type=file]');
        fileInput.onchange = () => {
            if (fileInput.files.length > 0) {
            const fileName = document.querySelector('#file-js-example .file-name');
            fileName.textContent = fileInput.files[0].name;
            }
        }

        // Initialize all input of date type.
        const calendars = bulmaCalendar.attach('[type="date"]', options);

        // Loop on each calendar initialized
        calendars.forEach(calendar => {
            // Add listener to select event
            calendar.on('select', date => {
                console.log(date);
            });
        });

        // // To access to bulmaCalendar instance of an element
        // const element = document.querySelector('#addStartDate');
        // if (element) {
        //     // bulmaCalendar instance is available as element.bulmaCalendar
        //     element.bulmaCalendar.on('select', datepicker => {
        //         console.log(datepicker.data.value());
        //     });
        // }

    });


</script>
@endsection
