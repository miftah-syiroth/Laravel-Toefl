<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal Mendaftar</th>
            <th>Ponsel</th>
            <th>Alamat</th>
            <th>Kelas</th>
            <th>Tanggal pelaksanaan</th>
            <th>Status</th>
            <th>Section 1 Dikerjakan</th>
            <th>Section 1 Benar</th>
            <th>Section 1 Skor</th>
            <th>Section 2 Dikerjakan</th>
            <th>Section 2 Benar</th>
            <th>Section 2 Skor</th>
            <th>Section 3 Dikerjakan</th>
            <th>Section 3 Benar</th>
            <th>Section 3 Skor</th>
            <th>Skor Akhir</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($participants as $key => $participant)
        <tr>
            <td>{{ $participant->name }}</td>
            <td>{{ $participant->email }}</td>
            <td>{{ $participant->created_at }}</td>
            <td>{{ $participant->phone }}</td>
            <td>{{ $participant->address }}</td>
            <td>{{ $participant->kelas->nama }}</td>
            <td>{{ $participant->kelas->pelaksanaan }}</td>
            <td>{{ $participant->status->status }}</td>
            <td>{{ $participant->score->section1_answered ?? '' }}</td>
            <td>{{ $participant->score->section1_correct ?? '' }}</td>
            <td>{{ $participant->score->section1_score ?? '' }}</td>
            <td>{{ $participant->score->section2_answered ?? '' }}</td>
            <td>{{ $participant->score->section2_correct ?? '' }}</td>
            <td>{{ $participant->score->section2_score ?? '' }}</td>
            <td>{{ $participant->score->section3_answered ?? '' }}</td>
            <td>{{ $participant->score->section3_correct ?? '' }}</td>
            <td>{{ $participant->score->section3_score ?? '' }}</td>
            <td>{{ $participant->score->final_score ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>