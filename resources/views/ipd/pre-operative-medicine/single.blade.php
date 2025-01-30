<tr id="ipom_row_{{ $insertData->ipom_id }}">
    <td>{{ $insertData->recommendation }}</td>
    <td>{{ ($insertData->given_or_not == 1) ? 'Yes' : 'No' }}</td>
    <td>{{ $insertData->description }}</td>
    <td class="min-width-200">{{ $insertData?->AddedByData?->person_name }}</td>
    <td class="min-width-100">
        <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editPreMedicine('{{ base64_encode($insertData->ipom_id) }}')"></i>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerPreMedicine('{{ base64_encode($insertData->ipom_id) }}')"></i>
    </td>
</tr>