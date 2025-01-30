@foreach($docList as $docData)
<tr id="doc_row_{{ $docData->id }}">
    <td>{{ $docData->ap_doc_name }}</td>
    <td>
        <!-- <a href="{{ route('appointment.doc.download', ['id' => base64_encode($docData->id)]) }}" download>{{ json_decode($docData->ap_doc)[0] }}</a> -->
        <a href="{{ url('/') . '/storage/'.json_decode($docData->ap_doc)[0] }}" target="_blank">{{ json_decode($docData->ap_doc)[0] }}</a>
    </td>
    <td>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerDoc('{{ $docData->id }}')"></i>
    </td>
</tr>
@endforeach