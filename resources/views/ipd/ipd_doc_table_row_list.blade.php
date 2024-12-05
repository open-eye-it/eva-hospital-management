@foreach($docList as $docData)
<tr id="doc_row_{{ $docData->id }}">
    <td>{{ $docData->ipd_doc_name }}</td>
    <td>
        <a href="{{ url('/').ImagePath($docData->ipd_doc) }}">{{ $docData->ipd_doc }}</a>
    </td>
    <td>
        <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerDoc('{{ $docData->id }}')"></i>
    </td>
</tr>
@endforeach