<tr id="row_{{ $inserData->tpl_id }}">
    <td>{{ $inserData->tpl_desc }}</td>
    <td>{{ $inserData->tpl_amount }}</td>
    <td>{{ date('d M Y', strtotime($inserData->created_at)) }}</td>
    <td>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerCharge('{{ base64_encode($inserData->tpl_id) }}', '{{ base64_encode($inserData->tr_id) }}')"></i>
        <i title="Print Receipt" class="flaticon flaticon2-print icon-3x cursor_pointer" onclick="printReceipt('{{ base64_encode($inserData->tpl_id) }}')"></i>
    </td>
</tr>