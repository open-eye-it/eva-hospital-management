@foreach($examintionList as $data)
<tr id="isme_row_{{ $data->isme_id }}">
    <td>{{ $data?->ism_recommendation }}</td>
    <td>{{ date('d M Y, h:i a', strtotime($data?->isme_given_datetime)) }}</td>
    <td>{{ date('d M Y, h:i a', strtotime($data?->isme_created_datetime)) }}</td>
    <td>{{ $data?->remark }}</td>
    <td>{{ $data?->AddedByUser?->person_name }}</td>
    <td>
        <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editExamination('{{ base64_encode($data->isme_id) }}')"></i>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removeExamination('{{ base64_encode($data->isme_id) }}')"></i>
    </td>
</tr>
@endforeach