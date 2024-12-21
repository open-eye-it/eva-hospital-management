@foreach($indoorSheeList as $data)
<tr id="exs_row_{{ $data->is_id }}">
    <td>{{ date('d M Y', strtotime($data->is_date)) }}</td>
    <td>{{ $data->is_findings }}</td>
    <td>{{ $data?->AddedByUser?->person_name }}</td>
    <td>
        <i title="Add Medicine" class="la la-plus icon-3x cursor_pointer" onclick="showExaminationRecommenadtion('{{ base64_encode($data->is_id) }}')"></i>
    </td>
</tr>
@endforeach