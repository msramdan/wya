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
            'executor' => 'required|in:vendor_or_supplier,technician',
            'work_executor_technician_id' => 'required_if:executor,technician|exists:employees,id',
            'work_executor_vendor_id' => 'required_if:executor,vendor_or_supplier|exists:vendors,id',
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
                if (!(request()->equipment_inspect_information[0] == null && count(request()->equipment_inspect_information) == 1)) {
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
                if (!(request()->tool_maintenance_information[0] == null && count(request()->tool_maintenance_information) == 1)) {
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
            'replacement_sparepart_id.*' => [function ($attribute, $value, $fail) {
                if (!(request()->replacement_sparepart_id[0] == null && count(request()->replacement_sparepart_id) == 1)) {
                    if (count(request()->replacement_sparepart_id) > 1) {
                        if (request()->replacement_sparepart_id[0] == null && explode('.', $attribute)[count(explode('.', $attribute)) - 1] == 0) {
                            $fail('Form Sparepart is required');
                        } else if (explode('.', $attribute)[count(explode('.', $attribute)) - 1] > 0 && $value == '') {
                            $fail('Form Sparepart is required');
                        }
                    }
                }
            }],
            'replacement_price.*' => [function ($attribute, $value, $fail) {
                if (!request()->$attribute && request()->replacement_sparepart_id[explode('.', $attribute)[count(explode('.', $attribute)) - 1]]) {
                    $fail('Form Replacement Price is required');
                }
            }],
            'replacement_amount.*' => [function ($attribute, $value, $fail) {
                if (!request()->$attribute && request()->replacement_sparepart_id[explode('.', $attribute)[count(explode('.', $attribute)) - 1]]) {
                    $fail('Form Replacement Amount is required');
                }
            }],
            'replacement_of_part_service_price' => ['required', new AllowIntegerOrDouble],
            'wo_doc_document_name.*' => [function ($attribute, $value, $fail) {
                if (!(request()->wo_doc_document_name[0] == null && count(request()->wo_doc_document_name) == 1)) {
                    if (count(request()->wo_doc_document_name) > 1) {
                        if (request()->wo_doc_document_name[0] == null && explode('.', $attribute)[count(explode('.', $attribute)) - 1] == 0) {
                            $fail('Form Document Name is required');
                        } else if (explode('.', $attribute)[count(explode('.', $attribute)) - 1] > 0 && $value == '') {
                            $fail('Form Document Name is required');
                        }
                    }
                }

                if (request()->$attribute && isset(request()->old_wo_doc_file[explode('.', $attribute)[count(explode('.', $attribute)) - 1]])) {
                } else if (!isset(request()->wo_doc_file[explode('.', $attribute)[count(explode('.', $attribute)) - 1]]) && request()->$attribute) {
                    $fail('Form Document File is required');
                } else if (isset(request()->wo_doc_file[explode('.', $attribute)[count(explode('.', $attribute)) - 1]]) && request()->$attribute) {
                    if (!request()->file('wo_doc_file')[explode('.', $attribute)[count(explode('.', $attribute)) - 1]]) {
                        $fail('Form Document File must be file');
                    }
                }
            }],
            'wo_doc_description.*' => ['nullable', 'string'],
        ];
    }
}
