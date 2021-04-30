@extends('layouts.template_app')

@section('title', '- Menu Week')

@section('content')

@include('includes.navbar')

<div class="container">
    <div class="columns">
        <div class="column is-8">
            <h1 class="title ">Week</h1>
            @if (session('status'))
                <div class="notification is-info column is-5">
                    <button class="delete deleteNotif"></button>
                    {{ session('status') }}
                </div>
            @else 
                @if($errors->any())
                <div class="notification is-danger column is-5">
                    <button class="delete deleteNotif"></button>
                    @foreach ($errors->all() as $error)
                    {{ $error }} <br/>
                    @endforeach
                </div>
                @endif
            @endif
        </div>
        <div class="column is-4">
            <div class="buttons is-pulled-right">
                <a href="#" class="button is-link importBtn ">Import </a>
                <a href="#" class="button is-info addBtn ">Tambah </a>
            </div>
        </div>
    </div>
    <div class="columns is-multiline">

        <div class="column is-12 ">
            
            <div class="columns">
                <div class="column">
                    <div class="tabel-container">
                        <table class="table is-fullwidth" id="table_weeks">
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
          <form method="post" action="{{ route('admin.week.import') }}" id="importForm" enctype="multipart/form-data">
            <section class="modal-card-body">
                @csrf
                <div class="field">
                    <h3><label class="label" >Peringatan ! </label></h3>
                    <p>Sebelum anda mengimport file excelnya pastikan anda sudah mendownload File excel sesuai dengan format kami, 
                        anda bisa mendownloadnya <a href="{{ route('admin.week.downloadMWeek') }}" target="_self">disini!</a>
                    </p>
                </div>
                <div class="field">
                    <label class="label" >File Excel</label>
                    <div id="file-js-example" class="file has-name">
                        <label class="file-label">
                            <input class="file-input" type="file" name="file_excel_week" required>
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
                    <p class="help">format yang diperbolehkan xls, xlsx .</p>
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
          <form method="post" action="{{ url('admin/week') }}" id="addForm">
            <section class="modal-card-body">
                @csrf
                <div class="field">
                    <label class="label" for="week">Week</label>
                    <div class="field">
                        <div class="control">
                            <input name="week" class="input @error('week') is-invalid @enderror" type="text" placeholder="week" required>
                        </div>
                    </div>
                    @error('week')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="field">
                    <label class="label" for="year">Year</label>
                    <div class="field">
                        <div class="control">
                            <input name="year" class="input @error('year') is-invalid @enderror" type="text" placeholder="year" required>
                        </div>
                    </div>
                    @error('year')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="field">
                    <label class="label">Start Date</label>
                    <p class="control">
                      <input class="input" type="date" name="start_date" required>
                      {{-- <p class="help">To view a demo just click into the input above.</p> --}}
                    </p>
                </div>
                <div class="field">
                    <label class="label">End Date</label>
                    <p class="control">
                        <input class="input" type="date" name="end_date" required>
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
                            <input name="week" id="week" class="input @error('week') is-invalid @enderror" type="text" placeholder="week" required>
                        </div>
                    </div>
                    @error('week')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="field">
                    <label class="label" for="year">Year</label>
                    <div class="field">
                        <div class="control">
                            <input name="year" id="year" class="input @error('year') is-invalid @enderror" type="text" placeholder="year" required>
                        </div>
                    </div>
                    @error('year')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="field">
                    <label class="label" for="start_date">Start Date</label>
                    <div class="field">
                        <div class="control">
                            <input name="start_date" id="start_date" class="input" type="date" placeholder="start_date" required>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="end_date">End Date</label>
                    <div class="field">
                        <div class="control">
                            <input name="end_date" id="end_date" class="input" type="date" placeholder="end_date" required>
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
                <p>Apa anda yakin ingin menghapus data Minggu ke-<span id="weekHps"></span> ?</p>
                <input type="hidden" name="id_week" id="id_week">
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
            
            var dateStart    = new Date(data[4]),
            yrStart      = dateStart.getFullYear(),
            monthStart   = (dateStart.getMonth()+1) < 10 ? '0' + (dateStart.getMonth()+1) : (dateStart.getMonth()+1),
            dayStart     = dateStart.getDate()  < 10 ? '0' + dateStart.getDate()  : dateStart.getDate(),
            tglAwal = yrStart + '-' + monthStart + '-' + dayStart;

            var dateEnd    = new Date(data[5]),
            yrEnd      = dateEnd.getFullYear(),
            monthEnd   = (dateEnd.getMonth()+1) < 10 ? '0' + (dateEnd.getMonth()+1) : (dateEnd.getMonth()+1),
            dayEnd     = dateEnd.getDate()  < 10 ? '0' + dateEnd.getDate()  : dateEnd.getDate(),
            tglAkhir = yrEnd + '-' + monthEnd + '-' + dayEnd;

            console.log(tglAwal);
            console.log(tglAkhir);

            $('#idWeek').val(data[1]);
            $('#week').val(data[2]);
            $('#year').val(data[3]);
            $('#start_date').val(tglAwal);
            $('#end_date').val(tglAkhir);
            $('#editForm').attr('action', '/admin/week/'+data[1]);

            $('#modal_edit').addClass('is-active');

        })

        $('#table_weeks tbody').on('click', '.deleteBtn', function(){

            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
            
            $('#id_week').val(data[1]);
            $('#weekHps').html(data[2]);
            $('#deleteForm').attr('action', '/admin/week/'+data[1]);

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

        // // Initialize all input of date type.
        // const calendars = bulmaCalendar.attach('[type="date"]', {
        //     displayMode: 'default',
        //     closeOnSelect: false,
        // });

        // // Loop on each calendar initialized
        // calendars.forEach(calendar => {
        //     // Add listener to select event
        //     calendar.on('select', date => {
        //         console.log(date);
        //     });
        // });

        // // To access to bulmaCalendar instance of an element
        // const element = document.querySelector('#addStartDate');
        
        // if (element) {
        //     // bulmaCalendar instance is available as element.bulmaCalendar
        //     element.bulmaCalendar.on('click', datepicker => {
        //         console.log(datepicker.data.value());
        //     });
        // }


    });

    // function convert(str) {
    // var date = new Date(str),
    //     mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    //     day = ("0" + date.getDate()).slice(-2);
    // return [date.getFullYear(), mnth, day].join("-");
    // }

</script>
@endsection
