@foreach($paymentList as $payment)
<tr id="row_{{ $payment->tpl_id }}">
    <td>{{ $payment->tpl_desc }}</td>
    <td>{{ $payment->tpl_amount }}</td>
    <td>{{ date('d M Y', strtotime($payment->created_at)) }}</td>
    <td>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerCharge('{{ base64_encode($payment->tpl_id) }}', '{{ base64_encode($payment->tr_id) }}')"></i>
        <i title="Print Receipt" class="flaticon flaticon2-print icon-3x cursor_pointer" onclick="printReceipt('{{ base64_encode($payment->tpl_id) }}')"></i>
    </td>
</tr>
@endforeach