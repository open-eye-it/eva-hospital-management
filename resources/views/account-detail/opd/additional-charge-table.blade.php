@foreach ($list as $charge) {
<tr id="row_{{ $charge->apac_id }}">
    <td>{{ $charge->apac_id }}</td>
    <td>{{ $charge->apac_desc }}</td>
    <td>{{ $charge->apac_qty }}</td>
    <td>{{ $charge->apac_charge }}</td>
    <td>{{ $charge->apac_final_charge }}</td>
    <td><i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerCharge('{{ $charge->apac_id }}', '{{ base64_encode($ap_id) }}', '{{ base64_encode($queryData) }}')"></i></td>
</tr>
@endforeach