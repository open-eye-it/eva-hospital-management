<tr id="isme_row_{{ $insertData->isme_id }}">
    <td>{{ $insertData?->ism_recommendation }}</td>
    <td>{{ date('d M Y, h:i a', strtotime($insertData?->isme_given_datetime)) }}</td>
    <td>{{ date('d M Y, h:i a', strtotime($insertData?->isme_created_datetime)) }}</td>
    <td>{{ $insertData?->remark }}</td>
    <td>{{ $insertData?->AddedByUser?->person_name }}</td>
    <td>
        <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editExamination('{{ base64_encode($insertData->isme_id) }}')"></i>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removeExamination('{{ base64_encode($insertData->isme_id) }}')"></i>
    </td>
</tr>