@extends('layouts.app')

@section('title', __('Edit Employees'))
@push('css')
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ trans('employee/index.head') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/panel">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('employees.index') }}">{{ trans('employee/index.head') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('Edit') }}
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('employees.update', $employee->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @include('employees.include.form_edit')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i
                                        class="mdi mdi-arrow-left-thin"></i> {{ __('Kembali') }}</a>

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>
                                    {{ __('Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const _temp = '<option value="" selected disabled>-- Select --</option>';
        $('#hospital_id').change(function() {
            $('#employee-type-id, #departement-id, #position-id').html(_temp);
            if ($(this).val() != "") {
                getEmployeeType($(this).val());
                getDepartment($(this).val());
                getPosition($(this).val());
            }
        })

        function getDepartment(hospitalId) {
            let url = '{{ route('api.getDepartment', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#departement-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.name_department}</option>`
                    });
                    $('#departement-id').html(_temp + options)
                    $('#departement-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#departement-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getEmployeeType(hospitalId) {
            let url = '{{ route('api.getEmployeeType', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#employee-type-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.name_employee_type}</option>`
                    });
                    $('#employee-type-id').html(_temp + options)
                    $('#employee-type-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#employee-type-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getPosition(hospitalId) {
            let url = '{{ route('api.getPosition', ':id') }}';
            url = url.replace(':id', hospitalId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#position-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.name_position}</option>`
                    });
                    $('#position-id').html(_temp + options)
                    $('#position-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#position-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }
    </script>

    {{-- gmaps --}}
    <script>
        let map;
        let geocoder;
        let autocomplete;
        let initialMarker; // Marker dari database
        let markers = [];

        function initMap() {
            var initialLatitude = parseFloat("{{ $employee->latitude }}");
            var initialLongitude = parseFloat("{{ $employee->longitude }}");

            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: initialLatitude,
                    lng: initialLongitude
                },
                zoom: 12
            });

            // Tambahkan marker di posisi awal dari database
            initialMarker = new google.maps.Marker({
                position: {
                    lat: initialLatitude,
                    lng: initialLongitude
                },
                map: map,
                draggable: true // Sesuaikan dengan kebutuhan
            });

            markers.push(initialMarker);

            geocoder = new google.maps.Geocoder();

            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('locationInput'), {
                    types: ['geocode']
                }
            );
            autocomplete.addListener('place_changed', onPlaceChanged);

            map.addListener('click', onMapClick);
        }

        function onMapClick(event) {
            const clickedLatLng = event.latLng;

            // Periksa apakah ada marker di posisi yang sama
            const existingMarkerIndex = findExistingMarkerIndex(clickedLatLng);

            if (existingMarkerIndex !== -1) {
                // Jika marker sudah ada, ganti posisi marker yang sudah ada
                markers[existingMarkerIndex].setPosition(clickedLatLng);
            } else {
                // Jika tidak ada, tambahkan marker baru
                clearMarkers();

                const marker = new google.maps.Marker({
                    position: clickedLatLng,
                    map: map,
                    draggable: true
                });

                document.getElementById('latitude').value = clickedLatLng.lat();
                document.getElementById('longitude').value = clickedLatLng.lng();

                marker.addListener('dragend', onMarkerDragEnd);

                markers.push(marker);
            }
        }

        function onMarkerDragEnd() {
            document.getElementById('latitude').value = markers[0].getPosition().lat();
            document.getElementById('longitude').value = markers[0].getPosition().lng();
        }

        function onPlaceChanged() {
            clearMarkers();

            const place = autocomplete.getPlace();
            if (place.geometry) {
                map.panTo(place.geometry.location);
                map.setZoom(15);

                const marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map
                });

                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();

                markers.push(marker);
            } else {
                document.getElementById('locationInput').placeholder = 'Enter location';
            }
        }

        function showMyLocation() {
            clearMarkers();

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const myLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                    map.panTo(myLocation);
                    map.setZoom(15);

                    const marker = new google.maps.Marker({
                        position: myLocation,
                        map: map,
                        title: 'My Location'
                    });

                    document.getElementById('latitude').value = myLocation.lat();
                    document.getElementById('longitude').value = myLocation.lng();

                    markers.push(marker);
                }, function(error) {
                    console.error('Error getting location:', error.message);
                    alert('Error getting your location. Please make sure location services are enabled.');
                });
            } else {
                alert('Geolocation is not supported by your browser.');
            }
        }

        function clearMarkers() {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
            // Tambahkan marker dari database kembali setelah menghapus marker
            markers.push(initialMarker);
        }

        function findExistingMarkerIndex(latLng) {
            // Fungsi untuk mencari indeks marker yang sudah ada di dalam array
            for (let i = 0; i < markers.length; i++) {
                if (markers[i].getPosition().equals(latLng)) {
                    return i;
                }
            }
            return -1; // Mengembalikan -1 jika marker tidak ditemukan
        }
    </script>
    <script>
        const googleMapsApiKey = '{{ config('app.google_maps_api_key') }}';
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api_key') }}&libraries=places&callback=initMap">
    </script>

    <script>
        const options_temp = '<option value="" selected disabled>-- Select --</option>';

        $('#provinsi-id').change(function() {
            $('#kabkot-id, #kecamatan-id, #kelurahan-id').html(options_temp);
            if ($(this).val() != "") {
                getKabupatenKota($(this).val());
            }
            // onValidation('provinsi')
        })

        $('#kabkot-id').change(function() {
            $('#kecamatan-id, #kelurahan-id').html(options_temp);
            if ($(this).val() != "") {
                getKecamatan($(this).val());
            }
            // onValidation('kota')
        })

        $('#kecamatan-id').change(function() {
            $('#kelurahan-id').html(options_temp);
            if ($(this).val() != "") {
                getKelurahan($(this).val());
            }
            //onValidation('kecamatan')
        })

        $('#kelurahan-id').change(function() {
            if ($(this).val() != "") {
                $('#zip-kode').val($(this).find(':selected').data('pos'))
            } else {
                $('#zip-kode').val('')
            }
            //onValidation('kelurahan')
        });


        function getKabupatenKota(provinsiId) {
            let url = '{{ route('api.kota', ':id') }}';
            url = url.replace(':id', provinsiId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#kabkot-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.kabupaten_kota}</option>`
                    });
                    $('#kabkot-id').html(options_temp + options)
                    $('#kabkot-id').prop('disabled', false);
                },
                error: function(err) {
                    $('#kabkot-id').prop('disabled', false);
                    alert(JSON.stringify(err))
                }

            })
        }

        function getKecamatan(kotaId) {
            let url = '{{ route('api.kecamatan', ':id') }}';
            url = url.replace(':id', kotaId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#kecamatan-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}">${value.kecamatan}</option>`
                    });
                    $('#kecamatan-id').html(options_temp + options);
                    $('#kecamatan-id').prop('disabled', false);
                },
                error: function(err) {
                    alert(JSON.stringify(err))
                    $('#kecamatan-id').prop('disabled', false);
                }
            })
        }

        function getKelurahan(kotaId) {
            let url = '{{ route('api.kelurahan', ':id') }}';
            url = url.replace(':id', kotaId)
            $.ajax({
                url,
                method: 'GET',
                beforeSend: function() {
                    $('#kelurahan-id').prop('disabled', true);
                },
                success: function(res) {
                    const options = res.data.map(value => {
                        return `<option value="${value.id}" data-pos="${value.kd_pos}">${value.kelurahan}</option>`
                    });
                    $('#kelurahan-id').html(options_temp + options);
                    $('#kelurahan-id').prop('disabled', false);
                },
                error: function(err) {
                    alert(JSON.stringify(err))
                    $('#kelurahan-id').prop('disabled', false);
                }
            })
        }
    </script>
@endpush
