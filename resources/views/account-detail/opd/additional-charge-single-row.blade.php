<tr id="row_{{ $data->apac_id }}">
    <td>{{ $data->apac_id }}</td>
    <td>{{ $data->apac_desc }}</td>
    <td>{{ $data->apac_qty }}</td>
    <td>{{ $data->apac_charge }}</td>
    <td>{{ $data->apac_final_charge }}</td>
    <td>{{ ucfirst($data->apac_payment_mode) }}</td>
    <td><i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerCharge('{{ $data->apac_id }}', '{{ base64_encode($data->ap_id) }}', '{{ base64_encode($queryData) }}')"></i></td>
</tr>