<tr id="is_row_{{ $insertData->is_id }}">
    <td>{{ date('d M Y, h:i a', strtotime($insertData->is_date)) }}</td>
    <td>{{ $insertData->is_findings }}</td>
    <td>{{ $insertData?->AddedByUser?->person_name }}</td>
    <td>
    <i title="Add Medicine" class="la la-plus icon-3x cursor_pointer" onclick="showRecommenadtion('{{ base64_encode($insertData->is_id) }}')"></i>
        <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editFindings('{{ base64_encode($insertData->is_id) }}')"></i>
        <!-- <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerFindings('{{ base64_encode($insertData->is_id) }}')"></i> -->
    </td>
</tr>