<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="{{ __('Name') }}" value="{{ isset($role) ? $role->name : old('name') }}" autofocus
                required>
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @if (!Auth::user()->roles->first()->hospital_id)
        <div class="col-md-6 mb-2">
            <label for="hospital_id_select">{{ trans('utilities/rolepermission/form.hospital') }}</label>
            <select class="form-control js-example-basic-multiple @error('hospital_id') is-invalid @enderror"
                name="hospital_id" id="hospital_id_select" required>
                <option value="" disabled>-- {{ trans('utilities/rolepermission/form.select_hospital') }} --
                </option>
                <option value="user_mta">
                    {{ __('User MTA') }}
                </option>
                @foreach ($hispotals as $hispotal)
                    <option value="{{ $hispotal->id }}"
                        {{ isset($role) && $role->hospital_id == $hispotal->id ? 'selected' : (old('hospital_id') == $hispotal->id ? 'selected' : '') }}>
                        {{ $hispotal->name }}
                    </option>
                @endforeach
            </select>
            @error('hospital_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    @else
        <input type="hidden" name="hospital_id" value="{{ Auth::user()->roles->first()->hospital_id }}">
    @endif
</div>

<div class="row">
    <div class="col-md-12">

        <label class="mb-1">Daftar {{ trans('utilities/rolepermission/form.permission') }}</label>
        @error('permissions')
            <div class="text-danger mb-2 mt-0">{{ $message }}</div>
        @enderror

        <hr>
        <div class="alert alert-success" role="alert">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAllPermissions" style="width: 20px; height: 20px; border: 2px solid green; margin-top: 2px; margin-right: 5px;" />
                <label class="form-check-label" for="selectAllPermissions" style="font-size: 18px;">
                    Select All Permissions
                </label>
            </div>
        </div>
    </div>

    @foreach (config('permission.permissions') as $permission)
        <div class="col-md-3"
            id="{{ ucwords($permission['group']) != 'Setting Apps' ? ucwords($permission['group']) : 'setting' }}">
            <div class="card border">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">{{ ucwords($permission['group']) }}</h4>
                        @foreach ($permission['access'] as $access)
                            <div class="form-check">
                                <input class="form-check-input permission-checkbox" type="checkbox"
                                    id="{{ str()->slug($access) }}" name="permissions[]" value="{{ $access }}"
                                    {{ isset($role) && $role->hasPermissionTo($access) ? 'checked' : '' }} />
                                <label class="form-check-label" for="{{ str()->slug($access) }}">
                                    {{ ucwords(__($access)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Add a click event to the "Select All" checkbox
        $('#selectAllPermissions').click(function() {
            // Check or uncheck all checkboxes with the class "permission-checkbox"
            $('.permission-checkbox').prop('checked', $(this).prop('checked'));
        });
    });
</script>
