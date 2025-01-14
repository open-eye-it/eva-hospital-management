@foreach($medicineList as $data)
<tr id="ipom_row_{{ $data->ipom_id }}">
    <td>{{ $data->recommendation }}</td>
    <td>{{ ($data->given_or_not == 1) ? 'Yes' : 'No' }}</td>
    <td>{{ $data->description }}</td>
    <td class="min-width-200">{{ $data?->AddedByData?->person_name }}</td>
    <td class="min-width-100">
        <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editPreMedicine('{{ base64_encode($data->ipom_id) }}')"></i>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerPreMedicine('{{ base64_encode($data->ipom_id) }}')"></i>
    </td>
</tr>
@endforeach