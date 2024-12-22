@foreach($indoorSheeList as $data)
<tr id="ism_row_{{ $data->ism_id }}">
    <td>{{ $data->ism_recommendation }}</td>
    <td>{{ $data?->AddedByUser?->person_name }}</td>
    <td>
        <input type="datetime-local" name="isme_given_datetime[]" id="isme_given_datetime" class="form-control">
    </td>
    <td>
        <textarea name="ramerakData" rows="5" class="remarkMessage" id="ramerakData" value=""></textarea>
    </td>
    <td>
        <input type="checkbox" class="form-control" name="exm_checked[]" id="exm_checked" {{ ($data->ism_checked_by != '') ? 'checked' : '' }}>
        <input type="hidden" name="exm_id[]" id="exm_id" value="{{ $data?->ism_recommendation }}">
        <input type="hidden" name="is_id[]" id="is_id" value="{{ $data?->indoorSheetData?->is_id }}">
    </td>
</tr>
@endforeach