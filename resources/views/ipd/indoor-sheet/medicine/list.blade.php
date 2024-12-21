@foreach($indoorSheeList as $data)
<tr id="ism_row_{{ $data->ism_id }}">
    <td>{{ $data->ism_recommendation }}</td>
    <td>{{ $data?->AddedByUser?->person_name }}</td>
    <td>{{ $data?->checkedByUser?->person_name }}</td>
    <td>
        <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editRecommendation('{{ base64_encode($data->ism_id) }}')"></i>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removeRecommendation('{{ base64_encode($data->ism_id) }}')"></i>
    </td>
</tr>
@endforeach