<tr id="ism_row_{{ $insertData->ism_id }}">
    <td>{{ $insertData->ism_recommendation }}</td>
    <td>{{ $insertData?->AddedByUser?->person_name }}</td>
    <td>{{ date('d M Y, h:i a', strtotime($insertData->created_at)) }}</td>
    <td>
    <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editRecommendation('{{ base64_encode($insertData->ism_id) }}')"></i>
    <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removeRecommendation('{{ base64_encode($insertData->ism_id) }}')"></i>
    </td>
</tr>