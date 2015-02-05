@foreach ($customFields as $customField)
<div class="form-group">
	<label>{{{ $customField->field_label }}}</label>
	@if ($customField->field_type == 'dropdown')
	{{ Form::select('custom[' . $customField->column_name . ']', array_combine(array_merge(array(''), explode(',', $customField->field_meta)), array_merge(array(''), explode(',', $customField->field_meta))), null, array('class' => 'custom-form-field form-control', 'data-field-name' => $customField->column_name)) }}
	@else
	{{ call_user_func_array('Form::' . $customField->field_type, array('custom[' . $customField->column_name . ']', null, array('class' => 'custom-form-field form-control', 'data-field-name' => $customField->column_name))) }}
	@endif
</div>
@endforeach