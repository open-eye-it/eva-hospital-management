@foreach($indoorSheeList as $data)
<tr id="is_row_{{ $data->is_id }}">
    <td>{{ date('d M Y, h:i a', strtotime($data->is_date)) }}</td>
    <td>{{ $data->is_findings }}</td>
    <td>{{ $data?->AddedByUser?->person_name }}</td>
    <td>
    <i title="Add Medicine" class="la la-plus icon-3x cursor_pointer" onclick="showRecommenadtion('{{ base64_encode($data->is_id) }}')"></i>
        <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editFindings('{{ base64_encode($data->is_id) }}')"></i>
        <!-- <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerFindings('{{ base64_encode($data->is_id) }}')"></i> -->
    </td>
</tr>
@endforeach