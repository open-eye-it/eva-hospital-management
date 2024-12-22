@foreach($examintionList as $data)
<tr id="isme_row_{{ $data->isme_id }}">
    <td>{{ $data->is_id }}</td>
    <td>{{ $data?->ism_recommendation }}</td>
    <td>{{ date('d M Y, h:i:s a', strtotime($data?->isme_given_datetime)) }}</td>
    <td>{{ date('d M Y, h:i:s a', strtotime($data?->isme_created_datetime)) }}</td>
    <td>{{ $data?->remark }}</td>
    <td>{{ $data?->AddedByUser?->person_name }}</td>
    <td></td>
</tr>
@endforeach