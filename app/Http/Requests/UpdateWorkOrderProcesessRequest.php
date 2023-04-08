<?php

namespace App\Http\Requests;

use App\Rules\AllowIntegerOrDouble;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkOrderProcesessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'initial_temperature' => ['required', new AllowIntegerOrDouble],
            'initial_humidity' => ['required', new AllowIntegerOrDouble],
            'final_temperature' => ['required', new AllowIntegerOrDouble],
            'final_humidity' => ['required', new AllowIntegerOrDouble],
            'status' => 'required|in:Doing,Finish',
            'work_date' => 'required|date',
            'mesh_voltage' => ['required', new AllowIntegerOrDouble],
            'ups' => ['required', new AllowIntegerOrDouble],
            'grounding' => ['required', new AllowIntegerOrDouble],
            'leakage_electric' => ['required', new AllowIntegerOrDouble],
            'electrical_safety_note' => 'string|nullable',
            'calibration_performance_is_feasible_to_use' => 'required|boolean',
            'calibration_performance_calibration_price' => ['required', new AllowIntegerOrDouble],
            'calibration_performance_tool_performance_check.*' => [function ($attribute, $value, $fail) {
                if (!(request()->calibration_performance_tool_performance_check[0] == null && count(request()->calibration_performance_tool_performance_check) == 1)) {
                    if (count(request()->calibration_performance_tool_performance_check) > 1) {
                        if (request()->calibration_performance_tool_performance_check[0] == null && explode('.', $attribute)[count(explode('.', $attribute)) - 1] == 0) {
                            $fail('Form Calibration is required');
                        } else if (explode('.', $attribute)[count(explode('.', $attribute)) - 1] > 0 && $value == '') {
                            $fail('Form Calibration is required');
                        }
                    }
                }
            }],
            'calibration_performance_setting.*' => ['nullable', 'string'],
            'calibration_performance_measurable.*' => ['nullable', 'string'],
            'calibration_performance_reference_value.*' => ['nullable', 'string'],
            'calibration_performance_is_good.*' => ['nullable', 'boolean'],
            'physical_check.*' => [function ($attribute, $value, $fail) {
                if (!(request()->physical_check[0] == null && count(request()->physical_check) == 1)) {
                    if (count(request()->physical_check) > 1) {
                        if (request()->physical_check[0] == null && explode('.', $attribute)[count(explode('.', $attribute)) - 1] == 0) {
                            $fail('Form Physical Check is required');
                        } else if (explode('.', $attribute)[count(explode('.', $attribute)) - 1] > 0 && $value == '') {
                            $fail('Form Physical Check is required');
                        }
                    }
                }
            }],
            'physical_health.*' => ['nullable', 'in:good,minor damage,major damage'],
            'physical_cleanliness.*' => ['nullable', 'in:clean,dirty'],
            'function_check_information.*' => [function ($attribute, $value, $fail) {
                if (!(request()->function_check_information[0] == null && count(request()->function_check_information) == 1)) {
                    if (count(request()->function_check_information) > 1) {
                        if (request()->function_check_information[0] == null && explode('.', $attribute)[count(explode('.', $attribute)) - 1] == 0) {
                            $fail('Form Information is required');
                        } else if (explode('.', $attribute)[count(explode('.', $attribute)) - 1] > 0 && $value == '') {
                            $fail('Form Information is required');
                        }
                    }
                }
            }],
            'function_check_status.*' => ['nullable', 'in:Yes,No,NA'],
            'equipment_inspect_information.*' => [function ($attribute, $value, $fail) {
                if (!(request()->physical_check[0] == null && count(request()->equipment_inspect_information) == 1)) {
                    if (count(request()->equipment_inspect_information) > 1) {
                        if (request()->equipment_inspect_information[0] == null && explode('.', $attribute)[count(explode('.', $attribute)) - 1] == 0) {
                            $fail('Form Information is required');
                        } else if (explode('.', $attribute)[count(explode('.', $attribute)) - 1] > 0 && $value == '') {
                            $fail('Form Information is required');
                        }
                    }
                }
            }],
            'equipment_inspect_status.*' => ['nullable', 'in:Yes,No,NA'],
            'tool_maintenance_information.*' => [function ($attribute, $value, $fail) {
                if (!(request()->physical_check[0] == null && count(request()->tool_maintenance_information) == 1)) {
                    if (count(request()->tool_maintenance_information) > 1) {
                        if (request()->tool_maintenance_information[0] == null && explode('.', $attribute)[count(explode('.', $attribute)) - 1] == 0) {
                            $fail('Form Information is required');
                        } else if (explode('.', $attribute)[count(explode('.', $attribute)) - 1] > 0 && $value == '') {
                            $fail('Form Information is required');
                        }
                    }
                }
            }],
            'tool_maintenance_status.*' => ['nullable', 'in:Yes,No,NA'],
        ];
    }
}
