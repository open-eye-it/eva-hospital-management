@foreach($indoorSheeList as $data)
<tr id="ism_row_{{ $data->ism_id }}">
    <td>{{ $data->ism_recommendation }}</td>
    <td>{{ $data?->AddedByUser?->person_name }}</td>
    <td>{{ $data?->checkedByUser?->person_name }}</td>
    <td>
        <input type="checkbox" class="form-control w-25" name="exm_checked[]" id="exm_checked" {{ ($data->ism_checked_by != '') ? 'checked' : '' }}>
        <input type="hidden" name="exm_id[]" id="exm_id" value="{{ $data?->ism_id }}">
    </td>
</tr>
@endforeach